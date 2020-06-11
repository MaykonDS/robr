<?php
// Banco
//	id_zona 	num_secao 	desc_faixa_etaria 	id_escolaridade 	sexo 	qtd 	id_ano 	

//Planilha
//NUM_ZONA(0);NUM_SECAO(1);DESC_FAIXA_ETARIA(2);DESC_GRAU_DE_ESCOLARIDADE(3);DESCRICAO_SEXO(4);QTD_ELEITORES_NO_PERFIL(5)


function importPerfilEleitor($file, $anoString, $conn){
    $map = array();
    $nextNumberSend = 101;
    if (($handle = fopen($file, "r")) !== FALSE) {
        $linhas = countRowsFile($file);
        echo $linhas." Linhas para importar!";
        if ($linhas > 50000){
            $split = true;
            $nextNumberSend = 5;
        } else {
            $split = false;
        }
        $row = 1;
        $secureN = 0;
	    while ((@$data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            set_time_limit(0);
            $num = count($data); //Quantidade de campos
            // Coluna
            $isFirstTime = $row == 1;
            $row++;
            // Conteúdo
            for ($c=0; $c < $num; $c++) {
                $dado = $data[$c];//mb_convert_encoding($data[$c], 'ISO-8859-15', 'UTF-8');
                if (!$isFirstTime){
				    $dado = utf8_decode($dado);
				    $dados["$c"] = utf8_encode($dado);
                }
            }

            if ($isFirstTime) {
                $querry = "INSERT INTO perfil_eleitorado (id_zona,num_secao,desc_faixa_etaria,id_escolaridade,sexo,qtd,id_ano) VALUES ";
			    $id_ano = verifyAno($anoString, $conn);	
            } else {
                if (@$map[$dados[0]] == null) {
                    $id_zona = verifyZona($dados[0], $conn);
                    $map[$dados[0]] = $id_zona;
                } else {
                    $id_zona = $map[$dados[0]];
                }

                $id_escolaridade = verifyEscolaridade($dados[3], $conn);

                if ($secureN < floor(($row/$linhas)*100)){
                    $secureN++;
                    echo "<br>".$secureN."%";
                    if ($secureN == $nextNumberSend && $split && $secureN != 100){
                        $nextNumberSend +=5;
                        $querry = substr($querry, 0, strlen($querry)-1);
                        //var_dump(utf8_encode($querry));
	                    mysqli_query($conn, $querry);
                        echo 'Dados importados!';
                        $querry = "INSERT INTO perfil_eleitorado (id_zona,num_secao,desc_faixa_etaria,id_escolaridade,sexo,qtd,id_ano) VALUES ";
                    }
                } else {
                    echo ".";
                }
                
                $querry = $querry."('$id_zona','$dados[1]','$dados[2]','$id_escolaridade','$dados[4]','$dados[5]','$id_ano'),";
            }
        }
        $querry = substr($querry, 0, strlen($querry)-1);
        //var_dump(utf8_encode($querry));
	    mysqli_query($conn, $querry);
        echo 'Dados importados!';
        fclose($handle);
    }
}
?>
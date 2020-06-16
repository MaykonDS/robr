<?php
// Banco
//id_zona 	num_secao 	desc_cargo 	num_votavel 	qtd_votos 	id_ano  turno

//Planilha
//TURNO(0);NUM_ZONA(1);NUM_SECAO(2);DESCRICAO_CARGO(3);NUM_VOTAVEL(4);QTDE_VOTOS(5)

function importVotoSecao($file, $anoString, $conn){
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
                $querry = "INSERT INTO votacao_zona_secao (id_zona,num_secao,desc_cargo,num_votavel,qtd_votos,id_ano, turno) VALUES ";
			    $id_ano = verifyAno($anoString, $conn);	
            } else {
                if (@$map[$dados[1]] == null) {
                    $id_zona = verifyZona($dados[1], $conn);
                    $map[$dados[1]] = $id_zona;
                } else {
                    $id_zona = $map[$dados[1]];
                }

                if ($secureN < floor(($row/$linhas)*100)){
                    $secureN++;
                    echo "<br>".$secureN."%";
                    if ($secureN == $nextNumberSend && $split && $secureN != 100){
                        $nextNumberSend +=5;
                        $querry = substr($querry, 0, strlen($querry)-1);
                        //var_dump(utf8_encode($querry));
	                    mysqli_query($conn, $querry);
                        echo 'Dados importados!';
                        $querry = "INSERT INTO votacao_zona_secao (id_zona,num_secao,desc_cargo,num_votavel,qtd_votos,id_ano, turno) VALUES ";
                    }
                } else {
                    echo ".";
                }
                
                $querry = $querry."('$id_zona','$dados[2]','$dados[3]','$dados[4]','$dados[5]','$id_ano', '$dados[0]'),";
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
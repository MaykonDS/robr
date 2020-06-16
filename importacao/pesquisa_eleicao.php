<?php
// Banco
//	id_zona 	num_secao 	desc_faixa_etaria 	id_escolaridade 	sexo 	qtd 	id_ano 	

//Planilha
//DATA(0),NOME(1),IDADE(2),SEXO(3),ESCOLARIDADE(4),BAIRRO(5),PREFEITO(6),PARTIDO_PREFEITO(7)
//VEREADOR(8),PARTIDO_VEREADOR(9),ANO(9),RELIGIÃO(11),RENDA(12),COR(13)

function importPesquisa($file, $anoString, $conn){
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
                $querry = "INSERT INTO entrevistado (nome,idade,id_escolaridade,id_bairro,religiao,cor,renda,id_cand_prefeito,id_cand_vereador,id_partido,data) VALUES ";
            } else {
				
				$dados[0] = str_replace('/','-', $dados[0]);
               
                $id_escolaridade = verifyEscolaridade($dados[4], $conn);

                if ($secureN < floor(($row/$linhas)*100)){
                    $secureN++;
                    echo "<br>".$secureN."%";
                    if ($secureN == $nextNumberSend && $split && $secureN != 100){
                        $nextNumberSend +=5;
                        $querry = substr($querry, 0, strlen($querry)-1);
                       // var_dump(utf8_encode($querry));
	                    mysqli_query($conn, $querry);
                        echo 'Dados importados!';
                        $querry = "INSERT INTO entrevistado (nome,idade,id_escolaridade,id_bairro,religiao,cor,renda,id_cand_prefeito,id_cand_vereador,id_partido,data) VALUES ";
                    //
					}
                } else {
                    echo ".";
                }

                $querry = $querry."($dados[1],'$dados[2]','$id_escolaridade','','$dados[11]','$dados[13]','$dados[12]','id pref','id cand', 'id partido','".date('Y-m-d', strtotime($dados[0]))."'),";
            }
        }
        $querry = substr($querry, 0, strlen($querry)-1);
       // var_dump(utf8_encode($querry));
	    mysqli_query($conn, $querry);
        echo 'Dados importados!';
        fclose($handle);
    }
}

function searchPeople($nome, $conn){
	$query = "SELECT id FROM partido WHERE sigla LIKE '%$sigla%'";
	$result = mysqli_query($conn, $query);
	// Se já tiver um partido adicionado no banco irá somente retornar a id dele.
	if (@mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver o partido no banco irá dar um insert e retornar o id.
    } else {
        return null;
    }
}

function searchPartido($sigla, $conn){
	$query = "SELECT id FROM partido WHERE sigla LIKE '%$sigla%'";
	$result = mysqli_query($conn, $query);
	// Se já tiver um partido adicionado no banco irá somente retornar a id dele.
	if (@mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver o partido no banco irá dar um insert e retornar o id.
    } else {
        return null;
    }
}
?>
<?php


function importCand($handle, $anoString, $conn){
	$row = 1;
	while ((@$data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data); //Quantidade de campos
        // Coluna
        // echo "<p> $num campos na linha $row: </p>\n";
        echo "</p>";
        $isFirstTime = $row == 1;
        $row++;
        // Conteúdo
        for ($c=0; $c < $num; $c++) {
            $dado = $data[$c];//mb_convert_encoding($data[$c], 'ISO-8859-15', 'UTF-8');
            if (!$isFirstTime){
                $dado = str_replace('\'','\\\'', $dado);
				$dado = utf8_decode($dado);
				$dados["$c"] = utf8_encode($dado);
            }
        }
		// Dados planilha: cargo(0), nome(1), sequencial(2), numero_cand(3), situacao(4), 
		// numero_partido(5), sigla_partido(6), nome_partido(7), profissao(8), data_nasc(9)
		// sexo(10), escolaridade(11), situacao_tot(12)
        if ($isFirstTime) {
            $querry = "INSERT INTO candidato (nome,cargo,seq_cand,num_cand,desc_situacao,id_partido,profissao,dt_nasc,sexo,id_escolaridade,id_situacao,id_ano) VALUES ";
			$id_ano = verifyAno($anoString, $conn);	
        } else {
			
			$id_escolaridade = verifyEscolaridade($dados[11], $conn);
			$id_partido = verifyPartido($dados[7],$dados[5],$dados[6],"null","null",$id_ano, $conn);
			$id_situacao = verifySituacaoTotal($dados[12], $conn);
			
            $dados[9] = str_replace('/','-', $dados[9]);
			
            $querry = $querry."('$dados[1]','$dados[0]','$dados[2]','$dados[3]','$dados[4]',
			'$id_partido','$dados[8]','".date('Y-m-d', strtotime($dados[9]))."','$dados[10]','$id_escolaridade','$id_situacao','$id_ano'),";
        }
    }
	$querry = substr($querry, 0, strlen($querry)-1);
	//var_dump(utf8_encode($querry));
	mysqli_query($conn, $querry);
	echo 'Dados importados!';
	fclose($handle);
}

function verifyPartido($nome, $numero, $sigla, $coligacao, $composicao, $ano, $conn){
	$query = "SELECT id FROM partido WHERE numero='$numero' AND nome='$nome' AND id_ano='$ano'";
	$result = mysqli_query($conn, $query);
	// Se já tiver um partido adicionado no banco irá somente retornar a id dele.
	if (@mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver o partido no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO partido(numero, nome, sigla, coligacao, composicao, id_ano) 
		VALUES ('$numero','$nome','$sigla','$coligacao','$composicao','$ano')";
		if (mysqli_query($conn, $query)) {
			return mysqli_insert_id($conn);
		} else {
			echo "ERRRO NA QUERY -> $query";
		}
	}
}

function verifySituacaoTotal($situacao, $conn){
	$query = "SELECT id FROM situacao_tot WHERE situacao='$situacao'";
	$result = mysqli_query($conn, $query);
	// Se já tiver a escolaridade adicionada no banco irá somente retornar o id dela.
	if (@mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver a escolaridade no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO situacao_tot(situacao) 
		VALUES ('$situacao')";
		if (mysqli_query($conn, $query)) {
			return mysqli_insert_id($conn);
		} else {
			echo "ERRRO NA QUERY -> $query";
			return;
		}
	}
}



?>
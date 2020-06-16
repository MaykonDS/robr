<?php

function importCand($file, $anoString, $conn){
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
					$dado = str_replace('\'','\\\'', $dado);
					$dado = utf8_decode($dado);
					$dados["$c"] = utf8_encode($dado);
				}
			}
		// Dados planilha: turno(0), cargo(1), nome(2), sequencial(3), numero_cand(4), situacao(5), 
		// numero_partido(6), sigla_partido(7), nome_partido(8), profissao(9), data_nasc(10)
		// sexo(11), escolaridade(12), situacao_tot(13)
		if ($isFirstTime) {
			$querry = "INSERT INTO candidato (nome,cargo,seq_cand,num_cand,desc_situacao,id_partido,profissao,dt_nasc,sexo,id_escolaridade,id_situacao,id_ano,turno) VALUES ";
			$id_ano = verifyAno($anoString, $conn);	
		} else {
			
			$id_escolaridade = verifyEscolaridade($dados[12], $conn);
			$id_partido = verifyPartido($dados[8],$dados[6],$dados[7],"null","null",$id_ano, $conn);
			$id_situacao = verifySituacaoTotal($dados[13], $conn);
			$dados[10] = str_replace('/','-', $dados[10]);
			
			if ($secureN < floor(($row/$linhas)*100)){
				$secureN++;
				echo "<br>".$secureN."%";
				if ($secureN == $nextNumberSend && $split && $secureN != 100){
					$nextNumberSend +=5;
					$querry = substr($querry, 0, strlen($querry)-1);
					//var_dump(utf8_encode($querry));
					mysqli_query($conn, $querry);
					echo 'Dados importados!';
					$querry = "INSERT INTO candidato (nome,cargo,seq_cand,num_cand,desc_situacao,id_partido,profissao,dt_nasc,sexo,id_escolaridade,id_situacao,id_ano,turno) VALUES ";
				}
			} else {
				echo ".";
			}
			
			$querry = $querry."('$dados[2]','$dados[1]','$dados[3]','$dados[4]','$dados[5]',
			'$id_partido','$dados[9]','".date('Y-m-d', strtotime($dados[10]))."','$dados[11]','$id_escolaridade','$id_situacao','$id_ano','$dados[0]'),";
		}
	}
	$querry = substr($querry, 0, strlen($querry)-1);
	//var_dump(utf8_encode($querry));
	mysqli_query($conn, $querry);
	echo 'Dados importados!';
	fclose($handle);
	}
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

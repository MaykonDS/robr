<?php
function importCand($handle, $ano, $conn){
	$row = 1;
	$ano = verifyAno($ano, $conn);
	
	while ((@$data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data); //Quantidade de campos
        // Coluna
        // echo "<p> $num campos na linha $row: </p>\n";
        echo "</p>";
        $isFirstTime = $row == 1;
        $row++;
        // Conteúdo
        for ($c=0; $c < $num; $c++) {
            $dado = mb_convert_encoding($data[$c], 'ISO-8859-15', 'UTF-8');
            if (!$isFirstTime){
                $dado = str_replace('\'','\\\'', $dado);
                $dados["$c"] = $dado;
            }
        }
		// Dados planilha: cargo(1), nome(2), sequencial(3), numero_cand(4), situacao(5), 
		// numero_partido(6), sigla_partido(7), nome_partido(8), profissao(9), data_nasc(10)
		// sexo(11), escolaridade(12), situacao_tot(13)
        if ($isFirstTime)
            $querry = "INSERT INTO candidato (nome,cargo,seq_cand,num_cand,desc_situacao,id_partido,profissao,dt_nasc,sexo,id_escolaridade,id_situacao,id_ano) VALUES ";
        else {
			$id_partido = verifyPartido($dados[8],$dados[6],$dados[7],"","",$ano, $conn);
			$id_escolaridade = verifyEscolaridade($dados[11], $conn);
			$id_situacao = verifySituacaoTotal($dados[12], $conn);
			
            $dados[10] = str_replace('/','-', $dados[10]);
            $querry = $querry."('$dados[2]','$dados[1]','$dados[3]','$dados[4]','$dados[5]',
			'$id_partido','$dados[9]','".date('Y-m-d', strtotime($dados[10]))."'),'$dados[11]','$id_escolaridade','$id_situacao','$ano',";
        }
    }
	$querry = substr($querry, 0, strlen($querry)-1);
	var_dump($querry);
	mysqli_query($conn, $querry);
	echo 'Dados importados!';
	fclose($handle);
}

function verifyPartido($nome, $numero, $sigla, $coligacao, $composicao, $ano, $conn){
	$query = "SELECT id FROM partido WHERE numero='$numero' AND nome=nome AND id_ano='$ano'";
	$result = mysqli_query($conn, $query);
	// Se já tiver um partido adicionado no banco irá somente retornar a id dele.
	if (mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver o partido no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO partido(numero, nome, sigla, coligacao, composicao, id_ano) 
		VALUES ('$numero','$nome','$sigla','$coligacao','$composicao','$ano')";
		mysqli_query($conn, $query);
		return mysqli_insert_id();
	}
}

function verifyEscolaridade($escolaridade, $conn){
	$query = "SELECT id FROM escolaridade WHERE escolaridade='$escolaridade'";
	$result = mysqli_query($conn, $query);
	// Se já tiver a escolaridade adicionada no banco irá somente retornar o id dela.
	if (mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver a escolaridade no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO escolaridade(escolaridade) 
		VALUES ('$escolaridade')";
		mysqli_query($conn, $query);
		return mysqli_insert_id();
	}
}

function verifySituacaoTotal($situacao, $conn){
	$query = "SELECT id FROM situacao WHERE situacao='$situacao'";
	$result = mysqli_query($conn, $query);
	// Se já tiver a escolaridade adicionada no banco irá somente retornar o id dela.
	if (mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver a escolaridade no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO situacao(situacao) 
		VALUES ('$situacao')";
		mysqli_query($conn, $query);
		return mysqli_insert_id();
	}
}

function verifyAno($ano, $conn){
	$query = "SELECT id FROM ano WHERE desc_ano='$ano'";
	$result = mysqli_query($conn, $query);
	// Se já tiver a escolaridade adicionada no banco irá somente retornar o id dela.
	if (mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver a escolaridade no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO ano(desc_ano) 
		VALUES ('$ano')";
		mysqli_query($conn, $query);
		return mysqli_insert_id();
	}
}

?>
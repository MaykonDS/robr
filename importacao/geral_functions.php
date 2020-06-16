<?php

function verifyAno($ano, $conn){
	$query = "SELECT id FROM ano WHERE desc_ano='$ano'";
	$result = mysqli_query($conn, $query);
	// Se já tiver a escolaridade adicionada no banco irá somente retornar o id dela.
	if (@mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver a escolaridade no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO ano(desc_ano) 
		VALUES ('$ano')";
		if (mysqli_query($conn, $query)) {
			return mysqli_insert_id($conn);
		} else {
			echo "ERRRO NA QUERY -> $query";
			return;
		}
	}
}

function verifyEscolaridade($escolaridade, $conn){
	$query = "SELECT id FROM escolaridade WHERE escolaridade LIKE '%$escolaridade%'";
        echo $query;
	$result = mysqli_query($conn, $query);
	// Se já tiver a escolaridade adicionada no banco irá somente retornar o id dela.
	if (@mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver a escolaridade no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO escolaridade(escolaridade) VALUES ('$escolaridade')";
		if (mysqli_query($conn, $query)) {
			return mysqli_insert_id($conn);
		} else {
			echo "ERRRO NA QUERY -> $query";
			return;
		}
	}
}
function verifyZona($zona, $conn){
    $query = "SELECT id FROM zona WHERE num_zona='$zona'";
	$result = mysqli_query($conn, $query);
	// Se já tiver a escolaridade adicionada no banco irá somente retornar o id dela.
	if (@mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		return $row["id"];
	// Se não tiver a escolaridade no banco irá dar um insert e retornar o id.
	} else {
		$query = "INSERT INTO zona(num_zona) 
		VALUES ('$zona')";
		if (mysqli_query($conn, $query)) {
			return mysqli_insert_id($conn);
		} else {
            echo "ERRRO NA QUERY -> $query";
			return;
		}
	}
}

function countRowsFile($file){
	if (($handle = fopen($file, "r")) !== FALSE) {
		$row_count = 0;
		ini_set('auto_detect_line_endings',TRUE);
    	while ((@$row_data = fgetcsv($handle, 2000, ";")) !== FALSE) {
        	$row_count++;
    	}
    	fclose($handle);
		$row_count--;
		return $row_count;
	}
}

?>
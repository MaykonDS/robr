<?php
$db = "robr";
$conn = mysqli_connect('localhost','root','',$db);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
} else {
	mysqli_set_charset($conn,'utf8');
}
?>
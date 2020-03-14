<?php
include 'database.php';
?>

<html>
    <head>
      <link rel="stylesheet" type="text/css" href="styles/geral.css">
        <title> ROBR </title>
    </head>
    <body class="dark-background">
    Selecione o arquivo .csv
    <br>
    <form action="#" method="POST" enctype="multipart/form-data">
    <input class="style" type="file" name="csvfile" id="csvfile" accept=".csv">
    <input type="submit" name="submit" value="Importar">
    </form>

    <?php
    setlocale(LC_ALL, 'en_US.utf8');
    if(isset($_POST['submit']))
    {
        $tmpName = $_FILES['csvfile']['tmp_name'];
        $row = 1;
        if (($handle = fopen($tmpName, "r")) !== FALSE) {
           while ((@$data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $num = count($data); //Quantidade de campos
            //Coluna
            // echo "<p> $num campos na linha $row: </p>\n";
            echo "</p>";
            $isFirstTime = $row == 1;
            $row++;
            //Conteúdo
            for ($c=0; $c < $num; $c++) {
                $dado = mb_convert_encoding($data[$c], 'ISO-8859-15', 'UTF-8');
                if ($isFirstTime){
                    $header["$c"] = $dado;
                } else {
                    $dado = str_replace('\'','\\\'', $dado);
                    $dados["$c"] = $dado;
                }
            }
            if ($isFirstTime)
              $querry = "INSERT INTO candidato ($header[1],$header[8],$header[7]) VALUES ";
            else {
              $dados[7] = str_replace('/','-', $dados[7]);
              $querry = $querry."('$dados[1]','$dados[8]','".date('Y-m-d', strtotime($dados[7]))."'),";
            }
        }
    $querry = substr($querry, 0, strlen($querry)-1);
    var_dump($querry);
    mysqli_query($conn, $querry);
		echo 'Dados importados!';
    fclose($handle);
}
    }
    ?>

    </body>
</html>

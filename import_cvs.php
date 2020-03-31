<?php
include 'importacao/consulta_cand.php';
include 'database.php';
?>

<html>
    <head>
      <link rel="stylesheet" type="text/css" href="styles/geral.css">
      <link rel="stylesheet" type="text/css" href="styles/importacao.css">
        <title> ROBR </title>
    </head>
    <body class="dark-background">
    <label class="subtitle">Selecione o ano dos dados que será importados.</label>
    <br>
    <form action="#" method="POST" enctype="multipart/form-data">
	<!--Radio para selecionar o ano dos dados que serão importados!-->
	<label class="container">2008
		<input type="radio" name="year" value="2008" checked>
		<span class="checkmark"></span>
	</label>
	<label class="container">2012
		<input type="radio" name="year" value="2012">
		<span class="checkmark"></span>
	</label>
	<label class="container">2016
		<input type="radio" name="year" value="2016">
		<span class="checkmark"></span>
	</label>
	<p>
	<label class="subtitle">Selecione a planilha consulta_cand</label><p>
    <input class="style" type="file" name="consultCand" id="consultCand" accept=".csv">
	<p>
	<label class="subtitle">Selecione a planilha perfil_eleitorado</label><p>
	<input class="style" type="file" name="perfilEleitorado" id="perfilEleitorado" accept=".csv">
	<p>
	<label class="subtitle">Selecione a planilha voto_secao</label><p>
	<input class="style" type="file" name="votoSecao" id="votoSecao" accept=".csv">
	<p>
	
    <input type="submit" name="submit" value="Importar">
    </form>

    <?php
    setlocale(LC_ALL, 'en_US.utf8');
    if(isset($_POST['submit']))
    {
        $tmpName = $_FILES['consultCand']['tmp_name'];
		// Abre o arquivo csv escolhido.
        if (($handle = fopen($tmpName, "r")) !== FALSE) {
           // Função para importar dados do candidato
		   importCand($handle, 2008, $conn);
		}
    }
    ?>

    </body>
</html>

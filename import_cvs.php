<?php
include 'importacao/consulta_cand.php';
include 'importacao/perfil_eleitorado.php';
include 'importacao/votacao_zona_secao.php';
include 'importacao/geral_functions.php';
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
		$ano_value = $_POST['year'];
		$tmpCand = $_FILES['consultCand']['tmp_name'];
		$tmpPerfil = $_FILES['perfilEleitorado']['tmp_name'];
		$tmpVoto = $_FILES['votoSecao']['tmp_name'];

		// Abre o arquivo csv escolhido.
        if ($tmpCand != null) {
           // Função para importar dados do candidato
		   importCand($tmpCand, $ano_value, $conn);
		}
		if ($tmpPerfil != null ) {
			// Função para importar dados do perfil eleitorado
			importPerfilEleitor($tmpPerfil, $ano_value, $conn);
		}
		if ($tmpVoto != null) {
			// Função para importar dados da votacao por secao
			importVotoSecao($tmpVoto, $ano_value, $conn);
		}
    }
    ?>
    </body>
</html>

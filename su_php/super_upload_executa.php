<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
require_once '../su_admin/super_config_upload.cnf'; // configuração para uploads de PDF
?>
<html lang='pt-br'>
<head>
	<title>Superinterface - Upload de arquivo PDF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
	<meta charset='UTF-8'>
</head>
<body>
<h2>Upload de Arquivos</h2>
<br \><hr class="new1"><br \>
<?php
// elimina o limite de tempo de execução
set_time_limit (0);
if (! isset ($_FILES['arquivo'])) {
	die("
		<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP069." ".ini_get('upload_max_filesize')."B<br \><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");
}	
$nome_arquivo = $_FILES['arquivo']['name'];
$tamanho_arquivo = $_FILES['arquivo']['size'];
$arquivo_temporario = $_FILES['arquivo']['tmp_name'];
$ext = strrchr($nome_arquivo,'.');
#
function transforma_tam($valor){
	$valor = log($valor) / log(1024);
	$suffix = array("", "kB", "MB", "GB", "TB")[floor($valor)];
	$valor= pow(1024, $valor - floor($valor));
	$valor=round($valor,1);
	$valor=$valor.$suffix;
	return $valor;
}
$tam_maxp = transforma_tam($tamanho_max);
if (empty ($nome_arquivo))
{
	// Não é possível fazer o upload do arquivo	
	die("
		<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP051."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div>");
}
#
if ($limitar_ext == "sim" && !in_array($ext,$extensoes_validas))
	// Não é possível fazer o upload do arquivo
	die("
		<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP052."<br /><br /></br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div>");
#
if ($sobrescrever == "nao" && file_exists("$caminho_absoluto/$nome_arquivo"))
	// Não é possível fazer o upload do arquivo
	die("
		<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP067."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");
#
if (($limitar_tamanho == "sim") && ($tamanho_arquivo > 0 ) && ($tamanho_arquivo > $tamanho_max))
	// Não é possível fazer o upload do arquivo	
	die("
		<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP069." ".$tam_maxp."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");
#
if(move_uploaded_file($arquivo_temporario, "$caminho_absoluto/$nome_arquivo"))
	{
		suPrintSucesso(SUMENSP049);
		echo "<div class=\"resposta\"><b>".$nome_arquivo."</b></div>";
		suPrintRodape2(SUMENSP068,"./super_upload.php",SUMENSP006,"super_admin.php");
}
else {
	// Não é possível fazer o upload do arquivo	
	die("
		<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP069." ".ini_get('upload_max_filesize')."B<br \><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");
}
?>
</body>
</html>


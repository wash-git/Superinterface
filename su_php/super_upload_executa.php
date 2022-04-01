<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
# require_once '../su_admin/super_config_upload.cnf'; // configuração para uploads de PDF
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
$nome_arquivo = $_FILES['arquivo']['name'];				# O nome original do arquivo na máquina do cliente. 
$tamanho_arquivo = $_FILES['arquivo']['size'];			# O tamanho, em bytes, do arquivo enviado. 
$arquivo_temporario = $_FILES['arquivo']['tmp_name'];   # O nome temporário com o qual o arquivo enviado foi armazenado no servidor (padrão: /tmp).
$su_error = $_FILES['arquivo']['error'];				# O código de erro associado a esse upload de arquivo. 
//$ext = strrchr($nome_arquivo,'.');
		$ext = strtolower(strrchr($nome_arquivo,'.'));
#
function transforma_tam($valor){
	$valor = log($valor) / log(1024);
	$suffix = array("", "kB", "MB", "GB", "TB")[floor($valor)];
	$valor= pow(1024, $valor - floor($valor));
	$valor=round($valor,1);
	$valor=$valor.$suffix;
	return $valor;
}

if (empty ($nome_arquivo))
{
	// Não é possível fazer o upload do arquivo: primeiro selecione o arquivo	
	die("
		<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP051."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div>");
}

if ($_FILES['arquivo']['error'] == UPLOAD_ERR_FORM_SIZE) {
  	// Não é possível fazer o upload do arquivo: o arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML. 	
	die("
		<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.".".SUMENSP101." ".transforma_tam($tamanho_max)."<br /></br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div>");

}

if ($_FILES['arquivo']['error'] == UPLOAD_ERR_INI_SIZE) {
  	// Não é possível fazer o upload do arquivo:  algum erro aconteceu.  	
	die("
		<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP102." ".ini_get('upload_max_filesize')."B <br /><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");

}

if ($_FILES['arquivo']['error'] >=3) {
  	// Não é possível fazer o upload do arquivo:  o arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.  	
	die("
		<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP069." ".$su_error."<br /><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");

}

#
if ($limitar_ext == "sim" && !in_array($ext,$extensoes_validas))
{
	// Não é possível fazer o upload do arquivo: tipo inválido
	die("
		<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP052."<br /><br /></br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div>");
}	
#
if ($sobrescrever == "nao" && file_exists("$caminho_absoluto/$nome_arquivo"))
{
	// Não é possível fazer o upload do arquivo: arquivo já existe na pasta de uploads
	die("
		<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP067."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");
}	
#
if (($limitar_tamanho == "sim") && ($tamanho_arquivo > 0 ) && ($tamanho_arquivo > $tamanho_max))
{
	// Não é possível fazer o upload do arquivo: tamanho excede o tamanho do limite configurado		
	die("
		<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.". ".SUMENSP069." ".transforma_tam($tam_max)."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");
}	
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
		<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP050.".<br \> ".SUMENSP069." ".ini_get('upload_max_filesize')."B ".SUMENSP100." ".transforma_tam($tamanho_max)."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_upload.php\">".SUMENSP068."</a></div></body></html>");
}
?>
</body>
</html>


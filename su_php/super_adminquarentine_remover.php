<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
?>
<html lang='pt-br'>
<head>
<title>Administração da pasta de Quarentena</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP005);
if ( $_GET["file"] ){
		$arquivo = $_GET["file"];
		$resultado = unlink($pastaquarentine."/".$arquivo);
		if ( $resultado === TRUE ) {
			// remoção do arquivo com sucesso
			suPrintSucesso(SUMENSP001);
		}
		else {
			// remoção do arquivo não realizada
			suPrintInsucesso(SUMENSP002);
		}
}
else {
		// remoção do arquivo não realizada
		suPrintInsucesso(SUMENSP003);
}
suPrintRodape(SUMENSP006,"./super_adminquarentine.php");
?>

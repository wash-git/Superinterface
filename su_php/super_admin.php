<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
?>

<html lang='pt-br'>
<head>
	<title>Administração da Plataforma Potlatch</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
	<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP011);

$menu = array(
		// Mensagem,link,target,separador
		array(SUMENSP012,"./super_upload.php","_self"," | "),
		array(SUMENSP017,"../index.php","_blank"," | "),
		array(SUMENSP016,"../su_autophp/super_backoffice.php","_blank"," | "),
		array(SUMENSP076,"./super_listaracervo.php","_self"," | "),
		array(SUMENSP015,"./super_adminquarentine.php","_self"," | "),
		array(SUMENSP014,"./super_adminusuarios.php","_self"," | "),
		array(SUMENSP074,"./super_tabelas.php","_self"," | "),
		array(SUMENSP070,"./super_logs.php","_self"," | "),
		array(SUMENSP048,"./super_status.php","_self","")
);
suPrintMenu2($menu);
suPrintRodape(SUMENSP013,"./super_logout.php");
?>
</body>
</html>


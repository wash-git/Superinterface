<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
?>

<html lang='pt-br'>
<head>
	<title>Superinterface - Acervo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
	<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP098);
$menu = array(
		// Mensagem,link,target,separador
		array(SUMENSP071,"./super_listarprimitivos.php","_self"," | "),
		array(SUMENSP006,"./super_admin.php","_self","")
);
suPrintMenu2($menu);echo "<br /><br />";
#$scanned_directory = array_diff(scandir($pastaimagens), array('..', '.'));
#foreach  ($scanned_directory  as &$value) {
#    echo $value."<br />";
#}
$num=0;
$files = glob("$pastaprimitivos/*.*");
foreach  ($files  as &$value) {
	$num++;
    echo $num.") &nbsp;&nbsp;&nbsp;".basename($value)."<br />";
}
suPrintRodape2(SUMENSP071,"./super_listarprimitivos.php",SUMENSP006,"./super_admin.php");
?>
</body>
</html>


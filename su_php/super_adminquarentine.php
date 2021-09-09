<?php
require_once ("../su_admin/super_config_php.cnf");
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
?>
<html lang='pt-br'>
<head>
<title>Administração da pasta de Quarentena</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP007);
$dir = $pastaquarentine;
$directory_iterator = new RecursiveDirectoryIterator(
	$dir, FilesystemIterator::SKIP_DOTS
);

$iterator = new RecursiveIteratorIterator($directory_iterator);
$result= [];
foreach($iterator as $file) {
	$result[] = $file;
}
if  ( count ($result) == 0 ) {
		suPrintSucesso(SUMENSP008);
}
else {
	echo "<table id=\"table1\" class=\"center\"><tr><th>".SUMENSP009."</th><th></th></tr>";
	foreach ($iterator as $file) {
		$basefile = basename($file).PHP_EOL;
		echo "<tr><td><a href='".$file."' target=\"_blank\">".$basefile."</a></td><td><a href=\"./super_adminquarentine_remover.php?file=".$basefile."\">  <img border=\"0\" alt=\"".SUMENSP010."\" title=\"".SUMENSP010."\" src=\"../su_icons/lixeira.png\" ></a>  </td></tr>";

	}
	echo "</table>";
}
suPrintRodape(SUMENSP006,"./super_admin.php");
?>
</body></html>

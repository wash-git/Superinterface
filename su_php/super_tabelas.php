<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
?>

<html lang='pt-br'>
<head>
	<title>Superinterface - Tabelas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
	<link rel='stylesheet' href='../su_css/super_criador.css' type='text/css'>
	<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP075);
$menu = array(
		// Mensagem,link,target,separador
		array(SUMENSP071,"./super_tabelas.php","_self"," | "),
		array(SUMENSP006,"./super_admin.php","_self","")
);
suPrintMenu2($menu);

$file = fopen("../su_logs/super_tabelascriadas.html","r");
//Output lines until EOF is reached
while(! feof($file)) {
  $line = fgets($file);
  echo $line. "<br />";
}

fclose($file);

# suPrintRodape2(SUMENSP071,"./super_tabelas.php",SUMENSP006,"./super_admin.php");
?>
</body>
</html>


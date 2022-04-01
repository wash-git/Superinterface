<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
?>

<html lang='pt-br'>
<head>
	<title>Superinterface - Logs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
	<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP072);
$menu = array(
		// Mensagem,link,target,separador
		array(SUMENSP071,"./super_logs.php","_self"," | "),
		array(SUMENSP006,"./super_admin.php","_self","")
);
suPrintMenu2($menu);
/*
#$conteudo=`tail -n 20 ../su_logs/super_logshell.log`;
#$output = shell_exec('tail -n 70 ../su_logs/super_logshell.log ');
//										retirando os comandos de cores do shell script
$output = str_replace('[33m', '', $output);
$output = str_replace('[34m', '', $output);
$output = str_replace('[97m', '', $output);
*/

$output = "<div class=\"content_logs\"><iframe src=\"../su_logs/super_logshell.html\" id=\"Iframe_logs\" title=\"iframe_log\"></iframe></div>";
echo "<pre>$output</pre>";					// enviar para a tela o log da aplicação
suPrintRodape2(SUMENSP071,"./super_logs.php",SUMENSP006,"./super_admin.php");
?>
</body>
</html>


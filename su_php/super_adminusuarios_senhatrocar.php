<?php
require_once ("../su_admin/super_config_php.cnf");
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
// Obtem valores do formulário de criação do usuário
$userf = $_POST["user"];
$senhan1 = $_POST["novasenha1"];
$senhan2 = $_POST["novasenha2"];
if (isset($_POST["senhaatual"])) { 
	$senhaa = $_POST["senhaatual"]; 
}
?>
<html lang='pt-br'>
<head>
<title>Administração de usuários</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP054);
if ( ! (ctype_alnum($userf) AND ctype_alnum($senhan1) AND  ctype_alnum($senhan2)) ) {
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP073."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
}		
if ($senhan1 !== $senhan2) {
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP059."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
}
$link = mysqli_connect("localhost",$username,$pass, $banco);
// Check connection
if (mysqli_connect_errno()) {
	#setcookie("observ1", null,-1,"/",$httpdominio);
	#unset($_COOKIE["observ1"]);
	#echo $html;
	suPrintInsucesso(SUMENSP027);
	suPrintRodape(SUMENSP006,"./super_logout.php");
	echo "</body></html>";
	exit();
}
if ($_SESSION['autoridade'] != 0) {
	// usuário não é administrador
	$senhaa = SHA1($senhaa);
	mysqli_query($link, "SELECT * from su_usuarios where username = '$userf' AND senha = '$senhaa'");
}
else{
	// usuário é administrador
	mysqli_query($link, "SELECT * from su_usuarios where username = '$userf'");
}
$encontrou =  mysqli_affected_rows($link);
if ( $encontrou == 0 )
{
		mysqli_close($link);
		#setcookie("observ1", null,-1,"/",$httpdominio);
		#unset($_COOKIE["observ1"]);
		suPrintInsucesso(SUMENSP046);
		suPrintRodape(SUMENSP006,"./super_admin.php");
		echo "</body></html>";
		exit;
}
$senhan1 = SHA1($senhan1);
mysqli_query ($link, "UPDATE su_usuarios SET senha = '$senhan1' WHERE username = '$userf'");
mysqli_close($link);
suPrintSucesso(SUMENSP060);
suPrintRodape(SUMENSP006,"./super_adminusuarios.php");
?>
</body></html>

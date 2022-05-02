<?php
require_once ("../su_admin/super_config_php.cnf");
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
// Obtem valores do formulário de criação do usuário
$userf =   $_POST["user"];
$emailf =  $_POST["email"];
$cidadef = $_POST["cidade"];
$estadof = $_POST["estado"];
$nomef = $_POST["nome"];
//if (isset($_POST["senhaatual"])) { 
//	$senhaa = $_POST["senhaatual"]; 
//}
//if ($_SESSION['autoridade'] == 0) {
	// usuário é administrador
//	if ($_POST["perfil"] == "Admin" ) { $perfilf = 0; }
//	else { $perfilf = 1;}
//	if ($_POST["situacao"] == "desabilitado" ) { $situacaof = 0;}
//	else { $situacaof = 1;}
//}
if ($_SESSION['autoridade'] == 0) {
	// usuário é administrador
	$perfilf = $_POST["privilegio"];
	$situacaof = $_POST["ativo"];
}
?>
<html lang='pt-br'>
<head>
<title>Atualização de usuários</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP107);
/**
if ( ! (ctype_alnum($userf) AND ctype_alnum($senhan1) AND  ctype_alnum($senhan2)) ) {
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP073."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
}		
if ($senhan1 !== $senhan2) {
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP059."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
}
 */
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
	$userf=$_SESSION['nome_usuario'];
}
$result = mysqli_query($link, "SELECT * from su_usuarios where username = '$userf'");
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
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($nomef == "") { $nomef = $row["nome_usuario"];}
if ($_SESSION['autoridade'] != 0) {
	// usuário não é administrador
	//$sql=   "UPDATE su_usuarios SET email = '$emailf', cidade = '$cidadef', estado = '$estadof' WHERE username = '".$_SESSION['nome_usuario']."'";
		$sql="UPDATE su_usuarios SET nome_usuario = '$nomef', email = '$emailf', cidade = '$cidadef', estado = '$estadof' WHERE username = '$userf'";
} else {
		// usuário administrador
		$sql="UPDATE su_usuarios SET nome_usuario = '$nomef', email = '$emailf', cidade = '$cidadef', estado = '$estadof', privilegio = '$perfilf', ativo = '$situacaof' WHERE username = '$userf'";
}
if (mysqli_query($link, $sql)) {
	suPrintSucesso(SUMENSP108);
} else {
		suPrintInsucesso(SUMENSP109);
		echo "perfilf= ".$perfilf;
		echo "situacaof= ".$situacaof;
}
mysqli_close($link);
suPrintRodape(SUMENSP006,"./super_adminusuarios.php");
?>
</body></html>

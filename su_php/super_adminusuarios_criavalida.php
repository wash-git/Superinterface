<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
// Obtem valores do formulário de criação do usuário
$userf = $_POST["username"];
$senhao = $_POST["senha"];
$senhaf = sha1($_POST["senha"]);
$nomef = $_POST["nome"];
$emailf = $_POST["email"];
$cidadef = $_POST["cidade"];
$estadof = $_POST["estado"];
$privilegiof = $_POST["privilegio"];
$ativof = $_POST["ativo"];
?>
<html lang='pt-br'>
<head>
	<title>Criação de Usuários</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
	<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP033);
if ( $_SESSION['autoridade'] != 0) {
	// usuário NÃO é um administrador
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP116."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
}	
if ( ! (ctype_alnum($userf) AND ctype_alnum($senhao) ) ) {
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP073."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
}	
$link = mysqli_connect("localhost",$username,$pass, $banco);
// Check connection
if (mysqli_connect_errno()) {
	// falha para se conectar ao MySQL
	die("
			<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP027."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div></body></html>");
}
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (!mysqli_query ($link, "INSERT INTO su_usuarios (username,senha,nome_usuario,email,cidade,estado,privilegio,ativo) VALUES ('$userf','$senhaf','$nomef','$emailf','$cidadef','$estadof','$privilegiof','$ativof')")){
		die("
						<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP062."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
		exit();
}
mysqli_close($link);
suPrintSucesso(SUMENSP065);
suPrintRodape(SUMENSP006,"./super_adminusuarios.php");
exit;
?>

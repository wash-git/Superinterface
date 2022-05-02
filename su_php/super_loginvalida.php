<?php
if (isset($_POST['destino'])) {
	$destino=$_POST['destino'];
}
else {
	header ("Location: ../index.php");
	exit;
}
require_once ("../su_admin/super_config_php.cnf");
require_once "../su_admin/super_mensagensphp.php";
require_once "../su_admin/super_library_functions.php";
// Obtem valores do login (filtra caracteres alphanumericos)
$userf =  preg_replace("/[^a-zA-Z0-9]+/", "8",$_POST["username"]);
$senhaf = preg_replace("/[^a-zA-Z0-9]+/", "8",$_POST["senha"]);
$senhaf = sha1($senhaf);
?>
<html lang='pt-br'>
<head>
<title>Superinterface</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP045);
$link = mysqli_connect("localhost",$username,$pass, $banco);
// Check connection
if (mysqli_connect_errno()) {
	// falha para se conectar ao MySQL
	die("
			<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP027."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_login.php\">".SUMENSP006."</a></div></body></html>");
}
$result = mysqli_query($link, "SELECT * from su_usuarios where BINARY username = '$userf' AND senha = '$senhaf' AND ativo = 1");
if (! $result){
	die("
			<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP064."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_login.php\">".SUMENSP006."</a></div></body></html>");
}
$encontrou =  mysqli_affected_rows($link);
mysqli_close($link);
if ( $encontrou == 0 )
{
	// Não encontrou as credenciais
	mysqli_free_result($result);
	die("
			<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP046."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_login.php\">".SUMENSP006."</a></div></body></html>");
}
else
{
	// Encontrou o usuário-senha
	$result = mysqli_fetch_assoc($result);
	//Iniciando a sessão:
	session_name($sess_nome);
	session_start();
	$_SESSION = array();
	$_SESSION['nome_usuario'] = $userf;
	$_SESSION['autoridade'] = $result["privilegio"];
	$_SESSION['datahora'] = time();
	switch ( $destino ) {
			case 1:
				header ("Location: ../su_autophp/super_backoffice.php");
				break;
			case 2:
				header ("Location: ./super_admin.php");
				break;
			case 3:
				header ("Location: ./super_upload.php");
				break;
			case 4:
				header ("Location: ./super_login.php");
				break;
			default:
				header ("Location: ./super_admin.php");
				break;
			}
}
?>


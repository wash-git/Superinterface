<?php
require_once ("../su_admin/super_config_php.cnf");
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
if(isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    return;
}
?>
<html lang='pt-br'>
<head>
<title>Trocar Senha</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP054);
$html='<div class = "container form-signin"> </div> <!-- /container -->
	<div class = "container">
	<form class = "form-signin" role = "form" action = "./super_adminusuarios_senhatrocar.php" method = "POST">
	<h4 class = "form-signin-heading">'.SUMENSP035.': '.$user.'</h4>';
if ($_SESSION['autoridade'] != 0) {
	// usuário não é administrador
	$html.='<input type = "password" class = "form-control" name = "senhaatual" placeholder ='.SUMENSP055.' maxlength="8" required autofocus></br>';
}
$html.='
		<input type = "password" class = "form-control" name = "novasenha1" placeholder ='.SUMENSP056.'  title="'.SUMENSP056.'" minlength="5" maxlength="8" required autofocus pattern="[a-zA-Z0-9]+" ></br>
		<input type = "password" class = "form-control" name = "novasenha2" placeholder ='.SUMENSP057.'  maxlength="8" required autofocus></br>
		<input type="hidden" name="user" value="'.$user.'">
		<button class = "botaoEnviar" type = "submit" name = "enviar">'.SUMENSP058.'</button>
		</form></div>';
echo $html;
suPrintRodape(SUMENSP006,"./super_adminusuarios.php");
?>
</body></html>


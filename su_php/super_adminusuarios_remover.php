<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
if(isset($_GET["user"])) {$user = $_GET["user"];}
echo "<html lang='pt-br'><head><title><Administração de Usuários</title>";
echo "<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>";
echo "<meta charset='UTF-8'></head><body>";
suPrintCabecalho(SUMENSP043);
if ($_SESSION['autoridade'] != 0 AND $user != $_SESSION['nome_usuario']) {
	// usuário não é adminitrador e nomes diferem
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP061."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_adminusuarios.php\">".SUMENSP006."</a></div>");
}
$link = mysqli_connect("localhost",$username,$pass, $banco);
// Check connection
if ( mysqli_connect_errno()) {
	suPrintInsucesso(SUMENSP027.".    ".SUMENSP042);
}
else{
	mysqli_query ($link, "DELETE FROM su_usuarios  WHERE BINARY username='$user'");
	if ( mysqli_affected_rows($link)  == 0 ){
		suPrintInsucesso(SUMENSP061);
	}
	else {
		suPrintSucesso(SUMENSP044);
	}
}
suPrintRodape(SUMENSP006,"./super_adminusuarios.php");
echo "</body></html>";
?>

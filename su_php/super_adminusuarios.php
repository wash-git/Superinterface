<?php
require_once ("../su_admin/super_config_php.cnf");
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
?>
<html lang='pt-br'>
<head>
<title>Administração de usuários</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP019);
$link = mysqli_connect("localhost",$username,$pass, $banco);
// Check connection
if (mysqli_connect_errno()) {
	// falha para se conectar ao MySQL
	die("
			<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP027."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_admin.php\">".SUMENSP006."</a></div>");
}
if ($_SESSION['autoridade'] == 0 )
{
	$result=mysqli_query($link, "SELECT * from su_usuarios ORDER BY nome ASC");
}
else {
	$result=mysqli_query($link, "SELECT * from su_usuarios WHERE username = '$_SESSION[nome_usuario]'");
}
if (! $result){
	die("
			<div class=\"resposta\"><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP064."<br \><br /><hr class=\"new1\"><br \><a href=\"./super_admin.php\">".SUMENSP006."</a></div></body></html>");
}

if (mysqli_num_rows($result) > 0) {
	// encontrou usuario(s)
	echo "<table id=\"table1\" class=\"center\">";
	echo "<tr><th>".SUMENSP020."</th><th>".SUMENSP021."</th><th>".SUMENSP022."</th><th>".SUMENSP023."</th><th>".SUMENSP024."</th><th>".SUMENSP025."</th><th>".SUMENSP026."</th><th></th><th></th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		  echo "<tr><td>". $row["nome"]. "</td><td>" .$row["username"]. "</td><td> " .$row["email"]."</td><td> " .$row["cidade"]. "</td><td>" .$row["estado"]. "</td><td>" .$row["privilegio"]. "</td><td>" .$row["ativo"]. "</td><td><a href=\"super_adminusuarios_remover.php?user=".$row["username"]."\"><img border=\"0\" alt=\"".SUMENSP010."\" title=\"".SUMENSP010."\" src=\"../su_icons/lixeira.png\" ></a></td> <td> <a href=\"super_adminusuarios_senha.php?user=".$row["username"]."\">   <img border=\"0\" alt=\"".SUMENSP053."\" title=\"".SUMENSP053."\" src=\"../su_icons/editar.png\" >   </a></td></tr>";
	}
	if ($_SESSION['autoridade'] == 0 )
	{
		// link para criar usuário, pois usuário é administrador
  		echo "<tr><td colspan=\"9\"><a href=\"super_adminusuarios_cria.php\" target=\"_self\">".SUMENSP028."</a></td></tr>";
	}
	mysqli_close($link);
	echo "</table>";
	suPrintRodape(SUMENSP006,"./super_admin.php");
} 
else 
{
	// nenhum usuário encontrado:  erro!
	suPrintInsucesso(SUMENSP029);
	mysqli_close($link);
	suPrintRodape(SUMENSP006,"./super_logout.php");
}
?>
</body></html>


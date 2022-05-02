<?php
require_once ("../su_admin/super_config_php.cnf");
require_once ("../su_admin/super_mensagensphp.php");
if (isset($_GET['aa'])) {
	$destino = $_GET['aa'];
}
else {
	$destino = $pag_admin;  # painel de administração
}
session_name($sess_nome);
session_start();
session_destroy();
?>
<html lang='pt-br'>
<head>
	<title>Login Plataforma Potlatch</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
</head>
<body>
<h2>Superinterface</h2> 
<br \><hr class="new1"><br \>
<div class = "container form-signin">
  </div> <!-- /container -->
  <div class = "container">

         <form class = "form-signin" role = "form" action = "./super_loginvalida.php" method = "POST">
            <h4 class = "form-signin-heading"><?php echo SUMENSP119 ?></h4>
            <input type = "text" class = "form-control"
               name = "username" title="<?php echo SUMENSP118 ?>" placeholder = <?php echo SUMENSP035 ?>  pattern="[a-zA-Z0-9]+"   required autofocus></br>
			<input type = "password" class = "form-control"
			   name = "senha" title=" <?php echo SUMENSP117 ?>" placeholder = <?php echo SUMENSP040 ?>   maxlength="8" pattern="[a-zA-Z0-9]+" required>
			<input type="hidden" name="destino" value="<?php echo $destino; ?>">
            <button class = "botaoEnviar" type = "submit"
               name = "login">Login</button>
         </form>
	  </div>
</body>
</html>



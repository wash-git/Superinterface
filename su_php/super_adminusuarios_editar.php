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
<title>Editar usuário</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP107);
?>

  </div> <!-- /container -->
  <div class = "container">

         <form class = "form-signin" role = "form" action = "./super_adminusuarios_editartrocar.php" method = "POST">
		 <h4 class = "form-signin-heading"><?php echo SUMENSP035.":" .$user ?></h4>
			<input type = "text" class = "form-control" name = "nome" title=" <?php echo SUMENSP112 ?>"  
				maxlength="40" placeholder = <?php echo SUMENSP020 ?> autofocus></br>
			<input type = "email" class = "form-control" name = "email" title="<?php echo SUMENSP113 ?>" 
				maxlength="40" placeholder = <?php echo SUMENSP022 ?> autofocus></br>
			<input type = "text" class = "form-control" name = "cidade" title="<?php echo SUMENSP112 ?>" 
				maxlength="40" placeholder = <?php echo SUMENSP036 ?> autofocus></br>
			<input type = "text" class = "form-control" name = "estado" title="<?php echo SUMENSP114 ?>" 
				maxlength="2"  placeholder = <?php echo SUMENSP037 ?> autofocus></br>
			<?php 
			if ($_SESSION['autoridade'] == 0) {
				// usuário é um Administrador
				echo '<fieldset class = "form-control">
					<label>'.SUMENSP039.'<input type="radio"  name="privilegio" value="1" CHECKED /></label>
					<label>'.SUMENSP038.'<input type="radio" name="privilegio" value="0" /></label>
					</fieldset>
					<fieldset class = "form-control" title="'.SUMENSP115.'">
					<label>'.SUMENSP111.'<input type="radio"  name="ativo" value="0" CHECKED /></label>
					<label>'.SUMENSP026.'<input type="radio" name="ativo" value="1" /></label>
					</fieldset>
					<!-- <input type="hidden" name="ativo" value="1"> -->
			'; } ?>
			<input type="hidden" name="user" value="<?php echo $user ?>">
            <button class = "botaoEnviar" type = "submit" name = "atualizar"><?php echo SUMENSP110 ?></button>
         </form>
	  </div> </div>
<?php

suPrintRodape(SUMENSP006,"./super_adminusuarios.php");
?>
</body></html>


<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
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
?>

  </div> <!-- /container -->
  <div class = "container">

         <form class = "form-signin" role = "form" action = "./super_adminusuarios_criavalida.php" method = "POST">
		 <h4 class = "form-signin-heading"><?php echo SUMENSP034.":" ?></h4>
		 <input type = "text" class = "form-control" name = "username" maxlength="10" placeholder = <?php echo SUMENSP066 ?>
               required autofocus></br>
			<input type = "password" class = "form-control" name = "senha" placeholder = <?php echo SUMENSP040 ?> maxlength="10" required autofocus></br>
			<input type = "text" class = "form-control" name = "nome" title=" <?php echo SUMENSP112 ?>" maxlength="40" placeholder = <?php echo SUMENSP020 ?> maxlength="15" required autofocus></br>
			<input type = "text" class = "form-control" name = "email" title=" <?php echo SUMENSP113 ?>" maxlength="40" placeholder = <?php echo SUMENSP022 ?>
               required autofocus></br>
            <input type = "text" class = "form-control" name = "cidade" title=" <?php echo SUMENSP112 ?>" maxlength="40"placeholder = <?php echo SUMENSP036 ?>
               required autofocus></br>
			<input type = "text" class = "form-control" name = "estado" title=" <?php echo SUMENSP114 ?>"   maxlength="2" placeholder =  <?php echo SUMENSP037 ?>
			   required autofocus></br>
			<fieldset class = "form-control">
				<label><?php echo SUMENSP039 ?><input type="radio" name="privilegio" value="1" CHECKED /></label>
				<label><?php echo SUMENSP038 ?><input type="radio"  name="privilegio" value="0" /></label>
			</fieldset>	
			<fieldset class = "form-control" title="<?php echo SUMENSP115 ?>">
				<label><?php echo SUMENSP111 ?><input type="radio" name="ativo" value="0" CHECKED /></label>
				<label><?php echo SUMENSP026 ?><input type="radio"  name="ativo" value="1" /></label>
			</fieldset>		
            <button class = "botaoEnviar" type = "submit"
               name = "criar"><?php echo SUMENSP041 ?></button>
         </form>
	  </div> </div>
<?php
suPrintRodape(SUMENSP006,"./super_adminusuarios.php");
?>
</body>
</html>


<?php
session_name($sess_nome);
session_start();
if ( ! IsSet($_SESSION["nome_usuario"])) {
		header("Location: ../su_php/super_login.php?aa=".$identscript);
		exit();
}
?>


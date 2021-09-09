<?php
include ("../su_admin/super_config_php.cnf");
#setcookie("observ1", null, -1,"/superinterface",$_SERVER['SERVER_NAME']);
#unset($_COOKIE["observ1"]);
session_name($sess_nome);
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
header("location: ./super_login.php");
?>

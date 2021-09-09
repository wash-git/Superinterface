<?php
ini_set("log_errors", TRUE);									// Error/Exception file logging engine
error_reporting(E_ALL); 										// Error/Exception engine: using E_ALL
ini_set('display_errors', TRUE);
ini_set("error_log", $pastalogs."/".$arqlogs);					// caminho para o arquivo de log de erros da aplicação
//                                                              Função da aplicação de error handler
function myErrorHandler($errno, $errstr, $errfile, $errline) {
        $tipo=FriendlyErrorType($errno);
        error_log($tipo." - ".$errstr);
        error_log($tipo." - Linha ".$errline.", do arquivo:  ".$errfile);
        error_log($tipo." - ".SUMENSP063);
}

set_error_handler("myErrorHandler");

function FriendlyErrorType($type)
{
    switch($type)
    {
        case E_ERROR: // 1 //
            return 'E_ERROR';
        case E_WARNING: // 2 //
            return 'E_WARNING';
        case E_PARSE: // 4 //
            return 'E_PARSE';
        case E_NOTICE: // 8 //
            return 'E_NOTICE';
        case E_CORE_ERROR: // 16 //
            return 'E_CORE_ERROR';
        case E_CORE_WARNING: // 32 //
            return 'E_CORE_WARNING';
        case E_COMPILE_ERROR: // 64 //
            return 'E_COMPILE_ERROR';
        case E_COMPILE_WARNING: // 128 //
            return 'E_COMPILE_WARNING';
        case E_USER_ERROR: // 256 //
            return 'E_USER_ERROR';
        case E_USER_WARNING: // 512 //
            return 'E_USER_WARNING';
        case E_USER_NOTICE: // 1024 //
            return 'E_USER_NOTICE';
        case E_STRICT: // 2048 //
            return 'E_STRICT';
        case E_RECOVERABLE_ERROR: // 4096 //
            return 'E_RECOVERABLE_ERROR';
        case E_DEPRECATED: // 8192 //
            return 'E_DEPRECATED';
        case E_USER_DEPRECATED: // 16384 //
            return 'E_USER_DEPRECATED';
	}
    return "";
} 

function suPrintCabecalho($titulo){
	echo "<h2>".$titulo."</h2><br /><br /><hr class=\"new1\"><br />";	
}

function suPrintMenu($mensagem,$link){
	echo "<p align=\"center\">";
	echo "<a href=\"".$link."\" target=\"_SELF\">".$mensagem."</a>";
	echo "</p>";
}


function suPrintMenu2($menu){
	echo "<p align=\"center\">";
	foreach ($menu as $value) {
			echo "<a href=\"".$value[1]."\" target=\"".$value[2]."\">".$value[0]."</a>  ".$value[3];
	}
}

function suPrintRodape($texto,$link){
	echo "<br /><br /><hr class=\"new1\"><p align=\"center\"><a href=\"".$link."\">".$texto."</a></p>";
}

function suPrintRodape2($texto,$link,$texto2,$link2){
	echo "<br /><br /><hr class=\"new1\"><p align=\"center\"><a href=\"".$link."\">".$texto."</a> | <a href=\"".$link2."\">".$texto2."</a></p>";
}


function suPrintSucesso($texto){
	echo "<div class=\"resposta\"><br /><br /><img class=\"middle\" src=\"../su_icons/super_positivo.png\" />".$texto."  <br />";	
}

function suPrintInsucesso($texto){
	echo "<div class=\"resposta\"><br /><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".$texto."  <br />";	
}

?>

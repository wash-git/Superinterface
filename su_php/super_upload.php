<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_upload;      // identificação do script para uploads de PDF
require_once "../su_admin/super_config_includes.php";
?>
<html lang='pt-br'>
<head>
<title>Superinterface - Upload de arquivos PDF</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP030);
echo "<div class=\"center\">( Extensões válidas: ";
foreach($extensoes_validas as $i){
		echo $i.'&nbsp;&nbsp;&nbsp;';
}
echo ")</div>";
echo "<form method=POST action=\"./super_upload_executa.php\" enctype=multipart/form-data>";
echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$tamanho_max\">";
echo "<p align=center>".SUMENSP031.": <input type=\"file\" name=\"arquivo\" size=\"70\" multiple>";
echo "<p align=center><input type=submit value=\"".SUMENSP032."\">";
echo "</form>";
suPrintRodape(SUMENSP006,"./super_admin.php");
?>
</body>
</html>


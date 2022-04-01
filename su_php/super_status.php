<?php
require_once "../su_admin/super_config_php.cnf";
$identscript=$pag_admin;      // identificação do script de administração da Superinterface
require_once "../su_admin/super_config_includes.php";
?>
<html lang='pt-br'>
<head>
<title>Status da Superinterface</title>
<link rel='stylesheet' href='../su_css/super_admin.css' type='text/css'>
<meta charset='UTF-8'>
</head>
<body>
<?php
suPrintCabecalho(SUMENSP047);
function transforma_tam($valor){
	$valor = log($valor) / log(1024);
	$suffix = array("", "k", "M", "G", "T")[floor($valor)];
	$valor= pow(1024, $valor - floor($valor));
	$valor=round($valor,1);
	$valor=$valor.$suffix;
	return $valor;
}
// 						Verifica espaço total em disco
$bytes = disk_total_space("/"); 
$Type = array("", "K", "M", "G", "T", "peta", "exa", "zetta", "yotta");
$Index=0;
while($bytes>=1024)
{
    $bytes/=1024;
    $Index++;
}
#$espaco_dtotal =  round($bytes,2)."     ".$Type[$Index]."bytes";
$espaco_dtotal =  round($bytes,0)."".$Type[$Index];
//						Verifica espaço livre em disco
$bytes = disk_free_space("/"); 
$Index=0;
while($bytes>=1024)
{
    $bytes/=1024;
    $Index++;
}
$espaco_dfree =  round($bytes,0)."".$Type[$Index];
//						Verifica espaço de disco ocupado pela pasta de arquivos do acervo
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator('../su_imagens')
);
$bytes = 0;
foreach ($iterator as $file) {
    $bytes += $file->getSize();
}
$Index=0;
while($bytes>=1024)
{
    $bytes/=1024;
    $Index++;
}
$espaco_pdf =  round($bytes,2)."".$Type[$Index];
$upload_max_size = ini_get('upload_max_filesize');	// tamanho max do arquivo para uploads
$post_max_size = ini_get('post_max_size');			// tamanho maz upload de grupo de arquivos
//							Conexão com base de dados
$link = mysqli_connect("localhost",$username,$pass, $banco);
// Check connection
if ( mysqli_connect_errno()) {
  // falha para se conectar ao MySQL
	die("
			<div class=\"resposta\"><br /><img class=\"middle\" src=\"../su_icons/super_negativo.png\" />".SUMENSP027."<br \><br /></br /><hr class=\"new1\"><br \><a href=\"./super_admin.php\">".SUMENSP006."</a></div>");
}
//					tamanho da base de dados
$result = mysqli_query($link,"SHOW TABLE STATUS");
$bytes = 0;
while($row = mysqli_fetch_array($result)) {
    $bytes += $row["Data_length"] + $row["Index_length"];
}
$Index=0;
while($bytes>=1024)
{
    $bytes/=1024;
    $Index++;
}
$tam_base =  round($bytes,0)."".$Type[$Index];
//
if ($result = mysqli_query($link, "SELECT nome from su_usuarios")){
	$num_usuarios = mysqli_num_rows($result);
}
else{
	$num_usuarios = "-";
}
if ($result = mysqli_query($link, "SELECT nome_documento from su_documents")){
	$num_documentos = mysqli_num_rows($result);
}
else{
	$num_documentos = "-";
}
if ($result = mysqli_query($link, "SELECT nome_cidade from su_cidades")){
	$num_cidades = mysqli_num_rows($result);
}
else{
	$num_cidades = "-";
}
if ($result = mysqli_query($link, "SELECT nome_instituicao from su_instituicoes")){
	$num_instituicoes = mysqli_num_rows($result);
}
else{
	$num_instituicoes = "-";
}
if ($result = mysqli_query($link, "SELECT first_sem_acento from su_names_brasil")){
	$num_nomes = mysqli_num_rows($result);
}
else{
	$num_nomes = "-";
}
if ($result = mysqli_query($link, "SHOW TABLES")){
	$num_tables = mysqli_num_rows($result);
}
else{
	$num_tables = "-";
}

switch (session_status()){
	case PHP_SESSION_DISABLED:
			$msessao="PHP_SESSION_DISABLED";
			$nsessao="-";
			break;
	case PHP_SESSION_NONE:
			$msessao="PHP_SESSION_NONE";
			$nsessao="-";
			break;
	case PHP_SESSION_ACTIVE:
			$msessao="PHP_SESSION_ACTIVE";
			$nsessao=session_name();
			break;
	default:
			$msessao="-";
			$nsessao="-";
}
$arquivos = scandir("../su_quarentine");
$num_quarentine = count($arquivos)-2;
suPrintMenu("Voltar","./super_admin.php");
echo "<table id=\"table1\" class=\"center\">";
echo "<tr><th>".SUMENSP077."</th><th>Valor</th></tr>";  # Informação
echo "<tr><td>".SUMENSP078."</td><td>".$_SERVER['SERVER_NAME']."</td></tr>";# SERVER_NAME
echo "<tr><td>".SUMENSP079."</td><td>".$_SERVER['HTTP_HOST']."</td></tr>";	# HOST_NAME
echo "<tr><td>".SUMENSP080."</td><td>".$_SERVER['HTTP_REFERER']."</td></tr>";# URL completa
echo "<tr><td>".SUMENSP081."</td><td>".$_SERVER['PHP_SELF']."</td></tr>";	# PPHP SELF
echo "<tr><td>".SUMENSP082."</td><td>".$espaco_dtotal."</td></tr>";			# Espaço em disco
echo "<tr><td>".SUMENSP083."</td><td>".$espaco_dfree."</td></tr>";			# Espaço livre em disco
echo "<tr><td>".SUMENSP084."</td><td>".$upload_max_size."</td></tr>";		# Tamanho max uploads
echo "<tr><td>".SUMENSP085."</td><td>".$post_max_size."</td></tr>";			# Tamanho max grupo de uploads
echo "<tr><td>".SUMENSP104."</td><td>".transforma_tam($tamanho_max)."</td></tr>";			# Tamanho max uploads parâmetro Superinterface
echo "<tr><td>".SUMENSP086."</td><td>".$banco."</td></tr>";					# Nome da base do acervo
echo "<tr><td>".SUMENSP088."</td><td>".$tam_base."</td></tr>";				# Tamanho da base
echo "<tr><td>".SUMENSP090."</td><td>".$num_documentos."</td></tr>";		# Acervo (Num. arquivos)
echo "<tr><td>".SUMENSP087."</td><td>".$espaco_pdf."</td></tr>";			# Pasta de arquivos do Acervo
echo "<tr><td>".SUMENSP009."</td><td>".$num_quarentine."</td></tr>";		# Núm. arquivos em quarentena
echo "<tr><td>".SUMENSP105."</td><td>".$lote."</td></tr>";					# Lote de arquivos que podem ser tratados
echo "<tr><td>".SUMENSP089."</td><td>".$num_tables."</td></tr>";			# Tabelas
echo "<tr><td>".SUMENSP014."</td><td>".$num_usuarios."</td></tr>";			# Número usuários
echo "<tr><td>".SUMENSP091."</td><td>".$num_cidades."</td></tr>";			# Núm. cidades
echo "<tr><td>".SUMENSP092."</td><td>".$num_instituicoes."</td></tr>";		# Núm. instituições
echo "<tr><td>".SUMENSP093."</td><td>".$num_nomes."</td></tr>";				# Nomes brasileiros
echo "<tr><td>".SUMENSP094."</td><td>".$msessao."</td></tr>";				# Sessão -> Status
echo "<tr><td>".SUMENSP095."</td><td>".$nsessao."</td></tr>";				# Sessão -> Nome
echo "<tr><td>".SUMENSP096."</td><td>".date('d/m/Y H:i:s',$_SESSION['datahora'])."</td></tr>";# Sessão -> Criação
echo "<tr><td>".SUMENSP097."</td><td>".$_SESSION['nome_usuario']."</td></tr>";                # Sessão -> Usuário
echo "</table>";
suPrintRodape(SUMENSP006,"./super_admin.php");
?>
</body></html>


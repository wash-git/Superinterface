<?php header("Content-type: text/html; charset=utf-8");
/*
+ --------------------------------------------------------------------------------------------------------------------------+
|																															|
|												CONFIGURAÇÃO DO SCRIPT														|
|																															|
+---------------------------------------------------------------------------------------------------------------------------+
*/
//	prepara saída de erros durante a execução deste script PHP
//
$arqconfig = '../su_admin/super_config_php.cnf';	// arquivo de configuração
ini_set("log_errors", 1);
$limitador_registros=50; 							// quantidade de registros por tela
$quantidade_maxima_de_linhas_no_NtoN="30"; // máximo itens NtoN serão mostrados na tabela principal - NÃO ESTÁ FUNCIONANDO
/*
+ --------------------------------------------------------------------------------------------------------------------------+
|																															|
|												MENSAGENS																	|
|																															|
+---------------------------------------------------------------------------------------------------------------------------+
 */
$mensagens = array (
		"Mens01" => "Para subir múltiplos arquivos, use os botões abaixo:",
		"Mens02" => "Cria interfaces para o banco: ",
		"Mens03" => "Lista de Arquivos a serem gravados no servidor",
		"Mens04" => "Back_Office da Superinterface (Potlatch)",
		"Mens05" => "Tabelas Independentes",
		"Mens06" => "Tabelas Dependentes",
		"Mens07" => "Tabelas de Conexão 2",
		"Mens08" => "Tabelas de Conexão 3",
		"Mens09" => "Tabelas de Conexão 4",
		"Mens10" => "Outras",
		"Mens11" => "Left Join View",
		"Mens12" => "Inserção de dados na tabela: ",
		"Mens13" => "Entrada de dados",
		"Mens14" => "Ver Def",
		"Mens15" => "Consulta: ",
		"Mens16" => "OooopS!  Algo parece estar se comportamento estranho.  Vamos continuar, mas é bom verificar.   Tipo: ",
		"Mens17" => "Erro grave: desculpe, mas algo está errado.  Por favor, verifique o ambiente de instalação e tente novamente. O script será encerrado!",
		"Mens18" => "Erro grave: arquivo de configuração do PHP não encontrado",
		"Mens19" => "Interrompendo a execução do Script",
		"Mens20" => "Gerando código para função Cria_puxa_lista_NtoN",
		"Mens21" => "Gerando código para função Cria_sobe_multiplos",
		"Mens22" => "Gerando código para função Cria_pdf_thumb",
		"Mens23" => "Gerando código para função Cria_Mostra_Diretorios_PHP",
		"Mens24" => "Gerando código para função Cria_Upload_PHP",
		"Mens25" => "Gerando código para função Cria_super_busca_registro_inteiro",
		"Mens26" => "Gerando código para função Cria_Busca_Like",
		"Mens27" => "Gerando código para função Cria_auto_insere_php",
		"Mens28" => "Gerando código para função Cria_auto_apaga_php",
		"Mens29" => "Gerando código para função Cria_auto_alterar_php",
		"Mens30" => "Gerando código para função Cria_auto_ler_php",
		"Mens31" => "Erro ao tentar deletar su_tabelas_ligacao",
		"Mens32" => "Erro na montagem das tabelas",
		"Mens33" => "Cria TXT para inserção dos dados (Este botão não está implementado - criação ocorre automaticamente)",
		"Mens34" => "Gerando código para função Cria_Insercao_N_to_N",
		"Mens35" => "Gerando código para função Cria_seleciona_fk",
		"Mens36" => "Gerando código para função Cria_Insercao",
		"Mens37" => "Gerando código para função Cria_VerDef",
		"Mens38" => "Gerando código para função Cria_Entrada_Para_Aldir_Blanc",
		"Mens39" => "Gerando código para função Cavecalio_simplificado_por_id",
		"Mens40" => "Gerando código para função Cabecalio_simplificado",
		"Mens41" => "Gerando código para função Cabecalio_main",
		"Mens42" => "Erro grave: imagick não instalado",
		"Mens43" => "Data da Criação"
);
function Envia_mensagem ($mens) {
		error_log($mens);
}
/*
+ --------------------------------------------------------------------------------------------------------------------------+
|																															|
|												ERROR HANDLER																|
|																															|
+---------------------------------------------------------------------------------------------------------------------------+
*/
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

// 								Função da aplicação de error handler
function myErrorHandler($errno, $errstr, $errfile, $errline) {
	global $mensagens;
	$tipo=FriendlyErrorType($errno);
	error_log($tipo." - ".$errstr);
	error_log($tipo." - Linha ".$errline.", do arquivo:  ".$errfile);
	error_log($tipo." - ".$mensagens['Mens19']);
	exit(1);
}

function myExceptionHandler($e) {
	global $mensagens;
	error_log($e->getMessage().'.  Linha '.$e->getLine().' do arquivo '.$e->getFile());
	error_log($mensagens['Mens19']);
	exit(1);
}
set_exception_handler("myExceptionHandler");
// 								Definição da função de error handler da aplicação
set_error_handler("myErrorHandler"); 
//
if (!file_exists("$arqconfig")) {
	trigger_error($mensagens['Mens18']);
}
else {
	require("$arqconfig");
}
$arquivologs=$pastalogs."/".$arqlogs;
ini_set("error_log", $arquivologs);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);//
// verifica se imagick está instalado
if( extension_loaded('imagick') && class_exists("Imagick") ){

} else {
	trigger_error($mensagens['Mens42']);
}

//
/*
+ --------------------------------------------------------------------------------------------------------------------------+
|																															|
|												FUNÇÕES DA APLICAÇÃO														|
|																															|
+---------------------------------------------------------------------------------------------------------------------------+
*/
/* ######################## >>>>   FUNÇÃO 1: Cria_puxa_lista_NtoN   <<<<< ########################                         */
// objetivo:  acelerar atualização da lista NtoN (por enquanto ainda está valendo carrega() )
function Cria_puxa_lista_NtoN(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$dir=getcwd();
	Envia_mensagem($mensagens['Mens20']);
	$fs_cria_puxa=fopen('../su_autophp/super_puxa_lista_NtoN.php','w');
	//
	$cria = '<?php
//require_once "../su_install/'.$arqconfig.'";
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
$table=$table_para_search;

$conn= new mysqli("localhost", $username, $pass, $banco_de_dados);

$sql_schema="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = \'".$table."\' AND CONSTRAINT_NAME = \'PRIMARY\' limit 1;";// vamos pegar o nome da chave primária

$result_schema=$conn->query("$sql_schema");
if ($result_schema->num_rows>0) {
  while($row_schema=$result_schema->fetch_assoc())
    {
	$chave_primaria=$row_schema["COLUMN_NAME"];
	}
} else {echo "<tr><td>Não tem dados</td></tr>";}

$nome_a_partir_do_rcn=str_replace("id_chave_","nome_",$rcn); // essa solucao assume que a tabela externa tem um campo nome_. Isso pode não ser verdade. O certo seria buscar o campo nome e se não tivesse, chamar um erro

$sql_externo="select a.".$nome_a_partir_do_rcn.", b.".$chave_primaria." from ".$rtn." as a, ".$table." as b  where a.".$rcn."=b.".$coluna." and b.".$campo_externo_para_search."=\'".$id_externo_para_search."\';";

echo "<tr><td><div class=\'classe_contem_nomes\' id=\'contem_nomes_".$campo_externo_para_search."_".$id_externo_para_search."\'>
".$nome_a_partir_do_rcn." 
<table class=\'classe_contem_nomes\' style=\'background-color: blue\'>
<tr>
";

$result_externo=$conn->query("$sql_externo");
if ($result_externo->num_rows>0) {
  while($row_externo=$result_externo->fetch_assoc())
    {
	$nome_rcn=$row_externo[$nome_a_partir_do_rcn];
	$id_chave=$row_externo[$chave_primaria];
	echo "<tr><td class=\'classe_contem_nomes\'>".$nome_rcn."<input type=\'button\' value=\'apaga\' onclick=\'apaga_registro_com_tabela(`".$tabela."`,".$id_chave.");\'></td></tr>";
	} 
} else {echo "<tr><td>Não tem dados</td></tr>";}

echo "
</tr>
</table>
</div></td></tr>";

echo"</table></div>
" 
?>
';

fwrite($fs_cria_puxa,$cria);
fclose($fs_cria_puxa);
}
//
/* ######################## >>>>   FUNÇÃO 2: Cria_sobre_multiplos   <<<<< ########################                       */
// objetivo: 
function Cria_sobe_multiplos(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_cria=fopen('../su_autophp/super_sobe_multiplos.php','w');
	Envia_mensagem($mensagens['Mens21']);
	$cria = '<?php
//require_once "../su_install/'.$arqconfig.'";
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
if(isset($_POST["submit"])){
// Count total files
$countfiles = count($_FILES["file"]["name"]);
echo "
<h1>Lista de Arquivos a serem gravados no servidor</h2>
<html>
<style>

table, td, th 
	{
		background-color: green;
		border: 1px solid black;
        } 

</style><body><table>"; 
 // Looping all files
 for($i=0;$i<$countfiles;$i++){
   $filename = $_FILES["file"]["name"][$i];
   echo "<tr><td>".$filename."</td></tr>"; 
   // Upload file
   move_uploaded_file($_FILES["file"]["tmp_name"][$i],$pastaimagens."/".$filename);    
 }
echo "</table>";
} else {echo "Ocorreu algum problema: o servidor não recebeu os arquivos.";}

echo "<a href=\'http://".$httphost."/su_autophp/super_backoffice.php\'>Volta para BackOffice</a>";
?>
';

fwrite($fs_cria,$cria);
fclose($fs_cria);

}
//
/* ######################## >>>>   FUNÇÃO 3: Cria_pdf_thumb   <<<<< ########################                       */
// objetivo: 
function Cria_pdf_thumb(){
	global $mensagens;
	global $arqconfig;
	setlocale(LC_ALL, 'pt_BR');
	$fs_cria=fopen('../su_autophp/super_pdf_thumb.php','w');
	Envia_mensagem($mensagens['Mens22']);
	$cria = '<?php
//  ++++ Não usar a validação de sessão neste script ++++
//require_once "'.$arqconfig.'";
//$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
//require_once "../su_admin/super_config_includes.php";
if(isset($_GET["pdf"])){
  $pdf = $_GET["pdf"];
}
$im=new imagick($pdf."[0]");
$im->setImageBackgroundColor("#ffffff");
$im->setImageFormat("png");
$im->thumbnailImage(200,0);
header("Content-Type: image/jpg");
echo $im;

?>
';

fwrite($fs_cria,$cria);
fclose($fs_cria);
}
//
/* ##################### >>>>   FUNÇÃO 4: Cria_Mostra_Diretorios_PHP   <<<<< #####################                       */
// objetivo: cria o PHP que vai buscar uma string na tabela citada pela tabela fk da atual (quando não tem nome_% na atual)
function Cria_Mostra_Diretorios_PHP(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_busca_inteiro=fopen('../su_autophp/super_mostra_diretorio_imagens.php','w');
	Envia_mensagem($mensagens['Mens23']);
	$busca='<?php
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";


if(isset($_GET["diretorio"])){    // diretorio onde o php vai buscar os arquivos. Não deveria ser flexível no apaga (forçamos su_imagens)
  $diretorio_puro= $_GET["diretorio"];
}
if(isset($_GET["id_input"])){    // id do elemento da página que chama esta página, o qual guarda o nome do arquivo de imagem. Precisa colocar 					// o nome selecionado quando esta página fecha, por isso 
  $id_input= $_GET["id_input"];
}
if(isset($_GET["id_input_path"])){   // id do elemento da página que chama esta página, o qual guarda o diretorio da imagem
  $id_input_path= $_GET["id_input_path"];
}
if(isset($_GET["id_input_img"])){   // id do elemento da página que chama esta página, o qual guarda o diretorio da imagem
  $id_input_img= $_GET["id_input_img"];
}

if(isset($_GET["jpg"])){   // id do elemento da página que chama esta página, o qual guarda o diretorio da imagem
  $jpg= $_GET["jpg"]; // 1 mostra; 0 nao mostra
}

if(isset($_GET["gif"])){   // id do elemento da página que chama esta página, o qual guarda o diretorio da imagem
  $gif= $_GET["gif"]; // 1 mostra; 0 nao mostra

}

if(isset($_GET["png"])){   // id do elemento da página que chama esta página, o qual guarda o diretorio da imagem
  $png= $_GET["png"]; // 1 mostra; 0 nao mostra

}

if(isset($_GET["pdf"])){   // id do elemento da página que chama esta página, o qual guarda o diretorio da imagem
  $pdf= $_GET["pdf"]; // 1 mostra; 0 nao mostra
}
if ($pdf!=0) {$pdf_checked="checked";} else {$pdf_checked="";}
if ($jpg!=0) {$jpg_checked="checked";} else {$jpg_checked="";}
if ($gif!=0) {$gif_checked="checked";} else {$gif_checked="";}
if ($png!=0) {$png_checked="checked";} else {$png_checked="";}
$diretorio="../".$diretorio_puro; // precisa subir um diretório porque está no su_autophp, que está no mesmo nível de su_imagens, abaixo de deia
echo "
<html>
<head>
<title>Lista de Arquivos do Diretorio $diretorio</title>
</head>
<style>
table, td, th {
	background-color: gray;
        border: 1px solid black;
        border-collapse: collapse;
}
</style>
<body>
<h1>su_imagens do diretório <i style=\'color: blue\'>$diretorio</i></h1>
<table>
<tr>
<td class=\'escolha\'><input type=\'checkbox\' ".$jpg_checked." onmouseup=\'alert(`alo`); recarrega(".intval($jpg+1).",".$png.",".$gif.",".$pdf.");\'>JPG</input></td>
<td class=\'escolha\'><input type=\'checkbox\' ".$png_checked." onmouseup=\'alert(`alo`); recarrega(".$jpg.",".intval($png+1).",".$gif.",".$pdf.");\'>PNG</input></td>
<td class=\'escolha\'><input type=\'checkbox\' ".$gif_checked." onmouseup=\'alert(`alo`); recarrega(".$jpg.",".$png.",".intval($gif+1).",".$pdf.");\'>GIF</input></td>
<td class=\'escolha\'><input type=\'checkbox\' ".$pdf_checked." onmouseup=\'alert(`alo`); recarrega(".$jpg.",".$png.",".$gif.",".intval($pdf+1).");\'>PDF</input></td>
</tr>
</table>

<table>
<tr>
<th>Nome Arquivo</th><th>Tipo</th><th>Imagem</th><th>Selecionar</th><th>A imagem está sendo usada?</th>
</tr>
";
$arquivos=scandir ($diretorio);
$conta=0;
foreach ($arquivos as $value)
	{
	$imageFileType = strtolower(pathinfo($value,PATHINFO_EXTENSION));
	if(($imageFileType != "jpg" || $jpg==0)  && ($imageFileType != "png" || $png==0) && ($imageFileType != "jpeg" || $jpg==0) && ($imageFileType != "gif" || $gif==0) && ($imageFileType != "pdf" || $pdf==0) ) {} 
	else
	{
		$dados_imagem=getimagesize($diretorio."/"."$value");
		if ($imageFileType != "pdf")
			{$nome_src=$diretorio."/".$value;}
		else { $nome_src="super_pdf_thumb.php?pdf=".$diretorio."/".$value;}
		echo "<tr><td id=\'valor_".$conta."\'>".$value."</td>
		<td id=\'extensao_".$conta."\'>".$imageFileType."</td>
		<td><img src=\'".$nome_src."\' style=\'width: 200px; height: auto; background-color: white\'></td>
		<td><input type=\'button\' value=\'seleciona\'onclick=\'
		var dir_forcado=\"../su_imagens/\"; // a ideia era tentar ter como saber na tela qual o dir... isso aqui precisa de revisao
		try {
			var tipo_tag=window.opener.document.getElementById(\"".$id_input_path."\").tagName;
			if (tipo_tag==\"SPAN\"){dir_forcado=\"".$diretorio."/\";} else {dir_forcado=\"../su_imagens/\";}
			window.opener.document.getElementById(\"".$id_input_path."\").value=\"".$diretorio_puro."\";
	       	window.opener.document.getElementById(\"".$id_input_path."\").setAttribute(\"data-alterado\", \"alterado\");
	    }
		catch(err) {alert(\"Ignore esse erro e seja uma pessoa feliz! \"+err.message);}
		window.opener.document.getElementById(\"".$id_input."\").value=dir_forcado+document.getElementById(\"valor_".$conta."\").innerText;
		window.opener.document.getElementById(\"".$id_input."\").setAttribute(\"data-alterado\", \"alterado\");
		window.opener.document.getElementById(\"".$id_input_img."\").setAttribute(\"data-ja-tentei\", \"nao\");
		if (document.getElementById(\"extensao_".$conta."\").innerText!=\"pdf\"){
		window.opener.document.getElementById(\"".$id_input_img."\").src=\"".$diretorio."\"+\"/\"+document.getElementById(\"valor_".$conta."\").innerText;} else {
								window.opener.document.getElementById(\"".$id_input_img."\").src=\"super_pdf_thumb.php?pdf=".$diretorio."\"+\"/\"+document.getElementById(\"valor_".$conta."\").innerText;}
		window.close();
		\'/></td>
      <td><input type=\'button\' value=\'apaga\' onclick=\'apaga(".\'"\'.$diretorio.\'"\'.",document.getElementById(".\'"valor_\'.$conta.\'"\'.").innerText)\'></td>
      <td>".$dados_imagem[0]."x".$dados_imagem[1]."<br>".$dados_imagem["mime"]."</td>
      <td><b>Imagem usada por:</b><br>";
		//require("../su_install/'.$arqconfig .'");
		require_once "'.$arqconfig.'";
	$conn= new mysqli("localhost", $username, $pass, $database);

$sql="
select col.TABLE_NAME as \'table\',
       col.ordinal_position as col_id, col.data_type as dt, col.character_maximum_length as ml,
       col.COLUMN_NAME as COLUMN_NAME,
       case when kcu.REFERENCED_TABLE_SCHEMA is null
            then null
            else \'>-\' end as rel,
       kcu.REFERENCED_TABLE_NAME
              as primary_table,
       kcu.REFERENCED_COLUMN_NAME as pk_COLUMN_NAME,
       kcu.constraint_name as fk_constraint_name
       from information_schema.columns col
       join information_schema.tables tab
            on col.TABLE_SCHEMA = tab.TABLE_SCHEMA
	         and col.TABLE_NAME = tab.TABLE_NAME
		 left join information_schema.key_column_usage kcu
		      on col.TABLE_SCHEMA = kcu.TABLE_SCHEMA
		           and col.TABLE_NAME = kcu.TABLE_NAME
			        and col.COLUMN_NAME = kcu.COLUMN_NAME
				     and kcu.REFERENCED_TABLE_SCHEMA is not null
				     where col.TABLE_SCHEMA not in(\'information_schema\',\'sys\',
					                                   \'mysql\', \'performance_schema\')
									         and tab.table_type = \'BASE TABLE\'
										 and col.TABLE_SCHEMA = \'".$banco."\'
										 order by col.TABLE_SCHEMA,
										          col.TABLE_NAME,
											           col.ordinal_position;

";

					$result=$conn->query("$sql");


					if ($result->num_rows>0) {
					  while($row=$result->fetch_assoc())
					    {
					      $tabela=$row["table"];
					      $nome_coluna=trim($row["COLUMN_NAME"]);
					      if (stripos($nome_coluna,"photo_filename_")===false){} else {
                                                        $sql2="select ".$nome_coluna." from ".$tabela." where ".$nome_coluna."=\'".$value."\'";
							$result2=$conn->query("$sql2");
							if ($result2->num_rows>0) {
					  			while($row2=$result2->fetch_assoc())
					    			{
					      				$filename=$row2[$nome_coluna];
										echo "Tabela: ".$tabela."<br>";
					    			}
							} else {}

					      }
					   }
					}
echo "</td></tr>";
					$conta=$conta+1;
				}
	}

echo "
</table>

<script>
function recarrega(jpg, png, gif, pdf){
 var jpg_selecionado=jpg & 1;
 var png_selecionado=png & 1;
 var gif_selecionado=gif & 1;
 var pdf_selecionado=pdf & 1;


          var resposta=\'\';
           var url=\'super_mostra_diretorio_imagens.php?banco=".$banco."&diretorio=".$diretorio_puro."&id_input=".$id_input."&id_input_path=".$id_input_path."&id_input_img=".$id_input_img."&jpg=\'+jpg_selecionado+\'&gif=\'+gif_selecionado+\'&png=\'+png_selecionado+\'&pdf=\'+pdf_selecionado;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     document.body.innerHTML=resposta;
                     }
           oReq.send();


}

function apaga(diretorio, arquivo){

if (confirm(\'Tem certeza que você quer apagar o arquivo \'+arquivo+\' do diretório su_imagens?\'))
{
           var resposta=\'\';
           var url=\'apaga_imagens.php?arquivo=../su_imagens/\'+arquivo;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
		     alert(resposta);
			var resposta2=\'\';
           		var url2=\'super_mostra_diretorio_imagens.php?banco=".$banco."&diretorio=".$diretorio_puro."&id_input=".$id_input."&id_input_path=".$id_input_path."&id_input_img=".$id_input_img."&jpg=1&gif=1&png=1&pdf=1\';
           		var oReq2=new XMLHttpRequest();
           		oReq2.open(\'GET\', url2, false);
	           	oReq2.onload = function (e) {
                     		resposta2=oReq2.responseText;
                                document.body.innerHTML=\'\';
                                document.body.innerHTML=resposta2;
                     		}
           		oReq2.send();
                     }
           oReq.send();
}
}
</script>

</body>
</html>
";


?>
';

fwrite($fs_busca_inteiro,$busca);
fclose($fs_busca_inteiro);
}
//
/* ######################## >>>>   FUNÇÃO 5: Cria_Upload_PHP   <<<<< ########################                         */
// objetivo: cria o PHP que vai buscar uma string na tabela citada pela tabela fk da atual (quando não tem nome_% na atual)
function Cria_Upload_PHP(){
	global $mensagens;
	global $arqconfig;
	setlocale(LC_ALL, 'pt_BR');
	$fs_busca_inteiro=fopen('../su_autophp/super_grava_imagem.php','w');
	Envia_mensagem($mensagens['Mens24']);
	$busca='<?php
//require_once "../su_install/super_config_php.cnf";					 
require_once "'.$arqconfig.'";					 
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

// Criado a partir de padrão do W3C
$target_dir = "../su_imagens/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Verifica se a imagem é real ou fake... 
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "O arquivo contém uma imagem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "O arquivo não contém uma imagem.";
        $uploadOk = 0;
    }
}
// Verifica se o arquivo existe
if (file_exists($target_file)) {
    echo "Desculpe, mas este arquivo já existe. Troque o nome antes de subir.";
    $uploadOk = 0;
}
// Verifica o tamanho do arquivo
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Desculpe, mas seu arquivo é muito grande!.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" 
 
&& $imageFileType != "gif" ) {
    echo "Apenas arquivos JPG, JPEG, PNG & GIF são permitidos.";
    $uploadOk = 0;
}
// verifica se uploadok está 0 por um erro
if ($uploadOk == 0) {
    echo "Desculpe, mas não foi possível subir seu arquivo.";
// Se tudo estiver ok, tente subir o arquivo (upload)
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Legal! O arquivo ". basename( $_FILES["fileToUpload"]["name"]). " foi uploaded.";
    } else {
        echo "Desculpe, houve um erro no processo de upload do seu arquivo". basename( $_FILES["fileToUpload"]["name"]);
    }
}
?>

';

fwrite($fs_busca_inteiro,$busca);
fclose($fs_busca_inteiro);
}
/* ##################### >>>>   FUNÇÃO 6: Cria_super_busca_registro_inteiro   <<<<< #####################                         */
// objetivo: cria o PHP que vai buscar uma string na tabela citada pela tabela fk da atual (quando não tem nome_% na atual)
function Cria_super_busca_registro_inteiro(){  
	global $mensagens;
	global $arqconfig;
	setlocale(LC_ALL, 'pt_BR');
	$fs_busca_inteiro=fopen('../su_autophp/super_busca_registro_inteiro.php','w');
	Envia_mensagem($mensagens['Mens25']);
	$busca='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["nome_chave_primaria"])){
  $nome_chave_primaria = $_GET["nome_chave_primaria"];
}

if(isset($_GET["busca_str"])){
  $busca_str = $_GET["busca_str"];
}

$conn= new mysqli("localhost", $username, $pass, $database);

$campos_excluidos = array();
$sql_excluidos="select nome_do_campo_excluido from excluidos_sub_views";

$result_excluidos=$conn->query("$sql_excluidos");
if ($result_excluidos->num_rows>0) {  // aqui nos vamos montar o query que busca as chaves primárias
  while($row_excluidos=$result_excluidos->fetch_assoc())
    {
      $coluna_excluida=$row_excluidos["nome_do_campo_excluido"];
      $campos_excluidos[]=$coluna_excluida;
    }
} 

                      $sql5="select ".$nome_chave_primaria." from ".$tabela.";";
                      $result_5=$conn->query("$sql5");

if ($result_5->num_rows>0){
while ($row5=$result_5->fetch_assoc())
{
$id_chave_primaria=$row5[$nome_chave_primaria];

$sql="select col.TABLE_NAME as \'table\',
       col.ordinal_position as col_id, col.data_type as dt, col.character_maximum_length as ml,
       col.COLUMN_NAME as COLUMN_NAME,
       case when kcu.REFERENCED_TABLE_SCHEMA is null
            then null
            else \'>-\' end as rel,
       kcu.REFERENCED_TABLE_NAME
              as primary_table,
       kcu.REFERENCED_COLUMN_NAME as pk_COLUMN_NAME,
       kcu.constraint_name as fk_constraint_name
       from information_schema.columns col
       join information_schema.tables tab
            on col.TABLE_SCHEMA = tab.TABLE_SCHEMA
                 and col.TABLE_NAME = tab.TABLE_NAME
                 left join information_schema.key_column_usage kcu
                      on col.TABLE_SCHEMA = kcu.TABLE_SCHEMA
                           and col.TABLE_NAME = kcu.TABLE_NAME
                                and col.COLUMN_NAME = kcu.COLUMN_NAME
                                     and kcu.REFERENCED_TABLE_SCHEMA is not null
                                     where col.TABLE_SCHEMA not in(\'information_schema\',\'sys\',
                                                                           \'mysql\', \'performance_schema\')
                                                                                 and tab.table_type = \'BASE TABLE\'
                                                                                 and col.TABLE_SCHEMA = \'".$banco."\'
                                                                                 and tab.TABLE_NAME= \'".$tabela."\'
                                                                                 order by col.TABLE_SCHEMA,
                                                                                          col.TABLE_NAME,
                                                                                                   col.ordinal_position;";

$result=$conn->query("$sql");

$acumula_colunas="";
$acumula_tabelas_fk="";
$virgula="";
$virgula_tables="";
$sub_select="";
$chave_primaria=""; // chave primaria da tabela atual
if ($result->num_rows>0) {  // aqui nos vamos montar o query que busca as chaves primárias
  while($row=$result->fetch_assoc())
    {
      $nome_coluna=$row["COLUMN_NAME"];
      $primary_table=$row["primary_table"];
      $primary_column=$row["pk_COLUMN_NAME"];
      if (strpos($nome_coluna, "id_chave") !== false) {$chave_primaria=$nome_coluna;}  // assume que chave primária é sempre o primeiro campo da tabela. Se não for asssim: crash!
      if (in_array($nome_coluna, $campos_excluidos)) {} else
      {
	      if ($primary_table!="") // esse if é para formar a lista concatenada de campos. Esse if também geraa os selects que vão buscar na tabela primária  os nomes
		{
  
		      $acumula_tabelas_fk=$acumula_tabelas_fk.$virgula_table.$primary_table;
		      $virgula_table=", ";

		      $sql3="select ".$nome_coluna." from ".$tabela." where ".$chave_primaria." =\'".$id_chave_primaria."\'";
                      $result_3=$conn->query("$sql3");
         
                      if ($result_3->num_rows>0) {
				while ($row3=$result_3->fetch_assoc())
				{
					$id_fk=$row3[$nome_coluna]; // esse é o id que precisa ser procurado na tabela FK
				} // while
		      } //if result_3>numrows
		      $sql2="select COLUMN_NAME from information_schema.columns where TABLE_NAME=\'".$primary_table."\' and COLUMN_NAME like \'nome_%\'";
                      $result_2=$conn->query("$sql2");
         
                      if ($result_2->num_rows>0) {
				while ($row2=$result_2->fetch_assoc())
				{
					$coluna_com_nome=$row2["COLUMN_NAME"];
				} // while
		      } //if result_2>numrows
                      else {$coluna_com_nome="nao_achei_nome";}
		      
		      $sub_select="(select ".$coluna_com_nome." from ".$primary_table." where ".$primary_column."=".$id_fk.")";
		      $nome_coluna=$sub_select;
    		}
	      $acumula_colunas=$acumula_colunas.$virgula.$nome_coluna;

	      $virgula=", \'/\' , ";
    }
    }
} else {echo \'Deu Problema: \'.$conn->error;}
$sql_final= "select CONCAT(".$acumula_colunas.") as saida from ".$tabela." where ".$nome_chave_primaria." = ".$id_chave_primaria.";";
$result_final=$conn->query("$sql_final");
if ($result_final->num_rows>0){
	while ($row_final=$result_final->fetch_assoc())
		{
		    $saida=$row_final["saida"];
		}
}
if ((stripos($saida, $busca_str) === 0) || $busca_str=="") {echo $saida."<rb>".$id_chave_primaria."<br>";} 

$acumula_colunas="";
}
} else {echo "Tabela vazia: ".$conn->error;}
?>
';
fwrite($fs_busca_inteiro,$busca);
fclose($fs_busca_inteiro);
}
/* ######################## >>>>   FUNÇÃO 7: Cria_Busca_Like   <<<<< ########################                       */
// objetivo:
function Cria_Busca_Like(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_busca=fopen('../su_autophp/super_busca_str.php','w');
	Envia_mensagem($mensagens['Mens26']);
	$busca='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["campo"])){
  $campo = $_GET["campo"];
}

if(isset($_GET["str_busca"])){
  $str_busca = $_GET["str_busca"];
}

$database=$banco;

$conn= new mysqli("localhost", $username, $pass, $database);
	$sql="select COLUMN_NAME from information_schema.columns where TABLE_NAME=\'".$tabela."\' and COLUMN_NAME like \'nome_%\'";
$result=$conn->query("$sql");

if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
      $campo_nome=$row["COLUMN_NAME"];
   }
} else {echo "Não veio nome_";};

	$sql="select COLUMN_NAME from information_schema.columns where TABLE_NAME=\'".$tabela."\' and COLUMN_NAME like \'id_chave__%\'";
$result=$conn->query("$sql");

if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
      $campo_id=$row["COLUMN_NAME"];
   }
} else {echo "Não veio nome_";};

$sql="select ".$campo_id.",".$campo_nome." from ".$tabela." where ".$campo_nome." like \'".$str_busca."%\';";
$result=$conn->query("$sql");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
	$nome=$row[$campo_nome];
	$id=$row[$campo_id];
        echo $nome."<rb>".$id."<br>";

    }
} else {echo "vazio";}

?>

';

fwrite($fs_busca,$busca);
fclose($fs_busca);

}
/* ######################## >>>>   FUNÇÃO 8: Cria_auto_insere_php   <<<<< ########################                       */
// objetivo:
function Cria_auto_insere_php(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_php=fopen('../su_autophp/super_insere_registro.php','w');
	Envia_mensagem($mensagens['Mens27']);
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["campos"])){
  $campos = $_GET["campos"];
}

if(isset($_GET["valores"])){
  $valores = $_GET["valores"];
}

$database=$banco;

$conn= new mysqli("localhost", $username, $pass, $database);

$sql="insert into ".$tabela."  (".$campos.") values (".$valores.")";
if ($conn->query($sql)!==true){echo "<br> Deu problema com o sql: ".$sql." erro:".$conn->error;}

return;
?>
';
fwrite($fs_php,$php);
fclose($fs_php);

}
/* ######################## >>>>   FUNÇÃO 9: Cria_auto_apaga_php   <<<<< ########################                       */
// objetivo:
function Cria_auto_apaga_php(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_php=fopen('../su_autophp/super_apaga_registro.php','w');
	Envia_mensagem($mensagens['Mens28']);
	// var url=\'super_atualiza_campos.php?banco='.$banco.'&tabela=\'+campo.getAttribute(\'data-tabela\')+\'&campo=\'+campo.getAttribute(\'data-campo\')+\'&id=\'+campo.getAttribute(\'id_do_registro\')+\'&valor=\+campo.value;
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["id"])){
  $id = $_GET["id"];
}

$campo_nome=\'\';
$achado=\'\';

$database=$banco;
$conn= new mysqli("localhost", $username, $pass, $database);

	$sql="select COLUMN_NAME from information_schema.columns where TABLE_NAME=\'".$tabela."\' and COLUMN_NAME like \'id_chave_%\'";
$result=$conn->query("$sql");

if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
      $campo_nome=$row["COLUMN_NAME"];
   }
} else {echo "Não veio id_chave_";};

$sql="delete from  ".$tabela."  where ".$campo_nome."=".$id;

if ($conn->query($sql)===true){ echo "Registro foi apagado";} else {echo "<br> Deu problema com o sql: ".$sql." erro:".$conn->error;}
return;
?>
';
fwrite($fs_php,$php);
fclose($fs_php);

}
/* ######################## >>>>   FUNÇÃO 10: Cria_auto_alterar_php   <<<<< ########################                       */
// objetivo:
function Cria_auto_alterar_php(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_php=fopen('../su_autophp/super_atualiza_campos.php','w');
	Envia_mensagem($mensagens['Mens29']);
	// var url=\'super_atualiza_campos.php?banco='.$banco.'&tabela=\'+campo.getAttribute(\'data-tabela\')+\'&campo=\'+campo.getAttribute(\'data-campo\')+\'&id=\'+campo.getAttribute(\'id_do_registro\')+\'&valor=\+campo.value;
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["campo"])){
  $campo = $_GET["campo"];
}

if(isset($_GET["id"])){
  $id = $_GET["id"];
}

if(isset($_GET["valor"])){
  $valor = $_GET["valor"];
}

$campo_nome=\'\';
$achado=\'\';

$database=$banco;
$conn= new mysqli("localhost", $username, $pass, $database);

	$sql="select COLUMN_NAME from information_schema.columns where TABLE_NAME=\'".$tabela."\' and COLUMN_NAME like \'id_chave_%\'";
$result=$conn->query("$sql");

if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
      $campo_nome=$row["COLUMN_NAME"];
   }
} else {echo "Não veio id_chave_";};

$sql="update ".$tabela." set ".$campo."=\'".$valor."\' where ".$campo_nome."=".$id;

if ($conn->query($sql)===true){ echo "Atualização de nome efetivada";} else {echo "<br> Deu problema com o sql: ".$sql." erro:".$conn->error;}
return;
?>
';
fwrite($fs_php,$php);
fclose($fs_php);

}
/* ######################## >>>>   FUNÇÃO 11: Cria_auto_ler_php   <<<<< ########################                       */
// objetivo:
function Cria_auto_ler_php(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_php=fopen('../su_autophp/super_auto_ler_tabela_campo.php','w');
	Envia_mensagem($mensagens['Mens30']);
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";


if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["campo_id"])){
  $campo_id = $_GET["campo_id"];
}
if(isset($_GET["id"])){
  $id = $_GET["id"];
}

$campo_nome=\'\';
$achado=\'\';

$database=$banco;
$conn= new mysqli("localhost", $username, $pass, $database);

	$sql="select COLUMN_NAME from information_schema.columns where TABLE_NAME=\'".$tabela."\' and COLUMN_NAME like \'nome_%\'";
$result=$conn->query("$sql");

if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
      $campo_nome=$row["COLUMN_NAME"];
   }
} else {echo "Não veio nome_";};

$sql="select ".$campo_nome." from ".$tabela." where ".$campo_id." =".$id;

$result=$conn->query("$sql");

if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
      $achado=$row[$campo_nome];
   }
};
echo $achado;
?>
';
fwrite($fs_php,$php);
fclose($fs_php);

}
/* ##################### >>>>   FUNÇÃO 12: Insere_tabelas_de_ligacao   <<<<< ####################                       */
// objetivo:
function Insere_tabelas_de_ligacao($fs_join,$banco, $tabela, $campos, $fks_table, $fks_campos){
	global $arqconfig;
	global $mensagens;
	require("$arqconfig");
//	Envia_mensagem($mensagens['Mens31']);
	$campos_com_fks=array();	// eu sei que tem dois porque a chama filtra
	$fks_fields=array();		// eu sei que tem dois porque a chama filtra
	$fks_tables=array();		// eu sei que tem dois porque a chama filtra
	$conta=0;
	$campo_id_chave="";
	foreach($campos as $value){ 
		if ($fks_table[$tabela.$value]!='') {
			$campos_com_fks[$conta]=$value; 
			$fks_fields[$conta]=$fks_campos[$tabela.$value];
			$fks_tables[$conta]=$fks_table[$tabela.$value];
			$conta=$conta+1;
		}
		if (strpos($value,'id_chave')===false){} else {$campo_id_chave=$value;}
	}

	// fk_tables[0] e [1] contém o nome das tabelas remotas 
	// fk_fields[0] e [1] contém o nome dos campos das chaves primárias na tabela remota.
	// $tabela é a tabela_de_ligacao
	// $campos_com_fks[0] e [1] me parece que é o nome do campo da chave externa na tabela de ligação 

	$database=$banco;
	$conn_local= new mysqli("localhost", $username, $pass, $database);

	$sql1="select COLUMN_NAME as nome0 from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA='".$banco."' and TABLE_NAME='".$fks_tables[0]."' and COLUMN_NAME like 'nome_%';";

	$result=$conn_local->query("$sql1");
	if ($result->num_rows>0) {
		while($row=$result->fetch_assoc())
		{
			$nome0=$row["nome0"];
		}
	}  else {$nome0= "nao achou o campo comecando com nome_0";}
	$sql2="select COLUMN_NAME as nome1 from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA='".$banco."' and TABLE_NAME='".$fks_tables[1]."' and COLUMN_NAME like 'nome_%';";

	$result=$conn_local->query("$sql2");
	if ($result->num_rows>0) {
		while($row=$result->fetch_assoc())
		{
			$nome1=$row["nome1"];
		}
	}  else {$nome1= "nao achou o campo comecando com nome_1";}
	$sql_insert='insert into su_tabelas_ligacao (
												nome_tabela_de_ligacao           ,
												campo_externo1_tabela_de_ligacao ,
												campo_externo2_tabela_de_ligacao ,
												tabela_externa1                  ,
												campo_name_tabela_externa1       ,
												campo_id_tabela_externa1         ,
												tabela_externa2                  ,
												campo_name_tabela_externa2		 , 
												campo_id_tabela_externa2         
												) values 
												(
												"'.$tabela.'",
												"'.$campos_com_fks[0].'",
												"'.$campos_com_fks[1].'",
												"'.$fks_tables[0].'",
												"'.$nome0.'",
												"'.$fks_fields[0].'",
												"'.$fks_tables[1].'",
												"'.$nome1.'",
												"'.$fks_fields[1].'"
												); ';

	if ($conn_local->query($sql_insert)!==true){echo "<br> Deu problema com o sql: ".$sql_insert." erro:".$conn_local->error;}

} // fim Insere_tabelas_de_ligacao
/* ######################## >>>>   FUNÇÃO 13: Cria_join_view   <<<<< ########################                       */
// objetivo:
// nota: esta funcao cria dois views de tabelas com 2 FKs. Os 2 views têm ordem invertida. Para facilitar eu simplesmente reaproveitei código... invertendo a SQL
// além disso (2021_04_16) esta função passou a preencher a tabela "su_tabelas_ligacao" da base de dados.
function Cria_join_view($fs_join,$banco, $tabela, $campos, $fks_table, $fks_campos){
	global $arqconfig;
	global $mensagens;
	//Envia_mensagem($mensagens['Mens32']);
	Insere_tabelas_de_ligacao($fs_join,$banco, $tabela, $campos, $fks_table, $fks_campos);
	$campos_com_fks=array();	// eu sei que tem dois porque a chama filtra
	$fks_fields=array();		// eu sei que tem dois porque a chama filtra
	$fks_tables=array();		// eu sei que tem dois porque a chama filtra
	$conta=0;
	$campo_id_chave="";
	foreach($campos as $value){ 
		if ($fks_table[$tabela.$value]!='') {
			$campos_com_fks[$conta]=$value; 
			$fks_fields[$conta]=$fks_campos[$tabela.$value];
			$fks_tables[$conta]=$fks_table[$tabela.$value];
			$conta=$conta+1;
		}
		if (strpos($value,'id_chave')===false){} else {$campo_id_chave=$value;}
	}
	$sql1='select COLUMN_NAME as nome0 from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA=\''.$banco.'\' and TABLE_NAME=\''.$fks_tables[0].'\' and COLUMN_NAME like \'nome_%\';';

	$sql2='select COLUMN_NAME as nome1 from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA=\''.$banco.'\' and TABLE_NAME=\''.$fks_tables[1].'\' and COLUMN_NAME like \'nome_%\';';

	$php= '<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

echo "
<html>
<head>
<title>Inserção de dados: '.$tabela.'</title>
<link rel=\'stylesheet\' href=\'../su_css/super_cria_joinview.css\' type=\'text/css\'>
<meta http-equiv=\'Cache-Control\' content=\'no-cache, no-store, must-revalidate\'/>
<meta http-equiv=\'Pragma\' content=\'no-cache\'/>
<meta http-equiv=\'Expires\' content=\'0\'/>

<meta charset=\'UTF-8\'>
</head>
<body id=\'conteudo\'>
<div class=\'cabecalio\'>
<h1>Duas Visualizações Left Join: '.$tabela.'</h1>
</div>

<table>

<tr>
<th>Ordem Direta</th><th>Ordem Inversa</th>
</tr>
<tr>
<td>
<table>
<tr>
<th>'.$fks_fields[0].'</th><th>'.$fks_fields[1].'</th>
</tr>
";

$conn= new mysqli("localhost", $username, $pass, $banco);

$sql1="'.$sql1.'";

$result=$conn->query("$sql1");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
       $nome0=$row["nome0"];
    }
}  else {echo "nao achou o campo comecando com nome_1";}

$sql2="'.$sql2.'";

$result=$conn->query("$sql2");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
       $nome1=$row["nome1"];
    }
}
$sql="select ".$nome0." as n0, ".$nome1." as n1 from  '.$fks_tables[0].' as a, '.$tabela.' as b left join '.$fks_tables[1].' as c on b.'.$campos_com_fks[1].'=c.'.$fks_fields[1].' where b.'.$campos_com_fks[0].'=a.'.$fks_fields[0].'  order by ".$nome0.";";

$result=$conn->query("$sql");
$velho="";
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
       $campo_1=$row["n0"];
       $campo_2=$row["n1"];
	if (($velho!=$campo_1) && ($velho!="")) {echo "</td></tr>";}
       if ($velho!=$campo_1) { $velho=$campo_1;
                                echo "<tr>
	<td class=\'fks_field\' data-default=\'\' data-fks-table=\''.$fks_tables[0].'\' data-fks-field=\''.$fks_fields[0].'\' data-fkid=\'".$campo_1."\'>".$campo_1."</td>
	<td class=\'fks_field\' data-default=\'\' data-fks-table=\''.$fks_tables[1].'\' data-fks-field=\''.$fks_fields[1].'\' data-fkid=\'".$campo_2."\'>".$campo_2."<br>";

                             }
        else {

            echo $campo_2."<br>";

         }

    }

	echo "</td></tr>";

} else {echo "Erro: ".$conn->error;}
echo "
</table>
</td>
<td>
<table>
<tr>
<th>'.$fks_fields[1].'</th><th>'.$fks_fields[0].'</th>
</tr>";

$sql="select ".$nome1." as n0, ".$nome0." as n1 from  '.$fks_tables[1].' as a, '.$tabela.' as b left join '.$fks_tables[0].' as c on b.'.$campos_com_fks[0].'=c.'.$fks_fields[0].' where b.'.$campos_com_fks[1].'=a.'.$fks_fields[1].'  order by ".$nome1.";";

$result=$conn->query("$sql");
$velho="";
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
       $campo_1=$row["n0"];
       $campo_2=$row["n1"];
	if (($velho!=$campo_1) && ($velho!="")) {echo "</td></tr>";}
       if ($velho!=$campo_1) { $velho=$campo_1;
                                echo "<tr>
	<td class=\'fks_field\' data-default=\'\' data-fks-table=\''.$fks_tables[0].'\' data-fks-field=\''.$fks_fields[0].'\' data-fkid=\'".$campo_1."\'>".$campo_1."</td>
	<td class=\'fks_field\' data-default=\'\' data-fks-table=\''.$fks_tables[1].'\' data-fks-field=\''.$fks_fields[1].'\' data-fkid=\'".$campo_2."\'>".$campo_2."<br>";
                             }
        else {
            echo $campo_2."<br>";
         }

    }
	echo "</td></tr>";
} else {echo "Erro: ".$conn->error;}
echo "
</table>

</td>
</tr>
</table>
</body>
</html>

";

?>
';

fwrite($fs_join,iconv('UTF-8','UTF-8',$php)."\n");

}
/* ######################## >>>>   FUNÇÃO 14: Cria_insere   <<<<< ########################                       */
// objetivo:
function Cria_insere($fs,$banco, $tabela, $campos, $fks_table, $fks_campos){
	global $limitador_registros;
	global $arqconfig;
	global $mensagens;
	require("$arqconfig");
	$campo_tem_nome="";

	foreach($campos as $value){ // acha o nome do campo nome_%
		if (strpos($value,'nome_')===false){} else {$campo_tem_nome=" order by ".$value;}
	}
	$php='<?php
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

if(isset($_GET["offset"])){
  $offset = $_GET["offset"];
}
if(isset($_GET["limit"])){
  $limit = $_GET["limit"];
}
if(isset($_GET["campo_busca"])){
  $campo_busca = $_GET["campo_busca"];
}
if(isset($_GET["valor_busca"])){
  $valor_busca = $_GET["valor_busca"];
}

if(isset($_GET["scrollx"])){
  $scrollx = $_GET["scrollx"];
} else {$scrollx=0;}

if(isset($_GET["scrolly"])){
  $scrolly = $_GET["scrolly"];
} else {$scrolly=0;}


$limitador_registros_insere='.$limitador_registros.';

echo "
<html>
<head>
<title>Inserção de dados na tabela: '.$tabela.' ".$campo_busca."</title>
<link rel=\'stylesheet\' href=\'../su_css/super_cria_insere.css\' type=\'text/css\'>
<meta http-equiv=\'Cache-Control\' content=\'no-cache, no-store, must-revalidate\'/>
<meta http-equiv=\'Pragma\' content=\'no-cache\'/>
<meta http-equiv=\'Expires\' content=\'0\'/>

<meta charset=\'UTF-8\'>
</head>
<body id=\'conteudo\'>
<div class=\'cabecalio\'>
<h1>'.$mensagens['Mens12'].$tabela.'</h1>
<div id=\'id_comentario_tabela\' style=\'border: 2px solid blue; background: yellow\'></div>
</div>
<div id=\'insercao\' class=\'botoeira\'>
</div>
";
$path_imagem="";

$conn= new mysqli("localhost", $username, $pass, $banco);

$sql_comment="SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = \'".$banco."\' AND TABLE_NAME = \''.$tabela.'\';";

$result_comment=$conn->query("$sql_comment");

if ($result_comment->num_rows>0) {
 	while($row_comment=$result_comment->fetch_assoc()){
		$comentario=$row_comment["TABLE_COMMENT"];	
	}

} else {$comentario="Esta tabela não tem comentários.";}

echo "<script>document.getElementById(\'id_comentario_tabela\').innerHTML=\'".$comentario."\';</script>";

$sql="select count(*) from '.$tabela.'";
$result=$conn->query("$sql");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
	$contagem_registro=$row["count(*)"];
    }
}
echo "<div style=\'border: 1px solid black; background-color: orange; width: 100%\'>
	<table style=\'width: 100%\'>
	<tr>
		<td> Número total de registros: ".$contagem_registro."</td>
		<td> Registro Inicial:".$offset."</td>
		<td> Registros por pagina:".$limit."</td>
	</tr>
	</table>
</div>
"; 

$numero_paginas=intdiv($contagem_registro,$limit)+1;
echo "<div style=\'width: 100%; height: 40px; overflow-y: scroll\'>";
for ($i_pag = 1; $i_pag <= $numero_paginas; $i_pag++) {
    $delta_offset=($i_pag-1)*$limit;	
    echo "<input class=\'pagina\' type=\'button\' style=\'width: 90px;\' value=\'Pág.".$i_pag." (".$delta_offset.")\'  onclick=\'carrega_offset(".$limit.",".$delta_offset.");\'></input>";
}
echo "</div>";
';

$php2='
echo "
<table class=\'botoeira\'>
<tr class=\'cabecalio_table\'><th></th>';

$busca_id_chave="";
$busca_nome="";
$busca_data="";
$ths="";

// este for coloca os THs e define os tipos de busca a partir dos nomes dos campos
foreach($campos as $value){
$valor=$value;

$campo_de_busca='<input type=\'text\' id=\'id_campo_de_search\' data-nivel=\'0\' placeholder=\'Coloque a consulta aqui!\' />';

$busca_ultimo='<input type=\'button\' data-nivel=\'0\' name=\'busca_principal\' value=\'ultimo\'/>';

$botao_busca='<input type=\'button\' value=\'Todos\' data-nivel=\'0\'/>';

if ($fks_table[$tabela.$value]=="") {$mensagem='carrega_busca(`'.$value.'`,itz,50,0);';} else {$mensagem='alert(`Busca por chave externa ainda não implementada!`)';}

$itz='<input 
				type=\'button\'
				value=\''.$value.'\' 
				data-nivel=\'0\' 
				name=\'busca_principal\'
				onclick=\'var itz=document.getElementById(`id_campo_de_search`).value;  if (itz===``) {alert(`Você deixou o campo de busca vazio!`);} else {'.$mensagem.';}\'
			>';

if (strpos($value,'id_chave')===false){} else {$valor='id'; $busca_id_chave=$itz;}
if (strpos($value,'nome_')===false){} else {$busca_nome=$itz;}
if (strpos($value,'data')===false){} else {$busca_data=$itz;}
$ths=$ths."<th>".iconv('UTF-8','UTF-8',$valor)."</th>";
}
$ths=$ths.'</tr>";';
$conta=0;

// O string abaixo será jogado no arquivo do programa php que lê a tabela. 

$php_itz='
// esta parte é para colocar os campos de busca

echo "
<div style=\'border: 1px solid black; background-color: green; width: 100%\'><table style=\'width: 100%\'><tr><td>'.$mensagens['Mens15'].$campo_de_busca.'</td><td>'.$busca_id_chave.'</td><td> '.$busca_nome.'</td><td> '.$busca_data.'</td><td> '.$busca_ultimo.'</td><td> '.$botao_busca.'</td></tr></table></div>
";

';

fwrite($fs,iconv('UTF-8','UTF-8',$php.$php_itz.$php2.$ths)."\n");

$consulta_1='

// comeca o query!
$row_number=$offset;

if ($campo_busca=="") {$sql="select * from '.$tabela.$campo_tem_nome.' limit ".$limit." offset ".$offset;}
else {$sql="select * from '.$tabela.' where ".$campo_busca." like \'".$valor_busca."%\' order by \'".$campo_busca."\' limit ".$limit;}
echo $sql;
$result=$conn->query("$sql");
$num_registros_achados=$result->num_rows;
if ($num_registros_achados>0) {
  while($row=$result->fetch_assoc())
    {

$campos_atualizaveis="[";
';

fwrite($fs,iconv('UTF-8','UTF-8',$consulta_1)."\n");

foreach($campos as $value){
fwrite($fs,"\n".'$'.$value.'=$row["'.$value.'"];'."\n");
$conta=$conta+1;
// a variável id_registro permite saber o id do registro que esta sendo lido e isso é importante para determinar o id do campos que são atualizáveis
if (strpos($value,'id_chave')===false){} else {fwrite($fs,"\n".'$id_registro=$row["'.$value.'"];'."\n"); }	
if (strpos($value,'path')===false){} else {fwrite($fs,"\n".'$path_imagem="../".$row["'.$value.'"]."/";'."\n"); }	

     if ($conta==1){$virgula='""';} else {$virgula='","';}   

// só atualiza os campos que não tem foreign key, porque o que tem foreign key ele tem que usar drop-box
if ($fks_table[$tabela.$value]==null)
        {
		if (
		(strpos($value,'id_chave')===false) &&
		(strpos($value,'time_stamp')===false) &&
		(strpos($value,'usuario')===false) 

                   )
		{
			$itz= '$campos_atualizaveis=$campos_atualizaveis.'.$virgula;
			$itz2='.\'"campo_\'.$id_registro.\'_';
			fwrite($fs,$itz.$itz2.$conta.'"'."';"); 
		}
	}
}

fwrite($fs,"\n".'$campos_atualizaveis=$campos_atualizaveis."]";'); 

$consulta_2="\n".'echo "<tr class=\'principal\'><td>".$row_number."</td>';
fwrite($fs,iconv('UTF-8','UTF-8',$consulta_2));

$conta=0;
foreach($campos as $value){
$conta=$conta+1;
if ($fks_table[$tabela.$value]==""){ // verifica se o campo tem um foreign key
        
	if (  //verifica se o campo é passível de ser usado no formato de input/text. Se for, atribui a elemento um input/text
		(strpos($value,'id_chave')===false) &&
		(strpos($value,'time_stamp')===false) &&
		(strpos($value,'usuario')===false) 

	   ){	// este bloco é para o caso do nome do campo não ser id, time_stamp ou usuario
		if (strpos($value,'photo_filename_')===false){$img_src='';} else 
			{ 
				$img_src=
					"
					<img id='campo_src_\".\$id_registro.\"_".$conta."'
					     src='\".\$path_imagem.str_replace(\"/var/www/html/\",\"../\",$".$value.").\"' 
                                             style='background-color: white; width: 100px; height: auto'
                                             data-ja-tentei='nao' 
					     onerror='
						if (this.getAttribute(`data-ja-tentei`)==`nao`){
						var itz=`\".\$path_imagem.str_replace(\"/var/www/html/\",\"../\",$".$value.").\"`;
						var extensao=(itz.split(`.`).pop().toLowerCase());
						if (extensao.indexOf(`pdf`)>-1) {this.src=`super_pdf_thumb.php?pdf=`+itz; this.setAttribute(`data-ja-tentei`,`sim`);}
						}';
					></img><br>
					<input type='button' value='Imagem do Servidor' data-nivel='0' onclick='
						var x=document.getElementsByClassName(\".'\"editavel\"'.\");
						var i;
                                                var identificador;
						for (i = 0; i < x.length; i++) {
						  if (x[i].getAttribute(\".'\"data-id\"'.\")==\$id_registro && x[i].getAttribute(\".'\"data-campo\"'.\").includes(\".'\"path\"'.\")) { identificador=x[i].id;} 
						}	

						var w=window.open(\".'\"\"'.\",\".'\"MostraArquivosDiretorio\"'.\",\".'\"width=1000 height=1000\"'.\");
                                                var resposta=\".'\"\"'.\";
           					var url=\".'\"super_mostra_diretorio_imagens.php?banco=".$banco."&diretorio=su_imagens&id_input=campo_'.\$id_registro.'_".$conta."&id_input_path=\"'.\"+identificador+\".'\"&id_input_img=campo_src_'.\$id_registro.'_".$conta."&jpg=1&png=1&gif=1&pdf=0\"'.\";
           					var oReq=new XMLHttpRequest();
           					oReq.open(\".'\"GET\"'.\", url, false);
           					oReq.onload = function (e) {
                     					resposta=oReq.responseText;
                     					w.document.write(resposta);
                     				}
           					oReq.send();
					'>
				<input type='button' value='Amplia' data-nivel='0' 
					onclick='
						var file_=document.getElementById(\".'\"campo_'.\$id_registro.'_".$conta."\"'.\").value;
						if (file_ != \".'\"\"'.\") {
						var wu=window.open( \".'\"\"'.\", \".'\"Janela_Ampliacao\"'.\", \".'\"width=\"'.\"+screen.availWidth+\".'\" height=\"'.\"+screen.availHeight);
						if (file_.indexOf(\".'\"pdf\"'.\")>-1){
									wu.document.write(\".'\"<embed src=\"+`".'\"'."`+file_.replace(\"/var/www/html\",\"..\")+`".'\"'."`+\" width=800px height=2100px/>\"'.\" );
								} 
								else
								{
									wu.document.write(\".'\"<embed src=\"+`".'\"'."`+file_.replace(\"/var/www/html\",\"..\")+`".'\"'."`+\" width=800px height=auto/>\"'.\" );
								}	
						} else {alert(`Você não selecionou uma imagem!`);}
				'>

					<input type='button' value='Sobe Imagem' data-nivel='0' onclick='
						document.getElementById(\".'\"campo_src_'.\$id_registro.'_".$conta."\"'.\").setAttribute(\".'\"data-ja-tentei\"'.\",\".'\"nao\"'.\"); 
							document.getElementById(\".'\"campo_inputfile_'.\$id_registro.'_".$conta."\"'.\").click();'>
					<input style='display: none' data-nivel='0' id='campo_inputfile_\".\$id_registro.\"_".$conta."'
					     type='file'
                                             onchange='
                                                var resposta=\".'\"\"'.\";
						var nome_arquivo=this.value.replace(/^.*[\\\\\\/]/, \".'\"\"'.\");
						document.getElementById(\".'\"campo_'.\$id_registro.'_".$conta."\"'.\").setAttribute(\".'\"data-alterado\"'.\",\".'\"alterado\"'.\"); 
						document.getElementById(\".'\"campo_'.\$id_registro.'_".$conta."\"'.\").value=`../su_imagens/`+nome_arquivo;      
						var x=document.getElementsByClassName(\".'\"editavel\"'.\");
						var i;
						for (i = 0; i < x.length; i++) {
						  if (x[i].getAttribute(\".'\"data-id\"'.\")==\$id_registro && x[i].getAttribute(\".'\"data-campo\"'.\").includes(\".'\"path\"'.\")) { x[i].value=\".'\"su_imagens\"'.\"; x[i].setAttribute(\".'\"data-alterado\"'.\",\".'\"alterado\"'.\");} 
						}	

 
						if (this.files && this.files[0]) {
                                                        var ide=\".'\"campo_src_'.\$id_registro.'_".$conta."\"'.\";
							var extensao=(files[0].name.split(`.`).pop().toLowerCase());
							document.getElementById(ide).setAttribute(`data-ja-tentei`,`nao`);
							if (extensao.indexOf(`pdf`)<0) {document.getElementById(ide).src=window.URL.createObjectURL(this.files[0]);}
    							var fd = new FormData();
    							fd.append(\".'\"fileToUpload\"'.\", this.files[0], nome_arquivo);
    							var xhr = new XMLHttpRequest();
    							xhr.open(\".'\"POST\"'.\", \".'\"super_grava_imagem.php\"'.\");
                                                        console.log(this.files[0].name);
    							xhr.onloadend = function(e) {
        										resposta=xhr.responseText;
											alert(resposta+` XXX `+files[0].name);
											var thumb=`super_pdf_thumb.php?pdf=../su_imagens/`+files[0].name;
												
											alert(resposta+` ide:`+ide+` thumb:`+thumb);
											if (extensao.indexOf(`pdf`)>-1) {document.getElementById(ide).src=thumb;}
          									    }
							xhr.send(fd);
							}'/>
					"; 
			}	
		$elemento="<td>".$img_src."
				<input 
					id='campo_\".\$id_registro.\"_".$conta."' 
                                        class='editavel'
					type='text' 
					value='\".$".$value.".\"'
					data-alterado='nao'
					data-tabela='".$tabela."'
					data-campo='".$value."'
                                        data-id='\".\$id_registro.\"'
        				data-nivel='0'
				/>
			   </td>";} // esse elemento text é usado para o caso do campos que não são identificadores ou FK 
		else {	// se o campo não for passível de ser mostrado no formato input/text, será mostrado num td normal
			// este condicional não inclui campos que fazem referência a uma FK, situação que é tratada abaixo
				$elemento="<td>\".$".$value.".\"</td>";
                     }
} 
else {
	// se o campo depender de uma foreign key, o valor da chave externa será buscado e não será usado input/text convencional
	// para que o valor possa ser buscado, é preciso indicar a tabela e campo da foreign key (data-fk-tabela e data-fk-id)
	$classe="class='dinamico'"; 
	$nome_tabela="data-fk-tabela='".$fks_table[$tabela.$value]."'"; 
	$nome_campo="data-fk-id='".$fks_campos[$tabela.$value]."'"; 
//	$elemento='<td '.$classe.' '.$nome_tabela.' '.$nome_campo.'>".$'.$value.'."</td>';

// data-drop: indica o identificador do DIV onde ficam os itens do drop-down. Cada input do drop-down precisa indicar um div.
// data-momento: indica se está no momento de insercao ou de atualização
// data-fkid: indica o id do registro da tabela FK que está guardado na tabela dependente
// data-id: indica o id do registro da tabela dependente
// data-banco: indica o banco de dados da tabela dependente
// data-fk-banco: indica o banco de dados da tabela fk
// data-default: guarda o valor que estava no input, para o caso de apertar ESC
// data-fk-tabela: guarda a tabela FK à qual o campo da tabela dependente faz referência
// data-fk-id: guarda o campo id da tabela FK ao qual o campo da tabela dependente faz referência
// data-selecionado: indica o índice do item selecionado com as setas no drop-down
// data-n-itens: indica o número de itens no drop-down (nota: verificar porque não está zerando quando aperta seta-acima até sair do drop)
	$elemento='

<td>
<div class=\'dropdown\'>
  <input type=\'text\' 
	id=\'drop_".$id_registro."_'.$conta.'\' 
	class=\'dropbtn\' 
	onfocusout=\'document.getElementById(".\'"\'."lista_".$id_registro."_'.$conta.'".\'"\'.").setAttribute(".\'"\'."data-keyup".\'"\'.",".\'"\'."inativo".\'"\'.");document.getElementById(".\'"\'."drop_".$id_registro."_'.$conta.'".\'"\'.").setAttribute(".\'"\'."data-selecionado".\'"\'.",".\'"\'."-1".\'"\'."); document.getElementById(".\'"\'."drop_".$id_registro."_'.$conta.'".\'"\'.").setAttribute(".\'"\'."data-n-itens".\'"\'.",".\'"\'."0".\'"\'.");\' 
        data-drop=\'lista_".$id_registro."_'.$conta.'\'
        data-momento=\'atualizacao\'
	data-id=\'".$id_registro."\'
        data-max-itens=\'100\'
	data-banco=\''.$banco.'\' 
	data-tabela=\''.$tabela.'\'
	data-campo=\''.$value.'\' 
	data-fkid=\'".$'.$value.'."\' 
        data-default=\'\'
	data-fk-banco=\''.$banco.'\' 
	data-fk-tabela=\''.$fks_table[$tabela.$value].'\' 
	data-fk-id=\''.$fks_campos[$tabela.$value].'\'
	data-selecionado=\'-1\'
	data-event-blur=\'NAO\'
	data-event-focus=\'NAO\'
	data-event-keyup=\'NAO\'
        data-n-itens=\'0\'
	autocomplete=\'caramba\'
        data-nivel=\'0\'
  />

  <div id=\'lista_".$id_registro."_'.$conta.'\' class=\'dropdown-content\'  data-keyup=\'inativo\'>
  </div>
</div>
</td>
';

     }

fwrite($fs,$elemento); // mostra o elemento e fecha o echo do php, porque precisamos guardar todos os campos atualizáveis

}

$consulta_3='
	<th class=\'classe_ponto_insercao_nton\' id=\'ponto_insercao_nton_".\'"\'.$id_registro.\'"\'."\'>
	".\'\'.$id_registro.\'\'."	
	</th>
	<th>
		<input 
			type=\'button\' 
			value=\'atualiza\'
		        data-nivel=\'0\' 
			onclick=\'var matriz=".$campos_atualizaveis."; atualiza(matriz);\'
		/>
	</th><th>
		<input 
			type=\'button\' 
			value=\'apaga\'
		        data-nivel=\'0\' 
			onclick=\'apaga_registro(".\'"\'.$id_registro.\'"\'.")\'
		/>
	</th></tr>";
    $row_number++;
    }
}

'; //os colchetes acima são do php que está sendo gerado e não deste programa.

fwrite($fs,$consulta_3);
$dir=getcwd();

fwrite($fs,"\n".'echo "
</tr>
</table>
<div  id=\'mensagem_de_carregamento\' style=\'left: 50%; top: 50%; width: auto; height: auto; border: 1px solid black; background-color: yellow; padding: 10px; font-size: 50px; position: absolute;  visibility: visible; z-index:1000\'>Carregando...</div>
<script>

var nivel_insercao=0; // indica o nivel de insercao de dados a que se refere um botao de insercao.
                      // variavel nivel_insercao eh necessaria para limitar os campos de insercao aos que se refere a aquele botao de insercao

var escrolx=".$scrollx.";
var escroly=".$scrolly.";


document.body.scrollLeft=escrolx;
document.body.scrollTop=escroly;



var conta_loads=0;

mostra_botao(\'insercao\',\''.$tabela.'\',\'0\');

setTimeout(function (){document.getElementById(\'mensagem_de_carregamento\').style.visibility=\'hidden\';},1);

document.addEventListener(\'load\', function() {
	document.body.scrollLeft=escrolx; 
	document.body.scrollTop=escroly;
	document.getElementById(\'mensagem_de_carregamento\').innerText=  \'Carregando: \' + conta_loads + \'/".$limitador_registros_insere."\';
    document.getElementById(\'mensagem_de_carregamento\').style.visibility=\'visible\';
	document.getElementById(\'mensagem_de_carregamento\').style.left=Math.trunc(document.body.clientWidth/2 + escrolx - document.getElementById(\'mensagem_de_carregamento\').style.clientWidth/2);
	document.getElementById(\'mensagem_de_carregamento\').style.top=Math.trunc(document.body.clientHeight/2 + escroly - document.getElementById(\'mensagem_de_carregamento\').style.clientHeight/2);

	if(document.getElementById(\'aguarde_inicio\')){
	   document.getElementById(\'aguarde_inicio\').remove();
	} 

    setTimeout(
				function(e) // truque para garantir que em algum momento a mensagem de carregamento vai ser apagada
					{
					     if (conta_loads>".$limitador_registros_insere." - 2 || conta_loads==0 || conta_loads>".$num_registros_achados." -2) {document.getElementById(\'mensagem_de_carregamento\').style.visibility=\'hidden\'; }
					},500);

conta_loads++;
}, true);

function re_carrega_NtoN(ponto_insercao, banco, rtn, rcn, tabela, coluna, campo_externo, id_externo){ // é parecida com carrega_NtoN mas permite recarregar a lista NtoN quando há atualização
// ainda não está sendo usado - o objetivo no futuro é acelerar a atualização


// Dicionário:
// ponto_insercao: id do DIV onde serão colocados os dados
// banco: banco de dados
// rtn:   é o nome da tabela remota de onde vai se buscar nomes para colocar no id_chave
// rcn:   é o nome do campo de chave primária da rtn
// tabela: é a tabela que estabelece a relação n_to_n
// coluna: é a chave externa da tabela acima, que permite buscar o nome na rtn
// campo_externo: é a chave externa que se relaciona com id_chave na <tabela> tratada em super_insere_<tabela>.php
// id_externo: é o valor do campo_externo

           var resposta=\'\';
		   var url=\'super_puxa_lista_NtoN.php?banco=\'+banco+\'&rtn=\'+rtn+\'&rcn=\'+rcn+\'&table_para_search=\'+tabela+\'&coluna=\'+coluna+\'&campo_externo_para_search=\'+campo_externo+\'&id_externo_para_search=\'+id_externo;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
					 document.getElementById(ponto_insercao).innerHTML=resposta;
                     }
           oReq.send();

}// fim re_carrega_NtoN

function carrega_NtoN(ponto_insercao, banco, tabela, campo_externo, id_externo){
           var resposta=\'\';
           var url=\'super_NtoN_insercao.php?banco=\'+banco+\'&tabela_externa_em_edicao=\'+tabela+\'&nivel=0&campo_externo_para_search=\'+campo_externo+\'&id_externo_para_search=\'+id_externo;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
					 document.getElementById(ponto_insercao).innerHTML=resposta;
                     }
           oReq.send();

}// fim carrega_NtoN

function percorre_ponto_insercao(){

var pontos=document.getElementsByClassName(\'classe_ponto_insercao_nton\');
var i;

for (i=0; i<pontos.length; i++){
	console.log(\'varanda: \'+pontos.id);
	carrega_NtoN(pontos[i].id,\''.$tabela.'\',\'id_documento\',document.getElementById(pontos[i].id).innerText);
	// aqui vc tem que passar o nome da tabela NtoN e o nome do campo dessa tabela que é uma chave externa que aponta para o id_chave_ da <tabela> referida neste arquivo isuper_insere_<tabela>.php
} // fim do for

} // fim percorre_ponto_insercao

function ativa_alterados(){
var inputs_inseriveis=document.getElementsByClassName(\'inserivel\');
var i;
var input_inserivel;
for (i=0; i<inputs_inseriveis.length; i++) {
input_inserivel=inputs_inseriveis[i];
input_inserivel.addEventListener(\'keydown\', function(e){e.target.style.backgroundColor=\'#FF0000\';e.target.setAttribute(\'data-alterado\',\'alterado\') }, false);
}
}

ativa_alterados();
if (\''.$tabela.'\'==\'su_documents\'){percorre_ponto_insercao();}

function disable_niveis(){
var x = document.getElementsByTagName(\'INPUT\');
var i;
for (i = 0; i < x.length; i++) {
  console.log(\'TAG INPUT -> \'+x[i].id+\' nivel -> \'+nivel_insercao);
  if (x[i].className==\'pagina\' || x[i].getAttribute(\'data-nivel\')==nivel_insercao) {x[i].disabled=false;} else {x[i].disabled=true;};
}
}

// INICIO DOS SCRIPTS DO DROP MENU

function carrega_drop_btn(element){

  if(element.getAttribute(\'data-momento\')==\'atualizacao\'){
           var resposta=\'\';
           var url=\'super_auto_ler_tabela_campo.php?tabela=\'+element.getAttribute(\'data-fk-tabela\')+\'&campo_id=\'+element.getAttribute(\'data-fk-id\')+\'&id=\'+element.getAttribute(\'data-fkid\');
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     element.value=resposta;
                     element.setAttribute(\'data-default\',resposta);
                     }
           oReq.send();
       }
} // carrega_drop_btn

function ativa_eventos_dropbtn(){ // ativa os eventos de teclado e demais dos dropbtn

var drops=document.getElementsByClassName(\'dropbtn\');
var i;
for (i=0; i<drops.length; i++) {
console.log(drops[i].id);
var drop_singular=drops[i];

// blur é quando perde o foco: input value tem que retornar ao valor default
// importante verificar se o elemento já tem o evento registrado, antes de registrar um novo. De outra forma, posso ter um x=x+2 para o valor de selecionado porque registro dois eventos que fazem x=x=+1...
if (drop_singular.getAttribute(\'data-event-blur\')===\'NAO\') {drop_singular.addEventListener(\'blur\', function(e){e.target.setAttribute(\'data-event-blur\',\'BLUR\');  e.target.value=e.target.getAttribute(\'data-default\');}, false);}
if (drop_singular.getAttribute(\'data-event-focus\')===\'NAO\'){drop_singular.addEventListener(\'focus\',function(e){e.target.setAttribute(\'data-event-focus\',\'FOCUS\');   cai(e.target.id,e.target.getAttribute(\'data-drop\')); e.target.value=\'\'; e.target.value=\'\';}, false);}
if (drop_singular.getAttribute(\'data-event-keyup\')===\'NAO\') {drop_singular.addEventListener(\'keyup\', 
		function(e){ 
			        e.target.setAttribute(\'data-event-keyup\',\'KEYUP\');
				var selecionado=e.target.getAttribute(\'data-selecionado\');
                                var n_itens=e.target.getAttribute(\'data-n-itens\');
	
				if ((e.keyCode==40) && ((selecionado<parseInt(n_itens)-1) || (selecionado<0)) ) {
							e.target.setAttribute(\'data-selecionado\',parseInt(selecionado)+1);
						   }
 
				if ((e.keyCode==38) && (selecionado>-1)) {
							e.target.setAttribute(\'data-selecionado\',parseInt(selecionado)-1);
						   }
 
				if ((e.keyCode<28) 
					&& (e.keyCode!=9) // evita que saia do dropbox quando o tab é usado 
					&& (e.keyCode!=14) // evita que saia do dropbox quando ocorre shift in 
					&& (e.keyCode!=15) // no manual dizia que shift out é 15, mas parece que 16 na verdade
					&& (e.keyCode!=16)) { // evita que saia do dropbox com SHIFT out
                                                        console.log(e.keyCode);
							if (e.keyCode==13){
                                                                console.log(\'selecionado: \'+e.target.getAttribute(\'data-selecionado\'));
                                                                console.log(\'id input: \'+e.target.getAttribute(\'data-fkid\'));
                                                                var drop_elem=e.target.getAttribute(\'data-drop\');
								console.log(\'drop element: \'+drop_elem);
								e.target.setAttribute(\'data-fkid\',document.getElementById(\'a_\'+drop_elem+\'_\'+e.target.getAttribute(\'data-selecionado\')).getAttribute(\'data-id-fk\'));
                                                            if (e.target.getAttribute(\'data-momento\')==\'atualizacao\'){
								atualiza_fk(e.target.id);
								carrega_drop_btn(e.target);}
								else {e.target.value=document.getElementById(\'a_\'+drop_elem+\'_\'+e.target.getAttribute(\'data-selecionado\')).getAttribute(\'data-innertext\');
e.target.setAttribute(\'data-default\',e.target.value);
console.log(\'target: \'+e.target.value);
}
								
							} else {e.target.value=e.target.getAttribute(\'data-default\');}
							e.target.setAttribute(\'data-keyup\',\'inativo\');
                                                        if (e.keyCode==8){
										e.target.value=\'\';
										cai(e.target.id,e.target.getAttribute(\'data-drop\'));
									} else {
                                                        			document.activeElement.blur();
                                                                               }

							
						   }
 
				else {cai(e.target.id,e.target.getAttribute(\'data-drop\'));}
console.log(selecionado);
		}, false);}
}
}
// fim da funcao que atribui eventos aos dropbtn

ativa_eventos_dropbtn();

function cai(id_input,id_div){
console.log(\'porra: \'+id_input+\' porra2: \'+id_div);
var elemento_input=document.getElementById(id_input);
var elemento_div=document.getElementById(id_div);

var str_busca=elemento_input.value;

if ((str_busca!=\'\') || (parseInt(elemento_input.getAttribute(\'data-selecionado\'))>-1)) {

		elemento_div.setAttribute(\'data-keyup\',\'keyup\');
		var fk_banco=elemento_input.getAttribute(\'data-fk-banco\');
		var fk_tabela=elemento_input.getAttribute(\'data-fk-tabela\');
		var fk_campo=elemento_input.getAttribute(\'data-fk-id\');
		var max_itens=elemento_input.getAttribute(\'data-max-itens\');
		busca_lista(id_input, id_div,fk_banco, fk_tabela, fk_campo, str_busca, max_itens);
               
		} 
		else {elemento_div.setAttribute(\'data-keyup\',\'inativo\');}
}

function busca_lista(elemento_input, elemento, banco, tabela, campo, str_busca, max_itens){
// busca a lista de valores de campos fk, de acordo com o nome_, usando o que foi teclado como search. Coloca no dropdown
           var resposta=\'\';
           var url=\'super_busca_str.php?banco=\'+banco+\'&tabela=\'+tabela+\'&campo=\'+campo+\'&str_busca=\'+str_busca;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
								var input=document.getElementById(elemento_input);
                                                                var myNode=document.getElementById(elemento); //é o div?
			
								while (myNode.firstChild) {
								myNode.removeChild(myNode.firstChild);
								}		

                     resposta=oReq.responseText;
                     var matriz=resposta.split(\'<br>\', max_itens);
		     // pode acontecer, como é o caso das tabelas autorizacoes, curadores_conteudos e expectadores, de uma tabela fazer referencia a uma outra sem nome_%
                     if (matriz[0].includes(\'veio nome\')) // a resposta do php completa eh (nao veio nome). Usei uma fracao por causa do acento 
					{
						// se percebe que nao veio nome, ou seja, nao tem nome_, entao ele busca um subselect
						 busca_lista_sub_select(elemento_input, elemento, banco, tabela, campo, str_busca, max_itens);
                                                 return;
					}
 
                     var conta=0;

                     matriz.forEach(function (item, index) {
 							   console.log(\'>\'+item+\'<\');
							   if (item.trim()!=\'\'){
								var node = document.createElement(\'a\');            // Create a <li> node
                     						var item_matriz=item.split(\'<rb>\', max_itens);
								var att_innertext = document.createAttribute(\'data-innertext\');
							        att_innertext.value = item_matriz[0];
								node.setAttributeNode(att_innertext);	
								var att_id = document.createAttribute(\'data-id-fk\');
							        att_id.value =	item_matriz[1];
								node.setAttributeNode(att_id);	
                                                                node.id=\'a_\'+elemento+\'_\'+conta;
								var textnode = document.createTextNode(\'#\'+item_matriz[0]+\'#\');     // Create a text node
                                                                textnode.id=\'text_\'+elemento+\'_\'+conta;
								node.appendChild(textnode);                        // Append the text to <a>
								myNode.appendChild(node);     // Append <a> to <div> with id=\'lista\'
								node.addEventListener(\'mousedown\',function (){console.log(\'clicou\');},false);
								if (index==input.getAttribute(\'data-selecionado\'))
									{
										node.style.backgroundColor=\'#000000\';
										node.style.color=\'#FFFFFF\';
									}
								conta=conta+1;
                                                                           }

                                                           ;}
							   );
							   input.setAttribute(\'data-n-itens\',conta);
                     }
           oReq.send();

}

function busca_lista_sub_select(elemento_input, elemento, banco, tabela, campo, str_busca, max_itens){
// funcao para o caso da tabela foreign nao ter nome_... dai tem que buscar na tabela fk da fk.
           console.log(str_busca);
           var resposta=\'\';
           var url=\'super_busca_registro_inteiro.php?banco=\'+banco+\'&tabela=\'+tabela+\'&nome_chave_primaria=\'+campo+\'&busca_str=\'+str_busca;
           // este codigo PHP busca apenas os campos que nao estao na tabela campos_excluidos... isso reduz o tamanho do string que aparece no dropdown
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
								var input=document.getElementById(elemento_input);
                                                                var myNode=document.getElementById(elemento); //é o div?
			
								while (myNode.firstChild) {
								myNode.removeChild(myNode.firstChild);
								}		

                     resposta=oReq.responseText;
                     var matriz=resposta.split(\'<br>\', max_itens);
		     // pode acontecer, como é o caso das tabelas autorizacoes, curadores_conteudos e expectadores, de uma tabela fazer referencia a uma outra sem nome_%
                     var conta=0;

                     matriz.forEach(function (item, index) {
							   if (item.trim()!=\'\'){

 							   console.log(\'>\'+item+\'<\');
								var node = document.createElement(\'a\');            // Create a <li> node
                     						var item_matriz=item.split(\'<rb>\', max_itens);
							console.log(item_matriz[0]);
								var att_innertext = document.createAttribute(\'data-innertext\');
							        att_innertext.value = item_matriz[0];
								node.setAttributeNode(att_innertext);	
								var att_id = document.createAttribute(\'data-id-fk\');
							        att_id.value =	item_matriz[1];
								node.setAttributeNode(att_id);	
                                                                node.id=\'a_\'+elemento+\'_\'+conta;
								var textnode = document.createTextNode(\'#\'+item_matriz[0]+\'#\');     // Create a text node
                                                                textnode.id=\'text_\'+elemento+\'_\'+conta;
								node.appendChild(textnode);                        // Append the text to <a>
								myNode.appendChild(node);     // Append <a> to <div> with id=\'lista\'
								node.addEventListener(\'mousedown\',function (){console.log(\'clicou\');},false);
								if (index==input.getAttribute(\'data-selecionado\'))
									{
										node.style.backgroundColor=\'#000000\';
										node.style.color=\'#FFFFFF\';
									}
								conta=conta+1;
                                                                           }

                                                           ;}
							   );
							   input.setAttribute(\'data-n-itens\',conta);
                     }
           oReq.send();
}

// FIM DOS SCRIPTS DO DROP MENU

function ativa_eventos_editaveis(){

var inputs_editaveis=document.getElementsByClassName(\'editavel\');
var i;
var input_singular;
for (i=0; i<inputs_editaveis.length; i++) {
input_singular=inputs_editaveis[i];
input_singular.addEventListener(\'keydown\', function(e){e.target.style.backgroundColor=\'#FF0000\';e.target.setAttribute(\'data-alterado\',\'alterado\') }, false);
}
}

ativa_eventos_editaveis();

function desliga_autocomplete(){
// tira o auto complete dos campos dropbtn
var inputElements = document.getElementsByTagName(\'input\');
for (i=0; inputElements[i]; i++) {
if (inputElements[i].className && (inputElements[i].className.indexOf(\'dropbtn\') != -1)) {
inputElements[i].setAttribute(\'autocomplete\',\'caramba\');
}
}
}

desliga_autocomplete();

var x = document.getElementsByClassName(\'dropbtn\');
var i;
for (i = 0; i < x.length; i++) {
// o programa super_auto_ler_tabela_campo.php é usado para buscar os dados na tabela chave (foreign key)
// se o dropbtn for de inserao de dados, ao inves de atualização, nao faz sentido buscar dados na base, porque o campo tem que estar vazio
  if(x[i].getAttribute(\'data-momento\')==\'atualizacao\'){
           var resposta=\'\';
           var url=\'super_auto_ler_tabela_campo.php?tabela=\'+x[i].getAttribute(\'data-fk-tabela\')+\'&campo_id=\'+x[i].getAttribute(\'data-fk-id\')+\'&id=\'+x[i].getAttribute(\'data-fkid\');
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
	             x[i].value=resposta;
                     x[i].setAttribute(\'data-default\',resposta);
                     }
           oReq.send();
       }
}
function carrega_busca(campo_busca,valor_busca,limit,offset){
 escrolx = window.pageXOffset || document.body.scrollLeft;
 escroly = window.pageYOffset || document.body.scrollTop;
 
mensagem_de_carregamento_ativada();

  alert(\'Busca pelo campo \'+campo_busca);
	var resposta=\'\';
	var url=\'super_insere_'.$tabela.'.php?offset=\'+offset+\'&limit=\'+limit+\'&campo_busca=\'+campo_busca+\'&valor_busca=\'+valor_busca+\'&scrollx=\'+escrolx+\'&scrolly=\'+escroly;
        var oReq=new XMLHttpRequest();
	oReq.open(\'GET\',url, false);
	oReq.onload= function (e) {
			    resposta=oReq.responseText;
			    window.document.body.innerText=\'\';
			    window.document.write(resposta);
			}
	oReq.send();
}
function carrega_offset(limit,offset){
escrolx = window.pageXOffset || document.body.scrollLeft;
escroly = window.pageYOffset || document.body.scrollTop;

mensagem_de_carregamento_ativada();

setTimeout(
function (){

	var resposta=\'\';
	var url=\'super_insere_'.$tabela.'.php?offset=\'+offset+\'&limit=\'+limit+\'&campo_busca=".$campo_busca."&valor_busca=".$valor_busca."&scrollx=\'+escrolx+\'&scrolly=\'+escroly;
        var oReq=new XMLHttpRequest();
	oReq.open(\'GET\',url, false);
	oReq.onload= function (e) {
			    resposta=oReq.responseText;
			    window.document.body.innerText=\'\';
			    window.document.write(resposta);
			}
	oReq.send();
}, 300);

}

function mensagem_de_carregamento_ativada(){
	document.getElementById(\'mensagem_de_carregamento\').innerText=  \'Aguarde Carregar \';
    document.getElementById(\'mensagem_de_carregamento\').style.visibility=\'visible\';
	document.getElementById(\'mensagem_de_carregamento\').style.left=Math.trunc(document.body.clientWidth/2 + escrolx);
	document.getElementById(\'mensagem_de_carregamento\').style.top=Math.trunc(document.body.clientHeight/2 + escroly);
}

function carrega(){
escrolx = window.pageXOffset || document.body.scrollLeft;
escroly = window.pageYOffset || document.body.scrollTop;

mensagem_de_carregamento_ativada();

setTimeout(
function (){
	var resposta=\'\';
	var url=\'super_insere_'.$tabela.'.php?offset=0&limit=".$limitador_registros_insere."&campo_busca=".$campo_busca."&valor_busca=".$valor_busca."&scrollx=\'+escrolx+\'&scrolly=\'+escroly;
        var oReq=new XMLHttpRequest();
	oReq.open(\'GET\',url, false);
	oReq.onload= function (e) {
			    resposta=oReq.responseText;
			    window.document.body.innerText=\'\';
			    window.document.write(resposta);
			}
	oReq.send();
},300);
}


function apaga_registro_com_tabela(tabela, id){ // igual a apaga_registro, mas tem tabela como parametro de entrada

if (!confirm(\'O registro \'+id+\' da tabela \'+tabela+\'será apagado.\')) {return;}
var resposta=\'\';
var url=\'super_apaga_registro.php?tabela=\'+tabela+\'&id=\'+id;
alert(url);
var oReq=new XMLHttpRequest();
oReq.open(\'GET\', url, false);
oReq.onload= function (e) {
	resposta=oReq.responseText;
        alert(resposta);
	carrega();

}
oReq.send();

}



function apaga_registro(id){
var resposta=\'\';
var url=\'super_apaga_registro.php?tabela='.$tabela.'&id=\'+id;
alert(url);
var oReq=new XMLHttpRequest();
oReq.open(\'GET\', url, false);
oReq.onload= function (e) {
	resposta=oReq.responseText;
        alert(resposta);
	carrega();

}
oReq.send();

}

//cuidado para nao confundir esse insere_registro com o super_insere_registro.php... sao diferentes - o javascript chama o php
function insere_registro(tabela, nivel_de_insercao, div_insercao, campo_extra, valor_extra){ // nivel de insercao indica para quais campos o botao insere vai agir

// campo_extra e valor extra permitem forçar a inserção de um campo e valor que não estão representados por um input no DOM. Isso é útil quando estou usando a inserção NtoN dentro de uma tabela, em que eu já sei qual o registro que eu selecionei

var conta_campos=0;
var inputs_inseriveis=document.getElementById(div_insercao).getElementsByClassName(\'inserivel\'); // pega apenas os inseriveis que estao dentro de div insercao
var i;
var input_inserivel;

if (campo_extra ===\'\') {var acumula_campos=\'\';} else {var acumula_campos=campo_extra+\', \';}
if (valor_extra ===\'\') {var acumula_valores=\'\';} else {var acumula_valores=valor_extra+\', \';}

alert(nivel_de_insercao+acumula_campos);

var virgula=\'\';
for (i=0; i<inputs_inseriveis.length; i++) {
input_inserivel=inputs_inseriveis[i];

if (input_inserivel.getAttribute(".\'"\'."data-nivel".\'"\'.")!=nivel_de_insercao) {continue;}

if (conta_campos>0) {virgula=\',\';} else {virgula=\'\';}
acumula_campos=acumula_campos+virgula+input_inserivel.getAttribute(".\'"\'."data-campo".\'"\'.");
acumula_valores=acumula_valores+virgula+\'".\'"\'."\'+input_inserivel.value+\'".\'"\'."\';
conta_campos=conta_campos+1;
}
// na hora de inserir os registros vc precisa acumular quais
var inputs_inseriveis=document.getElementById(div_insercao).getElementsByClassName(\'dropbtn\');
var i;
var input_inserivel;
var virgula=\'\';
for (i=0; i<inputs_inseriveis.length; i++) {
input_inserivel=inputs_inseriveis[i];
if (input_inserivel.getAttribute(".\'"\'."data-nivel".\'"\'.")!=nivel_de_insercao) {continue;}

	if (input_inserivel.getAttribute(\'data-momento\')==\'insercao\'){
		if (conta_campos>0) {virgula=\',\';} else {virgula=\'\';}
		acumula_campos=acumula_campos+virgula+input_inserivel.getAttribute(".\'"\'."data-campo".\'"\'.");
		acumula_valores=acumula_valores+virgula+\'".\'"\'."\'+input_inserivel.getAttribute(\'data-fkid\')+\'".\'"\'."\';
                conta_campos=conta_campos+1;
	}
}


var resposta=\'\';
var url=\'super_insere_registro.php?tabela=\'+tabela+\'&campos=\'+acumula_campos+\'&valores=\'+acumula_valores;
alert(url);
var oReq=new XMLHttpRequest();
oReq.open(\'GET\', url, false);
oReq.onload= function (e) {
	resposta=oReq.responseText;
        alert(resposta);
        var inputs_inseriveis2=document.getElementById(div_insercao).getElementsByClassName(\'inserivel\');
        var input_inserivel2;
	var i;
	for (i=0; i< inputs_inseriveis2.length; i++) 
                {
			input_inserivel2=inputs_inseriveis2[i];
			input_inserivel2.value=\'\';
                        input_inserivel2.style.backgroundColor=\'#FFFFFF\';
                }

        var inputs_inseriveis2=document.getElementById(div_insercao).getElementsByClassName(\'dropbtn\');
        var input_inserivel2;
	var i;
	for (i=0; i< inputs_inseriveis2.length; i++) 
                {
			input_inserivel2=inputs_inseriveis2[i];
			if (input_inserivel2.getAttribute(\'data-momento\')==\'insercao\') {
				input_inserivel2.value=\'\';
			}
                }
	carrega();
}
oReq.send();
}

function mostra_botao(div_insercao, tabela, nivel){
	nivel_insercao=nivel;
	  var botao=\'<input  type='.'\"'.'button'.'\" data-nivel='.'\"'.'\'+nivel+\''.'\" value='.'\"'.'Inserir em \'+tabela+\''.'\" onclick='.'\"'.'painel_insercao('."`".'\'+div_insercao+\''."`".','."`".'\'+tabela+\''."`".')'.'\" />\';
	  document.getElementById(div_insercao).innerHTML=botao;

        disable_niveis();

}


function painel_insercao(div_insercao, tabela){
	   nivel_insercao++;
           var resposta=\'\';
           var url=\'super_insercao.php?tabela=\'+tabela+\'&nivel=\'+nivel_insercao;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     var nivel_itz=nivel_insercao-1;
	             document.getElementById(div_insercao).innerHTML=resposta+\'<br><input type='.'\"'.'button'.'\"'.' value='.'\"'.'fecha inserção \'+tabela+nivel_insercao+\''.'\"'.'  data-nivel='.'\"'.'\'+nivel_insercao+\''.'\"   onclick='.'\"'.'mostra_botao('."\'"."'+div_insercao+'"."\'".','."\'"."'+tabela+'"."\'".','."\'"."'+ nivel_itz +'"."\'".')\"'.' />\';
		     ativa_eventos_dropbtn();
		     ativa_alterados();
		     desliga_autocomplete();
	   	     disable_niveis();
                     }
           oReq.send();
}



// atualiza() recebe uma matriz com todos os campos que precisam ser atualizados (menos foreign keys).

function atualiza_fk (id_elemento_campo){

		var campo=document.getElementById(id_elemento_campo);
	                var resposta=\'\';
	                var url=\'super_atualiza_campos.php?tabela=\'+campo.getAttribute(\'data-tabela\')+\'&campo=\'+campo.getAttribute(\'data-campo\')+\'&id=\'+campo.getAttribute(\'data-id\')+\'&valor=\'+campo.getAttribute(\'data-fkid\');;
	                var oReq=new XMLHttpRequest();
			oReq.open(\'GET\', url, false);
			oReq.onload = function (e) {
				resposta=oReq.responseText;
				alert(resposta);
			}
                oReq.send();
}



function atualiza (matriz){
   matriz.forEach(minhafuncao);

	function minhafuncao(item, index){
		var campo=document.getElementById(item);
                if (campo.getAttribute(\'data-alterado\')==\'alterado\'){
	                var resposta=\'\';
	                var url=\'super_atualiza_campos.php?tabela=\'+campo.getAttribute(\'data-tabela\')+\'&campo=\'+campo.getAttribute(\'data-campo\')+\'&id=\'+campo.getAttribute(\'data-id\')+\'&valor=\'+campo.value;
	                var oReq=new XMLHttpRequest();
			oReq.open(\'GET\', url, false);
			oReq.onload = function (e) {
				resposta=oReq.responseText;
				alert(resposta);
				campo.style.backgroundColor=\'#FFFFFF\';
                                campo.setAttribute(\'data-alterado\',\'nao\');
			}
                oReq.send();
	        } 
	}

}

var mywindow=window;
mywindow.resizeTo(document.getElementById(\'conteudo\').scrollWidth+50,document.getElementById(\'conteudo\').scrollHeight+50);
</script>

</body>
</html>";

?>
');
} //fim function Cria_insere
//
/* ######################## >>>>   FUNÇÃO 15: Cria_Insercao_N_to_N   <<<<< ########################                       */
// objetivo: cria o painel de insercao (interface) para quando este está integrado na tabela externa referenciada pela tabela. Note que ainda não existe a criação automática do ponto em que esse código será chamado pela tabela remota. Isso ainda tem que ser feito manualmente numa cópia da tabela remota no diretório su_autophp. Essa cópia é necessária para evitar uma situação de perda de código quando o super interfaces é executado novamente
function Cria_Insercao_N_to_N(){global $banco_de_dados;
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_def=fopen('../su_autophp/super_NtoN_insercao.php','w');
	Envia_mensagem($mensagens['Mens34']);
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

$banco_de_dados=$banco;

if(isset($_GET["nivel"])){  // passa o nivel hierarquico daquela insercao.
  $nivel = $_GET["nivel"];
}

if(isset($_GET["tabela_externa_em_edicao"])){ // é a tabela que está sendo editada e que tem um registro com id conhecido.
  $tabela_externa_em_edicao = $_GET["tabela_externa_em_edicao"];
}

if(isset($_GET["campo_externo_para_search"])){  // campo externo da tabela com cardinalidade N to N, que aponta para <tabela> tratada pelo código super_insere_<tabela>.php, onde <tabela> é aquela que tem um registro com id conhecido
  $campo_externo_para_search = $_GET["campo_externo_para_search"]; //
}

if(isset($_GET["id_externo_para_search"])){  // o identificador id_chave do registro da <tabela> de super_insere_<tabela>.php, ou seja. A <tabela> é a que é referenciada pela chave externa de $tabela, que a tabela com cardinalidade N to N, é o valor do id do registro conhecido da <tabela> que está sendo editada por insere_<tabela>.php
  $id_externo_para_search = $_GET["id_externo_para_search"];
}
$tabela=$tabela_externa_em_edicao;

$cor_letra="black";
if ($nivel=="1") {$cor_letra="white";  $cor_background="darkgray";}
if ($nivel=="2") { $cor_background="blue"; $cor_letra="white";}
if ($nivel=="3") { $cor_background="green";}
if ($nivel=="4") { $cor_background="blue"; $cor_letra="yellow";}
if ($nivel=="5") { $cor_background="orange";}

echo "<div id=\'todos_os_n_to_n\' style=\'border: hidden;\'>
<table style=\'border: hidden\'>
<tr>
";
$database=$banco_de_dados;
$conn= new mysqli("localhost", $username, $pass, $database);

$sql_tabelas_de_ligacao="select 
												nome_tabela_de_ligacao           ,
												campo_externo1_tabela_de_ligacao ,
												campo_externo2_tabela_de_ligacao ,
												tabela_externa1                  ,
												campo_name_tabela_externa1       ,
												campo_id_tabela_externa1         ,
												tabela_externa2                  ,
												campo_name_tabela_externa2		 , 
												campo_id_tabela_externa2         
						from su_tabelas_ligacao;";

$result_tl=$conn->query("$sql_tabelas_de_ligacao");
if ($result_tl->num_rows>0) {
  while($row_tl=$result_tl->fetch_assoc())
    {
		$nome_tabela_de_ligacao           =   $row_tl["nome_tabela_de_ligacao"          ]; 
		$campo_externo1_tabela_de_ligacao =   $row_tl["campo_externo1_tabela_de_ligacao"]; 
		$campo_externo2_tabela_de_ligacao =   $row_tl["campo_externo2_tabela_de_ligacao"]; 
		$tabela_externa1                  =   $row_tl["tabela_externa1"                 ]; 
		$campo_name_tabela_externa1       =   $row_tl["campo_name_tabela_externa1"      ]; 
		$campo_id_tabela_externa1         =   $row_tl["campo_id_tabela_externa1"        ]; 
		$tabela_externa2                  =   $row_tl["tabela_externa2"                 ]; 
		$campo_name_tabela_externa2		  =   $row_tl["campo_name_tabela_externa2" 	  ]; 
		$campo_id_tabela_externa2         =   $row_tl["campo_id_tabela_externa2"       ]; 

if ($tabela_externa1==$tabela_externa_em_edicao || $tabela_externa2==$tabela_externa_em_edicao )
{
	if ($tabela_externa1==$tabela_externa_em_edicao)
	 {
	 	$campo_externo_para_search=$campo_externo1_tabela_de_ligacao;
    	$tabela_independente=$tabela_externa2;
    	$campo_independente=$campo_externo2_tabela_de_ligacao;
    	$chave_externa_independente=$campo_id_tabela_externa2;
    	$nome_externa_independente=$campo_name_tabela_externa2;
    
	 }
	if ($tabela_externa2==$tabela_externa_em_edicao)
	 {
	 	$campo_externo_para_search=$campo_externo2_tabela_de_ligacao;
    	$tabela_independente=$tabela_externa1;
    	$campo_independente=$campo_externo1_tabela_de_ligacao;
    	$chave_externa_independente=$campo_id_tabela_externa1;
    	$nome_externa_independente=$campo_name_tabela_externa1;

	 }
	 
} else {continue;} // se a tabela externa nao for a que está em edição, aquele tabela_de_ligacao não interessa

echo "
<td style=\'vertical-align: top;\'>
<div class=\'classe_filho_ponto_insercao_nton\' id=\'insercao_nton_".$nome_tabela_de_ligacao."_".$id_externo_para_search."\' style=\' border: 3px solid red; padding: 3px;\'>
<table class=\'tabela_interna_da_insercao\' style=\'vertical-align: top ;border-collapse: collapse; border: none; padding:5px; text-align: left; width: 100%; \'>
";

// o if abaixo provavelmente não é necessário, porque se o registro se refere à $tabela_externa_em edicao, então, provavelmente não 
//haverá uma tabela externa apontando para ela mesma (exceto no caso de uma estrutura de árvore, por isso vou manter - mas ao manter vou tirar a possibilidade do pai da folha ser escolhido)
if ($nome_tabela_de_ligacao===$tabela_externa_em_edicao ) { // pula o while no caso da própria tabela que está em edição
        continue;  // interrompe o while até a próxima iteração
    }

echo "<tr><td style=\'vertical-align: top; border: none; \'><span style=\'vertical-align: top; font-size: 20px\'>\'".$nome_tabela_de_ligacao."\'</span></td></tr>";

$sql="
select col.TABLE_NAME as \'table\',
       col.ordinal_position as col_id, col.data_type as dt, col.character_maximum_length as ml,
       col.COLUMN_NAME as COLUMN_NAME,
       case when kcu.REFERENCED_TABLE_SCHEMA is null
            then null
            else \'>-\' end as rel,
       kcu.REFERENCED_TABLE_NAME
              as primary_table,
       kcu.REFERENCED_COLUMN_NAME as pk_COLUMN_NAME,
       kcu.constraint_name as fk_constraint_name
       from information_schema.columns col
       join information_schema.tables tab
            on col.TABLE_SCHEMA = tab.TABLE_SCHEMA
	         and col.TABLE_NAME = tab.TABLE_NAME
		 left join information_schema.key_column_usage kcu
		      on col.TABLE_SCHEMA = kcu.TABLE_SCHEMA
		           and col.TABLE_NAME = kcu.TABLE_NAME
			        and col.COLUMN_NAME = kcu.COLUMN_NAME
				     and kcu.REFERENCED_TABLE_SCHEMA is not null
				     where col.TABLE_SCHEMA not in(\'information_schema\',\'sys\',
					                                   \'mysql\', \'performance_schema\')
									         and tab.table_type = \'BASE TABLE\'
										 and col.TABLE_SCHEMA = \'".$banco_de_dados."\'
										 and tab.TABLE_NAME= \'".$nome_tabela_de_ligacao."\'
										 order by col.TABLE_SCHEMA,
										          col.TABLE_NAME,
											           col.ordinal_position;

;";

$max_tamanho_text=90; // maximo tamanho do input text, quando nao for int
$result=$conn->query("$sql");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
	$table=$row["table"];
	$coluna=$row["COLUMN_NAME"];
	$type=$row["dt"];
	$length=$row["ml"];
	//$rtn="rtn";
	$rtn=$row["primary_table"];
	//$rcn="rcn";
	$rcn=$row["pk_COLUMN_NAME"];
        if ($length>$max_tamanho_text){$visible_length=$max_tamanho_text;} else {$visible_length=$length;}
        if ($type==\'int\') {$visible_length=4;}


if (		(strpos($coluna,\'id_chave\')===false) &&
		(strpos($coluna,\'time_stamp\')===false) &&
		(strpos($coluna,\'usuario\')===false) 
)
{
	if ($type==\'date\') {$default_input=\'0000-01-01\';} else {$default_input=\'\';}

//	if (strpos($coluna,$campo_externo_para_search)===false){
//
//	echo "<tr>";
//	}

        if (
		($rtn==\'\') 
           )
         {

		if (strpos($coluna,\'photo_filename_\')===false){
			if (strpos($coluna,$campo_externo_para_search)===false){
			echo "          <tr>        <td>".$coluna."<br><input 
								type=\'text\' 
								value=\'".$default_input."\'
								placeholder=\'Entre dado\'
								class=\'inserivel\' 
								data-tabela=\'".$table."\' 
								data-alterado=\'nao\' 
								data-campo=\'".$coluna."\'
								data-nivel=\'".$nivel."\' 
								size=\'".$visible_length."\' 
								maxlength=\'".$length."\' />
						</td>
				              </tr>";
			} else {echo "O id de inserção na tabela \'".$campo_externo_para_search."\' será \'".$id_externo_para_search."\'.";}
		}
		else {
			echo "
			<td>	<img id=".\'"photo_filename_img"\'." style=".\'"background-color: white; width: 80; height: auto"\'."
				     src=".\'"../su_imagens/lupa.png"\'.">
				<input type=".\'"button"\'." value=".\'"Imagem do Servidor"\'." data-nivel=".\'"\'.$nivel.\'"\'." 
					onclick=".\'"
						var identificador=`id_diretorio_photos`;
						var dummy=``;
						var mostra=`MostraArquivosDiretorio`;
						var w_h=`width=1000 height=1000`;
						var w=window.open(dummy,mostra,w_h);
						var resposta=``;
						var url=`super_mostra_diretorio_imagens.php?banco=\'.$banco_de_dados.\'&diretorio=su_imagens&id_input=id_campo_nome_photo_filename&id_input_path=`+identificador+`&id_input_img=photo_filename_img&jpg=1&png=1&gif=1&pdf=0`;
						console.log(url);
						var oReq = new XMLHttpRequest();
						var gueti=`GET`;
						oReq.open(gueti, url, false);
						oReq.onload= function (e) {
							resposta=oReq.responseText;
							w.document.write(resposta);
						}
						oReq.send();
					"\'."
						 
					
				/>
				<input type=\'button\' value=\'Amplia\' data-nivel=\'".$nivel."\' 
					onclick=\'
						var file_=document.getElementById(`id_campo_nome_photo_filename`).value;
						if (file_ != ``) { 
						var wu=window.open(``, `Janela_Ampliacao`, `width=`+screen.availWidth+` height=`+screen.availHeight);
						if (file_.indexOf(`pdf`)>-1){
									wu.document.write(`<embed src=\"../su_imagens/`+file_+`\" width=\"800px\" height=\"2100px\"/>` );
								} 
								else
								{
									wu.document.write(`<embed src=\"../su_imagens/`+file_+`\" width=\"800px\" height=\"auto\"/>` );
								}	
						} else {alert(`Você não selecionou uma imagem!`);}
				\'>
				<input type=\'button\' value=\'Sobe Imagem\' data-nivel=\'".$nivel."\' onclick=\'document.getElementById(`id_sobe_imagem`).click();\'>
				<input style=\'display: none\' data-nivel=\'".$nivel."\' id=\'id_sobe_imagem\'
					type=\'file\'
					onchange=\'
						var resposta=``;
						var nome_arquivo=this.value.replace(/^.*[\\\\\\/]/, resposta);
						var ide_campo_nome_foto=`id_campo_nome_photo_filename`;
						document.getElementById(ide_campo_nome_foto).setAttribute(`data-alterado`,`alterado`);
						document.getElementById(ide_campo_nome_foto).value=nome_arquivo;
						if (this.files && this.files[0]) {
							var ide=`photo_filename_img`;
							var extensao=(files[0].name.split(`.`).pop().toLowerCase());
							if (extensao.indexOf(`pdf`)<0) {document.getElementById(ide).src=window.URL.createObjectURL(this.files[0]);}
							var fd= new FormData();
							var faili=`fileToUpload`;
							fd.append(faili,this.files[0],nome_arquivo);
							var xhr = new XMLHttpRequest();
							var pousti=`POST`;
							var nome_faili=`super_grava_imagem.php`;
							xhr.open(pousti, nome_faili);
							xhr.onloadend= function(e) 
									{
									 resposta=xhr.responseText; 
									 var thumb=`super_pdf_thumb.php?pdf=`+document.getElementById(`id_diretorio_photos`).innerText+files[0].name;
									 if (extensao.indexOf(`pdf`)>-1) {document.getElementById(ide).src=thumb;}
									 alert(resposta+` thumb:`+thumb+` ide:`+ide);
									}
							xhr.send(fd);
							document.getElementById(ide_campo_nome_foto).value=document.getElementById(`id_diretorio_photos`).innerText+nome_arquivo;
						}
						
					\'/>		


				<input 
                                        id=\'id_campo_nome_photo_filename\' 
                                        class=\'inserivel\'
                                        type=\'text\' 
                                        value=\'\'
                                        data-alterado=\'nao\'
                                        data-tabela=\'".$table."\'
                                        data-campo=\'".$coluna."\'
                                        data-id=\'\'
                                        data-nivel=\'".$nivel."\'
                                />
				
				<div style=\'border: 1px solid blue; background-color: black; color: white\'>Diretório no Servidor: <span id=\'id_diretorio_photos\'>../su_imagens/</span></div>
			</td>
			";
		}
			
	} 
	else 
		{
// o input-div abaixo mimetiza um dropdown. Ele é equivalente ao dropdown de outra parte do programa, usado para atualizar dados, na tabela completa. Esse aqui é mais simples porque o dado ainda não existe, então não temos um id para a chave primária, por exemplo.

if (strpos($coluna,$campo_externo_para_search)===false){

		echo "
<tr>
<td>
<input type=\'button\' data-table=\'".$table."\' value=\'Insere ".\'"\'.$nome_tabela_de_ligacao.\'"\'."\' data-nivel=\'".$nivel."\' onclick=\'insere_registro(".\'"\'.$table.\'"\'.",".$nivel.",".\'"insercao_nton_\'.$nome_tabela_de_ligacao.\'_\'.$id_externo_para_search.\'"\'.",".\'"\'.$campo_externo_para_search.\'"\'.",".\'"\'.$id_externo_para_search.\'"\'.")\'/>
<div id=\'form_".$nome_tabela_de_ligacao."_".$id_externo_para_search."\' style=\'backgroundcolor: blue\'><input type=\'button\' value=\'adiciona ".$rtn."\' data-nivel=\'".$nivel."\' onclick=\'painel_insercao('.'\"'.'form_".$nome_tabela_de_ligacao."_".$id_externo_para_search."'.'\"'.','.'\"'.'".$rtn."'.'\"'.')\'/></div>
</td>
</tr>
<tr>
<td>
<div class=\'dropdown\'>
  <input type=\'text\' 
	id=\'drop_".$coluna."_".$campo_externo_para_search."_".$id_externo_para_search."\' 
	class=\'dropbtn\' 
	onfocusout=\'document.getElementById(".\'"\'."lista_".$coluna."_".$campo_externo_para_search."_".$id_externo_para_search.\'"\'.").setAttribute(".\'"\'."data-keyup".\'"\'.",".\'"\'."inativo".\'"\'.");document.getElementById(".\'"\'."drop_".$coluna."_".$campo_externo_para_search."_".$id_externo_para_search.\'"\'.").setAttribute(".\'"\'."data-selecionado".\'"\'.",".\'"\'."-1".\'"\'."); document.getElementById(".\'"\'."drop_".$coluna."_".$campo_externo_para_search."_".$id_externo_para_search.\'"\'.").setAttribute(".\'"\'."data-n-itens".\'"\'.",".\'"\'."0".\'"\'.");\' 
        data-drop=\'lista_".$coluna."_".$campo_externo_para_search."_".$id_externo_para_search."\'
        data-momento=\'insercao\'
	data-id=\'-1\'
        data-max-itens=\'100\'
	data-banco=\'".$banco_de_dados."\' 
	data-tabela=\'".$tabela."\'
	data-campo=\'".$coluna."\' 
	data-fkid=\'-1\' 
        data-default=\'\'
	data-fk-banco=\'".$banco_de_dados."\' 
	data-fk-tabela=\'".$rtn."\' 
	data-fk-id=\'".$rcn."\'
	data-selecionado=\'-1\'
        data-event-blur=\'NAO\'
	data-event-focus=\'NAO\'
	data-event-keyup=\'NAO\'
	data-n-itens=\'0/\'
	data-nivel=\'".$nivel."\' 
        autocomplete=\'caramba\'
  />
  <div id=\'lista_".$coluna."_".$campo_externo_para_search."_".$id_externo_para_search."\'  class=\'dropdown-content\'  data-keyup=\'inativo\'>
  </div>
</div>
</td>
</tr>
";

//$nome_a_partir_do_rcn=str_replace("id_chave_","nome_",$rcn); // essa solucao assume que a tabela externa tem um campo nome_. Isso pode não ser verdade. O certo seria buscar o campo nome e se não tivesse, chamar um erro
//
//    	$tabela_independente=$tabela_externa2;
//    	$campo_independente=$campo_externo2_tabela_de_ligacao;
//    	$chave_externa_independente=campo_id_tabela_externa2;
//    	$nome_externa_independente=campo_nome_tabela_externa2;

		} // fim do if que testa se o campo é $campo_externo_de_search
		// else {echo "<td>É campo da tabela externa".$campo_externo_de_search."</td>";} Esse else é para testar se o strpos está funcionando
		};
} // fim do if que testa se são campos especiais
 echo"<tr>
         <td colspan=3 style=\'text-align: left\'></td>
     </tr>

";
  
    } // fim do while 
} // fim do if que testa se o query resultou em linhas

$sql_schema="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = \'".$table."\' AND CONSTRAINT_NAME = \'PRIMARY\' limit 1;";// vamos pegar o nome da chave primária

$result_schema=$conn->query("$sql_schema");
if ($result_schema->num_rows>0) {
  while($row_schema=$result_schema->fetch_assoc())
    {
	$chave_primaria=$row_schema["COLUMN_NAME"];
	}
} else {echo "<tr><td>Não tem dados</td></tr>";} 

// código abaixo gera a lista de campos na tabela remota que estão associados a um campo na <tabela> que está sendo editada.
$sql_externo="select a.".$nome_externa_independente.", b.".$chave_primaria." from ".$tabela_independente." as a, ".$table." as b  where a.".$chave_externa_independente."=b.".$campo_independente." and b.".$campo_externo_para_search."=\'".$id_externo_para_search."\';";

echo "<tr><td><div class=\'classe_contem_nomes\'  id=\'contem_nomes_".$nome_tabela_de_ligacao."_".$id_externo_para_search."\'>
".$nome_externa_independente." 
<table class=\'tabela_contem_nomes\'>
<tr>
";

$result_externo=$conn->query("$sql_externo");
$quantidade_de_resultados=$result_externo->num_rows;

if ($quantidade_de_resultados>30){  // aqui deveria entrar o $quantidade_maxima_de_linhas_no_NtoN
	echo "<tr><td>Mais de 30 itens.<br> Use tabela própria.</td></tr>";
}
else 
{
	if ($quantidade_de_resultados>0) {
	  while($row_externo=$result_externo->fetch_assoc())
	    {
		$nome_rcn=$row_externo[$nome_externa_independente];
		$id_chave=$row_externo[$chave_primaria];
		echo "<tr><td class=\'tabela_contem_nomes\'>".$nome_rcn."</td><td class=\'tabela_contem_nomes\'><input type=\'button\' value=\'apaga\' onclick=\'apaga_registro_com_tabela(`".$nome_tabela_de_ligacao."`,".$id_chave.");\'></td></tr>";
		} 
	} else {echo "<tr><td>Não tem dados. ".$sql_externo." </td></tr>";}
}
echo "
</tr>
</table>
</div></td></tr>";

echo "
</table>
</div>
</td>
";

} // fim do while que percorre a tabela su_tabelas_ligacao
} // fim do if que verifica se o result foi > 0
echo "</tr><table><div>";

?>
';

fwrite($fs_def,iconv('UTF-8','UTF-8',$php)."\n");
fclose($fs_def);
}  // fim Cria_Insercao_N_to_N()
//
/* ######################## >>>>   FUNÇÃO 16: Cria_seleciona_fk   <<<<< ########################                       */
// objetivo: cria um painel que permite selecionar o valor de um campo FK, a partir do nome que consta na tabela remota.
// Retorna o id do nome escolhido
function Cria_seleciona_fk(){
	//global $banco_de_dados;
		global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_def=fopen('../su_autophp/super_seleciona_fk.php','w');
	Envia_mensagem($mensagens['Mens35']);
	$php='<?php
//require_once "../su_install/'.$arqconfig.'";
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
// 2021-04-21 -> esse código teve origem no super_insercao.php. Diferentemente daquele, o objetivo nao é inserir um novo dado, mas permitir a selecao de um id presente num campo externo. Para isso é preciso retirar todo o procedimento de super_insere_registro.php, porque não será feita insercao ou atualização, mas apenas o retorno do id do campo selecionado.

if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["nivel"])){  // passa o nivel hierarquico daquela insercao.
  $nivel = $_GET["nivel"];
}

if(isset($_GET["campo_de_escolha"])){  // passa o campo que será usado para fazer a selecao. Só este campo da tabela será mostrado, ignorando os demais. 
  $campo_de_escolha = $_GET["campo_de_escolha"];
}

$cor_letra="black";
if ($nivel=="1") { $cor_background="lightgreen";}
if ($nivel=="2") { $cor_background="blue"; $cor_letra="white";}
if ($nivel=="3") { $cor_background="green";}
if ($nivel=="4") { $cor_background="blue"; $cor_letra="yellow";}
if ($nivel=="5") { $cor_background="orange";}

$database=$banco_de_dados;
$conn= new mysqli("localhost", $username, $pass, $database);

$sql="
select col.TABLE_NAME as \'table\',
       col.ordinal_position as col_id, col.data_type as dt, col.character_maximum_length as ml,
       col.COLUMN_NAME as COLUMN_NAME,
       case when kcu.REFERENCED_TABLE_SCHEMA is null
            then null
            else \'>-\' end as rel,
       kcu.REFERENCED_TABLE_NAME
              as primary_table,
       kcu.REFERENCED_COLUMN_NAME as pk_COLUMN_NAME,
       kcu.constraint_name as fk_constraint_name
       from information_schema.columns col
       join information_schema.tables tab
            on col.TABLE_SCHEMA = tab.TABLE_SCHEMA
	         and col.TABLE_NAME = tab.TABLE_NAME
		 left join information_schema.key_column_usage kcu
		      on col.TABLE_SCHEMA = kcu.TABLE_SCHEMA
		           and col.TABLE_NAME = kcu.TABLE_NAME
			        and col.COLUMN_NAME = kcu.COLUMN_NAME
				     and kcu.REFERENCED_TABLE_SCHEMA is not null
				     where col.TABLE_SCHEMA not in(\'information_schema\',\'sys\',
					                                   \'mysql\', \'performance_schema\')
									         and tab.table_type = \'BASE TABLE\'
										 and col.TABLE_SCHEMA = \'".$banco_de_dados."\'
										 and tab.TABLE_NAME= \'".$tabela."\'
										 order by col.TABLE_SCHEMA,
										          col.TABLE_NAME,
											           col.ordinal_position;

;";
echo "
<div id=\'div_de_insercao_no_topo\' style=\'background-color: ".$cor_background."; color: ".$cor_letra."\'>
<h2>Selecione o curador: (\'".$tabela."\')</h2>
<table style=\'border: 1px solid ".$cor_letra."; border-collapse: collapse; padding:5px; text-align: left; width: 100%; color: ".$cor_letra."\'>
";

$max_tamanho_text=90; // maximo tamanho do input text, quando nao for int
$result=$conn->query("$sql");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
	$table=$row["table"];
	$coluna=$row["COLUMN_NAME"];
	$type=$row["dt"];
	$length=$row["ml"];
	//$rtn="rtn";
	$rtn=$row["primary_table"];
	//$rcn="rcn";
	$rcn=$row["pk_COLUMN_NAME"];
        if ($length>$max_tamanho_text){$visible_length=$max_tamanho_text;} else {$visible_length=$length;}
        if ($type==\'int\') {$visible_length=4;}


if (//		(strpos($coluna,\'id_chave\')===false) &&
	//	(strpos($coluna,\'time_stamp\')===false) &&
	//	(strpos($coluna,\'usuario\')===false) 
		(strpos($coluna,$campo_de_escolha)===0) 
)
{
	if ($type==\'date\') {$default_input=\'0000-01-01\';} else {$default_input=\'\';}

        if (
		($rtn==\'\') 
           )
         {

		if (strpos($coluna,\'photo_filename_\')===false){

		echo "                  <td><input 
							type=\'text\' 
							value=\'".$default_input."\'
							class=\'inserivel\' 
							data-tabela=\'".$table."\' 
							data-alterado=\'nao\' 
							data-campo=\'".$coluna."\'
							data-nivel=\'".$nivel."\' 
							size=\'".$visible_length."\' 
							maxlength=\'".$length."\' />
					</td>
			              </tr>";
		}
		else {
			echo "
			<td>	<img id=".\'"photo_filename_img"\'." style=".\'"background-color: white; width: 80; height: auto"\'."
				     src=".\'"../su_imagens/lupa.png"\'.">
				<input type=".\'"button"\'." value=".\'"Imagem do Servidor"\'." data-nivel=".\'"\'.$nivel.\'"\'." 
					onclick=".\'"
						var identificador=`id_diretorio_photos`;
						var dummy=``;
						var mostra=`MostraArquivosDiretorio`;
						var w_h=`width=1000 height=1000`;
						var w=window.open(dummy,mostra,w_h);
						var resposta=``;
						var url=`super_mostra_diretorio_imagens.php?banco=\'.$banco_de_dados.\'&diretorio=su_imagens&id_input=id_campo_nome_photo_filename&id_input_path=`+identificador+`&id_input_img=photo_filename_img&jpg=1&png=1&gif=1&pdf=0`;
						console.log(url);
						var oReq = new XMLHttpRequest();
						var gueti=`GET`;
						oReq.open(gueti, url, false);
						oReq.onload= function (e) {
							resposta=oReq.responseText;
							w.document.write(resposta);
						}
						oReq.send();
					"\'."
					
				/>
				<input type=\'button\' value=\'Amplia\' data-nivel=\'".$nivel."\' 
					onclick=\'
						var file_=document.getElementById(`id_campo_nome_photo_filename`).value;
						if (file_ != ``) { 
						var wu=window.open(``, `Janela_Ampliacao`, `width=`+screen.availWidth+` height=`+screen.availHeight);
						if (file_.indexOf(`pdf`)>-1){
									wu.document.write(`<embed src=\"../su_imagens/`+file_+`\" width=\"800px\" height=\"2100px\"/>` );
								} 
								else
								{
									wu.document.write(`<embed src=\"../su_imagens/`+file_+`\" width=\"800px\" height=\"auto\"/>` );
								}	
						} else {alert(`Você não selecionou uma imagem!`);}
				\'>
				<input type=\'button\' value=\'Sobe Imagem\' data-nivel=\'".$nivel."\' onclick=\'document.getElementById(`id_sobe_imagem`).click();\'>
				<input style=\'display: none\' data-nivel=\'".$nivel."\' id=\'id_sobe_imagem\'
					type=\'file\'
					onchange=\'
						var resposta=``;
						var nome_arquivo=this.value.replace(/^.*[\\\\\\/]/, resposta);
						var ide_campo_nome_foto=`id_campo_nome_photo_filename`;
						document.getElementById(ide_campo_nome_foto).setAttribute(`data-alterado`,`alterado`);
						document.getElementById(ide_campo_nome_foto).value=nome_arquivo;
						if (this.files && this.files[0]) {
							var ide=`photo_filename_img`;
							var extensao=(files[0].name.split(`.`).pop().toLowerCase());
							if (extensao.indexOf(`pdf`)<0) {document.getElementById(ide).src=window.URL.createObjectURL(this.files[0]);}
							var fd= new FormData();
							var faili=`fileToUpload`;
							fd.append(faili,this.files[0],nome_arquivo);
							var xhr = new XMLHttpRequest();
							var pousti=`POST`;
							var nome_faili=`super_grava_imagem.php`;
							xhr.open(pousti, nome_faili);
							xhr.onloadend= function(e) 
									{
									 resposta=xhr.responseText; 
									 var thumb=`pdf_thumb.php?pdf=`+document.getElementById(`id_diretorio_photos`).innerText+files[0].name;
									 if (extensao.indexOf(`pdf`)>-1) {document.getElementById(ide).src=thumb;}
									 alert(resposta+` thumb:`+thumb+` ide:`+ide);
									}
							xhr.send(fd);
							document.getElementById(ide_campo_nome_foto).value=document.getElementById(`id_diretorio_photos`).innerText+nome_arquivo;
						}
						
					\'/>		


				<input 
                                        id=\'id_campo_nome_photo_filename\' 
                                        class=\'inserivel\'
                                        type=\'text\' 
                                        value=\'\'
                                        data-alterado=\'nao\'
                                        data-tabela=\'".$table."\'
                                        data-campo=\'".$coluna."\'
                                        data-id=\'\'
                                        data-nivel=\'".$nivel."\'
                                />
				
				<div style=\'border: 1px solid blue; background-color: black; color: white\'>Diretório no Servidor: <span id=\'id_diretorio_photos\'>../su_imagens/</span></div>
			</td>
			";
		}
			
	} 
	else 
		{
// o input-div abaixo mimetiza um dropdown. Ele é equivalente ao dropdown de outra parte do programa, usado para atualizar dados, na tabela completa. Esse aqui é mais simples porque o dado ainda não existe, então não temos um id para a chave primária, por exemplo.
		echo "

<td width=\'70%\'>
<div class=\'dropdown\'>
  <input type=\'text\' 
	id=\'drop_".$coluna."_\' 
	class=\'dropbtn\' 
	onfocusout=\'document.getElementById(".\'"\'."lista_".$coluna."_".\'"\'.").setAttribute(".\'"\'."data-keyup".\'"\'.",".\'"\'."inativo".\'"\'.");document.getElementById(".\'"\'."drop_".$coluna."_".\'"\'.").setAttribute(".\'"\'."data-selecionado".\'"\'.",".\'"\'."-1".\'"\'."); document.getElementById(".\'"\'."drop_".$coluna."_".\'"\'.").setAttribute(".\'"\'."data-n-itens".\'"\'.",".\'"\'."0".\'"\'.");\' 
        data-drop=\'lista_".$coluna."_\'
        data-momento=\'insercao\'
	data-id=\'-1\'
        data-max-itens=\'100\'
	data-banco=\'".$banco_de_dados."\' 
	size=\'70\'
	placeholder=\'click e aperte seta para baixo OU digite o nome que quer buscar\'
	data-tabela=\'".$tabela."\'
	data-campo=\'".$coluna."\' 
	data-fkid=\'-1\' 
        data-default=\'\'
	data-fk-banco=\'".$banco_de_dados."\' 
	data-fk-tabela=\'".$rtn."\' 
	data-fk-id=\'".$rcn."\'
	data-selecionado=\'-1\'
        data-event-blur=\'NAO\'
	data-event-focus=\'NAO\'
	data-event-keyup=\'NAO\'
	data-n-itens=\'0/\'
	data-nivel=\'".$nivel."\' 
        autocomplete=\'caramba\'
  />

  <div id=\'lista_".$coluna."_\' class=\'dropdown-content\'  data-keyup=\'inativo\'>
  </div>
</div>
</td>";

		};
} // fim do if que testa se são campos especiais
   
    } // fim do while 
} // fim do if que testa se o query resultou em linhas
echo"
         <td colspan=3 style=\'text-align: left\'><input type=\'button\' data-table=\'".$table."\' value=\'Entra na Plataforma\' data-nivel=\'".$nivel."\'       onclick=\'carrega_janela_principal(document.getElementById(`drop_`+`".$campo_de_escolha."`+`_`).value)\'></td>
     </tr>
</table></div>

" 
?>
';

fwrite($fs_def,iconv('UTF-8','UTF-8',$php)."\n");
fclose($fs_def);
}
//
/* ######################## >>>>   FUNÇÃO 17: Cria_Insercao   <<<<< ########################                       */
// objetivo:
function Cria_Insercao(){ // Cria o painel de insercao (interface), mas o php de insercao efetivamente eh outro
	global $arqconfig;
	global $mensagens;
	//global $banco_de_dados;
	setlocale(LC_ALL, 'pt_BR');
	$fs_def=fopen('../su_autophp/super_insercao.php','w');
	Envia_mensagem($mensagens['Mens36']);
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

if(isset($_GET["nivel"])){  // passa o nivel hierarquico daquela insercao.
  $nivel = $_GET["nivel"];
}

$cor_letra="black";
if ($nivel=="1") { $cor_background="lightgreen";}
if ($nivel=="2") { $cor_background="blue"; $cor_letra="white";}
if ($nivel=="3") { $cor_background="green";}
if ($nivel=="4") { $cor_background="blue"; $cor_letra="yellow";}
if ($nivel=="5") { $cor_background="orange";}

$conn= new mysqli("localhost", $username, $pass, $banco);

$sql="
select col.TABLE_NAME as \'table\',
       col.ordinal_position as col_id, col.data_type as dt, col.character_maximum_length as ml,
       col.COLUMN_NAME as COLUMN_NAME,
       case when kcu.REFERENCED_TABLE_SCHEMA is null
            then null
            else \'>-\' end as rel,
       kcu.REFERENCED_TABLE_NAME
              as primary_table,
       kcu.REFERENCED_COLUMN_NAME as pk_COLUMN_NAME,
       kcu.constraint_name as fk_constraint_name
       from information_schema.columns col
       join information_schema.tables tab
            on col.TABLE_SCHEMA = tab.TABLE_SCHEMA
	         and col.TABLE_NAME = tab.TABLE_NAME
		 left join information_schema.key_column_usage kcu
		      on col.TABLE_SCHEMA = kcu.TABLE_SCHEMA
		           and col.TABLE_NAME = kcu.TABLE_NAME
			        and col.COLUMN_NAME = kcu.COLUMN_NAME
				     and kcu.REFERENCED_TABLE_SCHEMA is not null
				     where col.TABLE_SCHEMA not in(\'information_schema\',\'sys\',
					                                   \'mysql\', \'performance_schema\')
									         and tab.table_type = \'BASE TABLE\'
										 and col.TABLE_SCHEMA = \'".$banco."\'
										 and tab.TABLE_NAME= \'".$tabela."\'
										 order by col.TABLE_SCHEMA,
										          col.TABLE_NAME,
											           col.ordinal_position;

;";
echo "
<div id=\'div_de_insercao_no_topo\' style=\'background-color: ".$cor_background."; color: ".$cor_letra."\'>
<h2>Inserção de Dados: \'".$tabela."\'</h2>
<table style=\'border: 1px solid ".$cor_letra."; border-collapse: collapse; padding:5px; text-align: left; width: 100%; color: ".$cor_letra."\'>
<tr>
<th>Campo</th>
<th>Tipo</th>
<th>Valor</th>

</tr>";

$max_tamanho_text=90; // maximo tamanho do input text, quando nao for int
$result=$conn->query("$sql");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
	$table=$row["table"];
	$coluna=$row["COLUMN_NAME"];
	$type=$row["dt"];
	$length=$row["ml"];
	//$rtn="rtn";
	$rtn=$row["primary_table"];
	//$rcn="rcn";
	$rcn=$row["pk_COLUMN_NAME"];
        if ($length>$max_tamanho_text){$visible_length=$max_tamanho_text;} else {$visible_length=$length;}
        if ($type==\'int\') {$visible_length=4;}


if (		(strpos($coluna,\'id_chave\')===false) &&
		(strpos($coluna,\'time_stamp\')===false) &&
		(strpos($coluna,\'usuario\')===false) 
)
{
	if ($type==\'date\') {$default_input=\'0000-01-01\';} else {$default_input=\'\';}
	echo "<tr><td> ".$coluna."</td>
                  <td>
                      <table class=\'interna\'>
                          <tr>
				<td class=\'interna\'>".$type."</td>
			  </tr>
                          <tr>
                                <td class=\'interna\'>".$length."</td>
                          </tr>
                          <tr>
				<td class=\'interna\'>".$rtn."</td>
                          </tr>
                          <tr>
				<td class=\'interna\'>".$rcn."</td>
                          </tr>
                      </table>
                  </td>";


        if (
		($rtn==\'\') 
           )
         {

		if (strpos($coluna,\'photo_filename_\')===false){

		echo "                  <td><input 
							type=\'text\' 
							value=\'".$default_input."\'
							class=\'inserivel\' 
							data-tabela=\'".$table."\' 
							data-alterado=\'nao\' 
							data-campo=\'".$coluna."\'
							data-nivel=\'".$nivel."\' 
							size=\'".$visible_length."\' 
							maxlength=\'".$length."\' />
					</td>
			              </tr>";
		}
		else {
			echo "
			<td>	<img id=".\'"photo_filename_img"\'." style=".\'"background-color: white; width: 80; height: auto"\'."
				     src=".\'"../su_imagens/lupa.png"\'.">
				<input type=".\'"button"\'." value=".\'"Imagem do Servidor"\'." data-nivel=".\'"\'.$nivel.\'"\'." 
					onclick=".\'"
						var identificador=`id_diretorio_photos`;
						var dummy=``;
						var mostra=`MostraArquivosDiretorio`;
						var w_h=`width=1000 height=1000`;
						var w=window.open(dummy,mostra,w_h);
						var resposta=``;
						var url=`super_mostra_diretorio_imagens.php?banco=\'.$banco.\'&diretorio=su_imagens&id_input=id_campo_nome_photo_filename&id_input_path=`+identificador+`&id_input_img=photo_filename_img&jpg=1&png=1&gif=1&pdf=0`;
						console.log(url);
						var oReq = new XMLHttpRequest();
						var gueti=`GET`;
						oReq.open(gueti, url, false);
						oReq.onload= function (e) {
							resposta=oReq.responseText;
							w.document.write(resposta);
						}
						oReq.send();
					"\'."
						 
					
				/>
				<input type=\'button\' value=\'Amplia\' data-nivel=\'".$nivel."\' 
					onclick=\'
						var file_=document.getElementById(`id_campo_nome_photo_filename`).value;
						if (file_ != ``) { 
						var wu=window.open(``, `Janela_Ampliacao`, `width=`+screen.availWidth+` height=`+screen.availHeight);
						if (file_.indexOf(`pdf`)>-1){
									wu.document.write(`<embed src=\"../su_imagens/`+file_+`\" width=\"800px\" height=\"2100px\"/>` );
								} 
								else
								{
									wu.document.write(`<embed src=\"../su_imagens/`+file_+`\" width=\"800px\" height=\"auto\"/>` );
								}	
						} else {alert(`Você não selecionou uma imagem!`);}
				\'>
				<input type=\'button\' value=\'Sobe Imagem\' data-nivel=\'".$nivel."\' onclick=\'document.getElementById(`id_sobe_imagem`).click();\'>
				<input style=\'display: none\' data-nivel=\'".$nivel."\' id=\'id_sobe_imagem\'
					type=\'file\'
					onchange=\'
						var resposta=``;
						var nome_arquivo=this.value.replace(/^.*[\\\\\\/]/, resposta);
						var ide_campo_nome_foto=`id_campo_nome_photo_filename`;
						document.getElementById(ide_campo_nome_foto).setAttribute(`data-alterado`,`alterado`);
						document.getElementById(ide_campo_nome_foto).value=nome_arquivo;
						if (this.files && this.files[0]) {
							var ide=`photo_filename_img`;
							var extensao=(files[0].name.split(`.`).pop().toLowerCase());
							if (extensao.indexOf(`pdf`)<0) {document.getElementById(ide).src=window.URL.createObjectURL(this.files[0]);}
							var fd= new FormData();
							var faili=`fileToUpload`;
							fd.append(faili,this.files[0],nome_arquivo);
							var xhr = new XMLHttpRequest();
							var pousti=`POST`;
							var nome_faili=`super_grava_imagem.php`;
							xhr.open(pousti, nome_faili);
							xhr.onloadend= function(e) 
									{
									 resposta=xhr.responseText; 
									 var thumb=`pdf_thumb.php?pdf=`+document.getElementById(`id_diretorio_photos`).innerText+files[0].name;
									 if (extensao.indexOf(`pdf`)>-1) {document.getElementById(ide).src=thumb;}
									 alert(resposta+` thumb:`+thumb+` ide:`+ide);
									}
							xhr.send(fd);
							document.getElementById(ide_campo_nome_foto).value=document.getElementById(`id_diretorio_photos`).innerText+nome_arquivo;
						}
						
					\'/>		


				<input 
                                        id=\'id_campo_nome_photo_filename\' 
                                        class=\'inserivel\'
                                        type=\'text\' 
                                        value=\'\'
                                        data-alterado=\'nao\'
                                        data-tabela=\'".$table."\'
                                        data-campo=\'".$coluna."\'
                                        data-id=\'\'
                                        data-nivel=\'".$nivel."\'
                                />
				
				<div style=\'border: 1px solid blue; background-color: black; color: white\'>Diretório no Servidor: <span id=\'id_diretorio_photos\'>../su_imagens/</span></div>
			</td>
			";
		}
			
			
			
			
	} 
	else 
		{
// o input-div abaixo mimetiza um dropdown. Ele é equivalente ao dropdown de outra parte do programa, usado para atualizar dados, na tabela completa. Esse aqui é mais simples porque o dado ainda não existe, então não temos um id para a chave primária, por exemplo.
		echo "

<td>
<div class=\'dropdown\'>
  <input type=\'text\' 
	id=\'drop_".$coluna."_\' 
	class=\'dropbtn\' 
	onfocusout=\'document.getElementById(".\'"\'."lista_".$coluna."_".\'"\'.").setAttribute(".\'"\'."data-keyup".\'"\'.",".\'"\'."inativo".\'"\'.");document.getElementById(".\'"\'."drop_".$coluna."_".\'"\'.").setAttribute(".\'"\'."data-selecionado".\'"\'.",".\'"\'."-1".\'"\'."); document.getElementById(".\'"\'."drop_".$coluna."_".\'"\'.").setAttribute(".\'"\'."data-n-itens".\'"\'.",".\'"\'."0".\'"\'.");\' 
        data-drop=\'lista_".$coluna."_\'
        data-momento=\'insercao\'
	data-id=\'-1\'
        data-max-itens=\'100\'
	data-banco=\'".$banco."\' 
	data-tabela=\'".$tabela."\'
	data-campo=\'".$coluna."\' 
	data-fkid=\'-1\' 
        data-default=\'\'
	data-fk-banco=\'".$banco."\' 
	data-fk-tabela=\'".$rtn."\' 
	data-fk-id=\'".$rcn."\'
	data-selecionado=\'-1\'
        data-event-blur=\'NAO\'
	data-event-focus=\'NAO\'
	data-event-keyup=\'NAO\'
	data-n-itens=\'0/\'
	data-nivel=\'".$nivel."\' 
        autocomplete=\'caramba\'
  />

  <div id=\'lista_".$coluna."_\' class=\'dropdown-content\'  data-keyup=\'inativo\'>
  </div>
</div>
<div id=\'form_".$rtn."\' style=\'backgroundcolor: blue\'><input type=\'button\' value=\'adiciona ".$rtn."\' data-nivel=\'".$nivel."\' onclick=\'painel_insercao('.'\"'.'form_".$rtn."'.'\"'.','.'\"'.'".$rtn."'.'\"'.')\'>
</div>
</td>";

		};
} // fim do if que testa se são campos especiais
   
    } // fim do while 
} // fim do if que testa se o query resultou em linhas
echo"<tr>
         <td colspan=3 style=\'text-align: left\'><input type=\'button\' data-table=\'".$table."\' value=\'Insere ".\'"\'.$table.$nivel.\'"\'."\' data-nivel=\'".$nivel."\' onclick=\'insere_registro(".\'"\'.$table.\'"\'.",".$nivel.",".\'"div_de_insercao_no_topo"\'.",".\'"\'.\'"\'.",".\'"\'.\'"\'.")\'></td>
     </tr>
</table></div>

" 
?>
';

fwrite($fs_def,iconv('UTF-8','UTF-8',$php)."\n");
fclose($fs_def);
} // fim function Cria_insercao()
//
/* ######################## >>>>   FUNÇÃO 18: Cria_VerDef   <<<<< ########################                       */
// objetivo:
function Cria_VerDef(){
	global $arqconfig;
	global $mensagens;
	setlocale(LC_ALL, 'pt_BR');
	$fs_def=fopen('../su_autophp/super_verdef.php','w');
	Envia_mensagem($mensagens['Mens36']);
	$php='<?php
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

if(isset($_GET["tabela"])){
  $tabela = $_GET["tabela"];
}

$conn= new mysqli("localhost", $username, $pass, $banco);

$sql="
select col.TABLE_NAME as \'table\',
       col.ordinal_position as col_id, col.data_type as dt, col.character_maximum_length as ml,
       col.COLUMN_NAME as COLUMN_NAME,
       case when kcu.REFERENCED_TABLE_SCHEMA is null
            then null
            else \'>-\' end as rel,
       kcu.REFERENCED_TABLE_NAME
              as primary_table,
       kcu.REFERENCED_COLUMN_NAME as pk_COLUMN_NAME,
       kcu.constraint_name as fk_constraint_name
       from information_schema.columns col
       join information_schema.tables tab
            on col.TABLE_SCHEMA = tab.TABLE_SCHEMA
	         and col.TABLE_NAME = tab.TABLE_NAME
		 left join information_schema.key_column_usage kcu
		      on col.TABLE_SCHEMA = kcu.TABLE_SCHEMA
		           and col.TABLE_NAME = kcu.TABLE_NAME
			        and col.COLUMN_NAME = kcu.COLUMN_NAME
				     and kcu.REFERENCED_TABLE_SCHEMA is not null
				     where col.TABLE_SCHEMA not in(\'information_schema\',\'sys\',
					                                   \'mysql\', \'performance_schema\')
									         and tab.table_type = \'BASE TABLE\'
										 and col.TABLE_SCHEMA = \'".$banco."\'
										 and tab.TABLE_NAME= \'".$tabela."\'
										 order by col.TABLE_SCHEMA,
										          col.TABLE_NAME,
											           col.ordinal_position;

;";
echo "
<html>
<head>
<title>Inspeção de Estrutura de Tabela</title>
<link rel=\'stylesheet\' href=\'../su_css/super_verdef.css\' type=\'text/css\'>
</head>
<body id=\'conteudo\'>
<div  style=\'background-color: yellow\'>
<h1>Descrição da Tabela: \'".$tabela."\'</h1>
<table>
<tr>
<th>Campo</th>
<th>Tipo</th>
<th>Tamanho</th>
<th>FK_table</th>
<th>FK_column</th>

</tr>";
$result=$conn->query("$sql");
if ($result->num_rows>0) {
  while($row=$result->fetch_assoc())
    {
	$table=$row["table"];
	$coluna=$row["COLUMN_NAME"];
	$type=$row["dt"];
	$length=$row["ml"];
	//$rtn="rtn";
	$rtn=$row["primary_table"];
	//$rcn="rcn";
	$rcn=$row["pk_COLUMN_NAME"];
	echo "<tr><td> ".$coluna."</td><td>".$type."</td><td>".$length."</td><td>".$rtn."</td><td>".$rcn."</td></tr>";

    }
}
#echo"</div></table><input type=\'button\' value=\'Fecha\' data-nivel=\'".$nivel."\'  onclick=\'window.close()\'>
echo"</div></table><input type=\'button\' value=\'Fecha\'  onclick=\'window.close()\'>
<script>
var mywindow=window;
mywindow.resizeTo(document.getElementById(\'conteudo\').scrollWidth+50,document.getElementById(\'conteudo\').scrollHeight+50);
</script>
</body>
</html>" 
?>
';

fwrite($fs_def,iconv('UTF-8','UTF-8',$php)."\n");
fclose($fs_def);
}
//
/* #################### >>>>   FUNÇÃO 19: Cria_Entrada_Para_Aldir_Blanc   <<<<< ####################                       */
// objetivo:
function Cria_Entrada_Para_Aldir_Blanc($fs){
	global $arqconfig;
	global $mensagens;
	require("$arqconfig");
	Envia_mensagem($mensagens['Mens38']);
	$html='
<html>
	<head>
		<title>Porta de entrada para o Backoffice da Lei Aldir Blanc</title>
		<link rel=\'stylesheet\' href=\'../su_css/super_cria_entrada.css\' type=\'text/css\'>
	</head>
<body onload=\'
painel_escolha_fk(`ponto_de_insercao`,`su_documents`,`id_curador`);
\'>
<h1 id=\'cabeca\'>Entrada para o Backoffice da Lei Aldir Blanc - Potlatch</h1>
<div id=\'ponto_de_insercao\'></div>
<iframe id=\'janela_principal\' width=\'1px\' height=\'1px\' ></iframe>
<script>
var nivel_insercao=1;

function carrega_janela_principal(nome_usuario){

if (nome_usuario.length==0){
	if (confirm(\'Você não escolheu um curador. Você quer carregar a tabela inteira? (isso pode demorar)\')){} else {return;}
}

document.getElementById(\'janela_principal\').width=document.body.clientWidth;
document.getElementById(\'janela_principal\').height=document.body.clientHeight - document.getElementById(\'ponto_de_insercao\').clientHeight - document.getElementById(\'cabeca\').clientHeight;

document.getElementById(\'janela_principal\').src=\'super_backoffice_aldir_blanc_por_nome.php?usuario=\' + nome_usuario;


//           var resposta="";
//           var url=\'backoffice_aldir_blanc.php?usuario=\' + nome_usuario;
//           var oReq=new XMLHttpRequest();
//           oReq.open("GET", url, false);
//           oReq.onload = function (e) 
//		   			{
//                	    resposta=oReq.responseText;
//						document.getElementById(\'janela_principal\').innerHTML=resposta;
//                    }
//           oReq.send();
//


}


function disable_niveis(){
var x = document.getElementsByTagName(\'INPUT\');
var i;
for (i = 0; i < x.length; i++) {
  console.log(\'TAG INPUT -> \'+x[i].id+\' nivel -> \'+nivel_insercao);
  if (x[i].className==\'pagina\' || x[i].getAttribute(\'data-nivel\')==nivel_insercao) {x[i].disabled=false;} else {x[i].disabled=true;};
}
}

function desliga_autocomplete(){
// tira o auto complete dos campos dropbtn
var inputElements = document.getElementsByTagName(\'input\');
for (i=0; inputElements[i]; i++) {
if (inputElements[i].className && (inputElements[i].className.indexOf(\'dropbtn\') != -1)) {
inputElements[i].setAttribute(\'autocomplete\',\'caramba\');
}
}
}


function ativa_alterados(){
var inputs_inseriveis=document.getElementsByClassName(\'inserivel\');
var i;
var input_inserivel;
for (i=0; i<inputs_inseriveis.length; i++) {
input_inserivel=inputs_inseriveis[i];
input_inserivel.addEventListener(\'keydown\', function(e){e.target.style.backgroundColor=\'#FF0000\';e.target.setAttribute(\'data-alterado\',\'alterado\') }, false);
}
}

function painel_escolha_fk(div_insercao, tabela, campo_de_escolha){
	   nivel_insercao++;
           var resposta=\'\';
           var url=\'super_seleciona_fk.php?banco='.$banco_de_dados.'&tabela=\'+tabela+\'&nivel=\'+nivel_insercao+\'&campo_de_escolha=\'+campo_de_escolha;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     var nivel_itz=nivel_insercao-1;
					 document.getElementById(div_insercao).innerHTML=resposta;
	            // document.getElementById(div_insercao).innerHTML=resposta+\'<br><input type='.'\"'.'button'.'\"'.' value='.'\"'.'fecha inserção \'+tabela+nivel_insercao+\''.'\"'.'  data-nivel='.'\"'.'\'+nivel_insercao+\''.'\"   onclick='.'\"'.'mostra_botao('."\'"."'+div_insercao+'"."\'".','."\'"."'+tabela+'"."\'".','."\'"."'+ nivel_itz +'"."\'".')\"'.' />\';
		     ativa_eventos_dropbtn();
		     ativa_alterados();
		     desliga_autocomplete();
	   	     disable_niveis();
                     }
           oReq.send();
}

// INICIO DOS SCRIPTS DO DROP MENU

function carrega_drop_btn(element){

  if(element.getAttribute(\'data-momento\')==\'atualizacao\'){
           var resposta=\'\';
           var url=\'super_auto_ler_tabela_campo.php?tabela=\'+element.getAttribute(\'data-fk-tabela\')+\'&campo_id=\'+element.getAttribute(\'data-fk-id\')+\'&id=\'+element.getAttribute(\'data-fkid\');
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     element.value=resposta;
                     element.setAttribute(\'data-default\',resposta);
                     }
           oReq.send();
       }
} // carrega_drop_btn

function ativa_eventos_dropbtn(){ // ativa os eventos de teclado e demais dos dropbtn

var drops=document.getElementsByClassName(\'dropbtn\');
var i;
for (i=0; i<drops.length; i++) {
console.log(drops[i].id);
var drop_singular=drops[i];

// blur é quando perde o foco: input value tem que retornar ao valor default
// importante verificar se o elemento já tem o evento registrado, antes de registrar um novo. De outra forma, posso ter um x=x+2 para o valor de selecionado porque registro dois eventos que fazem x=x=+1...
if (drop_singular.getAttribute(\'data-event-blur\')===\'NAO\') {drop_singular.addEventListener(\'blur\', function(e){e.target.setAttribute(\'data-event-blur\',\'BLUR\');  e.target.value=e.target.getAttribute(\'data-default\');}, false);}
if (drop_singular.getAttribute(\'data-event-focus\')===\'NAO\'){drop_singular.addEventListener(\'focus\',function(e){e.target.setAttribute(\'data-event-focus\',\'FOCUS\');   cai(e.target.id,e.target.getAttribute(\'data-drop\')); e.target.value=\'\'; e.target.value=\'\';}, false);}
if (drop_singular.getAttribute(\'data-event-keyup\')===\'NAO\') {drop_singular.addEventListener(\'keyup\', 
		function(e){ 
			        e.target.setAttribute(\'data-event-keyup\',\'KEYUP\');
				var selecionado=e.target.getAttribute(\'data-selecionado\');
                                var n_itens=e.target.getAttribute(\'data-n-itens\');
	
				if ((e.keyCode==40) && ((selecionado<parseInt(n_itens)-1) || (selecionado<0)) ) {
							e.target.setAttribute(\'data-selecionado\',parseInt(selecionado)+1);
						   }
 
				if ((e.keyCode==38) && (selecionado>-1)) {
							e.target.setAttribute(\'data-selecionado\',parseInt(selecionado)-1);
						   }
 
				if ((e.keyCode<28) 
					&& (e.keyCode!=9) // evita que saia do dropbox quando o tab é usado 
					&& (e.keyCode!=14) // evita que saia do dropbox quando ocorre shift in 
					&& (e.keyCode!=15) // no manual dizia que shift out é 15, mas parece que 16 na verdade
					&& (e.keyCode!=16)) { // evita que saia do dropbox com SHIFT out
                                                        console.log(e.keyCode);
							if (e.keyCode==13){
                                                                console.log(\'selecionado: \'+e.target.getAttribute(\'data-selecionado\'));
                                                                console.log(\'id input: \'+e.target.getAttribute(\'data-fkid\'));
                                                                var drop_elem=e.target.getAttribute(\'data-drop\');
								console.log(\'drop element: \'+drop_elem);
								e.target.setAttribute(\'data-fkid\',document.getElementById(\'a_\'+drop_elem+\'_\'+e.target.getAttribute(\'data-selecionado\')).getAttribute(\'data-id-fk\'));
                                                            if (e.target.getAttribute(\'data-momento\')==\'atualizacao\'){
								atualiza_fk(e.target.id);
								carrega_drop_btn(e.target);}
								else {e.target.value=document.getElementById(\'a_\'+drop_elem+\'_\'+e.target.getAttribute(\'data-selecionado\')).getAttribute(\'data-innertext\');
e.target.setAttribute(\'data-default\',e.target.value);
console.log(\'target: \'+e.target.value);
}
								
							} else {e.target.value=e.target.getAttribute(\'data-default\');}
							e.target.setAttribute(\'data-keyup\',\'inativo\');
                                                        if (e.keyCode==8){
										e.target.value=\'\';
										cai(e.target.id,e.target.getAttribute(\'data-drop\'));
									} else {
                                                        			document.activeElement.blur();
                                                                               }
						
						   }
 
				else {cai(e.target.id,e.target.getAttribute(\'data-drop\'));}
console.log(selecionado);
		}, false);}
}
}
// fim da funcao que atribui eventos aos dropbtn

ativa_eventos_dropbtn();

function cai(id_input,id_div){
console.log(\'porra: \'+id_input+\' porra2: \'+id_div);
var elemento_input=document.getElementById(id_input);
var elemento_div=document.getElementById(id_div);

var str_busca=elemento_input.value;

if ((str_busca!=\'\') || (parseInt(elemento_input.getAttribute(\'data-selecionado\'))>-1)) {

		elemento_div.setAttribute(\'data-keyup\',\'keyup\');
		var fk_banco=elemento_input.getAttribute(\'data-fk-banco\');
		var fk_tabela=elemento_input.getAttribute(\'data-fk-tabela\');
		var fk_campo=elemento_input.getAttribute(\'data-fk-id\');
		var max_itens=elemento_input.getAttribute(\'data-max-itens\');
		busca_lista(id_input, id_div,fk_banco, fk_tabela, fk_campo, str_busca, max_itens);
               
		} 
		else {elemento_div.setAttribute(\'data-keyup\',\'inativo\');}
}

function busca_lista(elemento_input, elemento, banco, tabela, campo, str_busca, max_itens){
// busca a lista de valores de campos fk, de acordo com o nome_, usando o que foi teclado como search. Coloca no dropdown
           var resposta=\'\';
           var url=\'super_busca_str.php?tabela=\'+tabela+\'&campo=\'+campo+\'&str_busca=\'+str_busca;
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
								var input=document.getElementById(elemento_input);
                                                                var myNode=document.getElementById(elemento); //é o div?
			
								while (myNode.firstChild) {
								myNode.removeChild(myNode.firstChild);
								}		

                     resposta=oReq.responseText;
                     var matriz=resposta.split(\'<br>\', max_itens);
		     // pode acontecer, como é o caso das tabelas autorizacoes, curadores_conteudos e expectadores, de uma tabela fazer referencia a uma outra sem nome_%
                     if (matriz[0].includes(\'veio nome\')) // a resposta do php completa eh (nao veio nome). Usei uma fracao por causa do acento 
					{
						// se percebe que nao veio nome, ou seja, nao tem nome_, entao ele busca um subselect
						 busca_lista_sub_select(elemento_input, elemento, banco, tabela, campo, str_busca, max_itens);
                                                 return;
					}
 
                     var conta=0;

                     matriz.forEach(function (item, index) {
 							   console.log(\'>\'+item+\'<\');
							   if (item.trim()!=\'\'){
								var node = document.createElement(\'a\');            // Create a <li> node
                     						var item_matriz=item.split(\'<rb>\', max_itens);
								var att_innertext = document.createAttribute(\'data-innertext\');
							        att_innertext.value = item_matriz[0];
								node.setAttributeNode(att_innertext);	
								var att_id = document.createAttribute(\'data-id-fk\');
							        att_id.value =	item_matriz[1];
								node.setAttributeNode(att_id);	
                                                                node.id=\'a_\'+elemento+\'_\'+conta;
								var textnode = document.createTextNode(\'#\'+item_matriz[0]+\'#\');     // Create a text node
                                                                textnode.id=\'text_\'+elemento+\'_\'+conta;
								node.appendChild(textnode);                        // Append the text to <a>
								myNode.appendChild(node);     // Append <a> to <div> with id=\'lista\'
								node.addEventListener(\'mousedown\',function (){console.log(\'clicou\');},false);
								if (index==input.getAttribute(\'data-selecionado\'))
									{
										node.style.backgroundColor=\'#000000\';
										node.style.color=\'#FFFFFF\';
									}
								conta=conta+1;
                                                                           }

                                                           ;}
							   );
							   input.setAttribute(\'data-n-itens\',conta);
                     }
           oReq.send();

}

function busca_lista_sub_select(elemento_input, elemento, banco, tabela, campo, str_busca, max_itens){
// funcao para o caso da tabela foreign nao ter nome_... dai tem que buscar na tabela fk da fk.
           console.log(str_busca);
           var resposta=\'\';
           var url=\'super_busca_registro_inteiro.php?tabela=\'+tabela+\'&nome_chave_primaria=\'+campo+\'&busca_str=\'+str_busca;
           // este codigo PHP busca apenas os campos que nao estao na tabela campos_excluidos... isso reduz o tamanho do string que aparece no dropdown
           var oReq=new XMLHttpRequest();
           oReq.open(\'GET\', url, false);
           oReq.onload = function (e) {
								var input=document.getElementById(elemento_input);
                                                                var myNode=document.getElementById(elemento); //é o div?
			
								while (myNode.firstChild) {
								myNode.removeChild(myNode.firstChild);
								}		

                     resposta=oReq.responseText;
                     var matriz=resposta.split(\'<br>\', max_itens);
		     // pode acontecer, como é o caso das tabelas autorizacoes, curadores_conteudos e expectadores, de uma tabela fazer referencia a uma outra sem nome_%
                     var conta=0;

                     matriz.forEach(function (item, index) {
							   if (item.trim()!=\'\'){

 							   console.log(\'>\'+item+\'<\');
								var node = document.createElement(\'a\');            // Create a <li> node
                     						var item_matriz=item.split(\'<rb>\', max_itens);
							console.log(item_matriz[0]);
								var att_innertext = document.createAttribute(\'data-innertext\');
							        att_innertext.value = item_matriz[0];
								node.setAttributeNode(att_innertext);	
								var att_id = document.createAttribute(\'data-id-fk\');
							        att_id.value =	item_matriz[1];
								node.setAttributeNode(att_id);	
                                                                node.id=\'a_\'+elemento+\'_\'+conta;
								var textnode = document.createTextNode(\'#\'+item_matriz[0]+\'#\');     // Create a text node
                                                                textnode.id=\'text_\'+elemento+\'_\'+conta;
								node.appendChild(textnode);                        // Append the text to <a>
								myNode.appendChild(node);     // Append <a> to <div> with id=\'lista\'
								node.addEventListener(\'mousedown\',function (){console.log(\'clicou\');},false);
								if (index==input.getAttribute(\'data-selecionado\'))
									{
										node.style.backgroundColor=\'#000000\';
										node.style.color=\'#FFFFFF\';
									}
								conta=conta+1;
                                                                           }

                                                           ;}
							   );
							   input.setAttribute(\'data-n-itens\',conta);
                     }
           oReq.send();
}

// FIM DOS SCRIPTS DO DROP MENU

</script>
</body>
</html>

';

fwrite($fs,iconv('UTF-8','UTF-8',$html)."\n");
} // fim function Cria_Entrada_Para_Aldir_Blanc
//
/* #################### >>>>   FUNÇÃO 20: Cavecalio_simplificado_por_id   <<<<< ####################                       */
// objetivo:
function Cabecalio_simplificado_por_id($fs) {
	global $arqconfig;
	global $mensagens;
	Envia_mensagem($mensagens['Mens39']);
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

// esse backoffice sintético é exclusivo para a entrada de dados no banco de dados da aldir blanc. Ele assume que existe um campo id_curador na tabela su_documents e usa o nome do usuário como chave de busca, para que o usuário veja apenas os registros que estão associados a ele.
$banco_de_dados=$banco;
$limitador_registros=50;
if(isset($_GET[\'id_usuario\'])){
  $id_usuario = $_GET[\'id_usuario\'];
}

$conn= new mysqli(\'localhost\', $username, $pass, $banco_de_dados);

echo "
<html>
	<head>
		<title>BackOffice Simplificado</title>
		<link rel=\'stylesheet\' href=\'../su_css/super_cabecalio_simplificado.css\' type=\'text/css\'>
	</head>
<body>
<h1>BackOffice Potlatch - Simplificado - Usuário: \'.$usuario.\'</h1>
<table class=\"tabela_principal\">
<tr>
<th>Tabela</th><th>Descrição</th><th>Botão de Acesso</th>
</tr>
";

// o trecho abaixo foi retirado porque nessa versão do super_backoffice_aldir_blanc_por_id, o id vem da porta de entrada 
//$sql_id_usuario=\'select id_chave_registrado from su_registrados where nome_registrado like "\'.$usuario.\'%" \';
//
//$result_id_usuario=$conn->query($sql_id_usuario);
//if ($result_id_usuario->num_rows>0) {
//  while($row_id_usuario=$result_id_usuario->fetch_assoc())
//    {
//		$id_usuario=$row_id_usuario[\'id_chave_registrado\'];
//	}
//} else {echo \'Usuário não encontrado\';}

$sql_schema=\'SELECT nome_tabela, descricao_tabela FROM su_tabelas_para_usuario;\'; 

$result_schema=$conn->query($sql_schema);
if ($result_schema->num_rows>0) {
  while($row_schema=$result_schema->fetch_assoc())
    {
		$nome_tabela=$row_schema[\'nome_tabela\'];
		$descricao_tabela=$row_schema[\'descricao_tabela\'];
		if ($nome_tabela==\'su_documents\'){
				echo \'<tr><td>\'.$nome_tabela.\'</td><td>\'.$descricao_tabela.\'</td><td><input type="button" value="\'.$nome_tabela.\'" onclick="Abre_insere(`super_insere_\'.$nome_tabela.\'.php?offset=0&limit=\'.$limitador_registros.\'&campo_busca=id_curador&valor_busca=\'.$id_usuario.\'`);" ></td></tr>\';
										}
		else {
				echo \'<tr><td>\'.$nome_tabela.\'</td><td>\'.$descricao_tabela.\'</td><td><input type="button" value="\'.$nome_tabela.\'" onclick="Abre_insere(`super_insere_\'.$nome_tabela.\'.php?offset=0&limit=\'.$limitador_registros.\'&campo_busca=&valor_busca=`);" ></td></tr>\';
		}
	}
} else {echo \'<tr><td>Não tem dados</td></tr>\';} 
echo \'
</table>
<script>

function Abre_insere(codigo_php){

var w=window.open(``,`Insere_backoffice_hiper`,`width=900 height=600`);
w.document.body.innerHTML="<div id=`aguarde_inicio` style=`position: absolute; left: 50%; top: 50%; font-size: 50px; padding: 10px; color: black; border: 10px solid black; background-color: yellow; `>AGUARDE</div>";

setTimeout(
function(){
           var resposta=``;
           var url=codigo_php;
           var oReq=new XMLHttpRequest();
           oReq.open(`GET`, url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     w.document.write(resposta);
                     }
           oReq.send();
}, 300);
}

</script>
</body>
</html>
\';

?>

';

fwrite($fs,iconv('UTF-8','UTF-8',$php)."\n");

} // fim function Cabecalio_simplificado_por_id
//
/* ##################### >>>>   FUNÇÃO 21: Cabecalio_simplificado   <<<<< #####################                       */
// objetivo:
function Cabecalio_simplificado($fs) { 
	global $arqconfig;
	global $mensagens;
	Envia_mensagem($mensagens['Mens40']);
	$php='<?php
//require("../su_install/'.$arqconfig .'");
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";

// esse backoffice sintético é exclusivo para a entrada de dados no banco de dados da aldir blanc. Ele assume que existe um campo id_curador na tabela su_documents e usa o nome do usuário como chave de busca, para que o usuário veja apenas os registros que estão associados a ele.

$limitador_registros=50;
if(isset($_GET[\'usuario\'])){
  $usuario = $_GET[\'usuario\'];
}

$conn= new mysqli(\'localhost\', $username, $pass, $banco_de_dados);

echo \'
<html>
	<head>
		<title>BackOffice Simplificado</title>
		<link rel=\'stylesheet\' href=\'../su_css/super_cabecalio_simplificado.css\' type=\'text/css\'>
	</head>

<body>
<h1>BackOffice Potlatch - Simplificado - Usuário: \'.$usuario.\'</h1>
<table class="tabela_principal">
<tr>
<th>Tabela</th><th>Descrição</th><th>Botão de Acesso</th>
</tr>
\';

$sql_id_usuario=\'select id_chave_registrado from su_registrados where nome_registrado like "\'.$usuario.\'%" \';

$result_id_usuario=$conn->query($sql_id_usuario);
if ($result_id_usuario->num_rows>0) {
  while($row_id_usuario=$result_id_usuario->fetch_assoc())
    {
		$id_usuario=$row_id_usuario[\'id_chave_registrado\'];
	}
} else {echo \'Usuário não encontrado\';}

$sql_schema=\'SELECT nome_tabela, descricao_tabela FROM su_tabelas_para_usuario;\'; 

$result_schema=$conn->query($sql_schema);
if ($result_schema->num_rows>0) {
  while($row_schema=$result_schema->fetch_assoc())
    {
		$nome_tabela=$row_schema[\'nome_tabela\'];
		$descricao_tabela=$row_schema[\'descricao_tabela\'];
		if ($nome_tabela==\'su_documents\' && strlen($usuario)>0){
				echo \'<tr><td>\'.$nome_tabela.\'</td><td>\'.$descricao_tabela.\'</td><td><input type="button" value="\'.$nome_tabela.\'" onclick="Abre_insere(`super_insere_\'.$nome_tabela.\'.php?offset=0&limit=\'.$limitador_registros.\'&campo_busca=id_curador&valor_busca=\'.$id_usuario.\'`);" ></td></tr>\';
										}
		else {
				echo \'<tr><td>\'.$nome_tabela.\'</td><td>\'.$descricao_tabela.\'</td><td><input type="button" value="\'.$nome_tabela.\'" onclick="Abre_insere(`super_insere_\'.$nome_tabela.\'.php?offset=0&limit=\'.$limitador_registros.\'&campo_busca=&valor_busca=`);" ></td></tr>\';
		}
	}
} else {echo \'<tr><td>Não tem dados</td></tr>\';} 
echo \'
</table>
<script>

function Abre_insere(codigo_php){
	
var w=window.open(``,`Insere_backoffice_hiper`,`width=900 height=600`);
w.document.body.innerHTML="<div id=`aguarde_inicio` style=`position: absolute; left: 50%; top: 50%; font-size: 50px; padding: 10px; color: black; border: 10px solid black; background-color: yellow; `>AGUARDE</div>";

setTimeout(
function(){
           var resposta=``;
           var url=codigo_php;
           var oReq=new XMLHttpRequest();
           oReq.open(`GET`, url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     w.document.write(resposta);
                     }
           oReq.send();
}, 300);
}


</script>
</body>
</html>
\';

?>

';

fwrite($fs,iconv('UTF-8','UTF-8',$php)."\n");

} // fim function Cabecalio_simplificado
/* ######################## >>>>   FUNÇÃO 22: Cabecalio_main   <<<<< ########################                       */
// objetivo:
function Cabecalio_main($fs){
	global $mensagens;
	global $arqconfig;
	Envia_mensagem($mensagens['Mens41']);
	$html='<?php
//require_once "../su_install/super_config_php.cnf";
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
?>
';

	$html .="
<html>
<head>
<title>Back-Office do Observatório Aldir Blanc</title>
<link rel='stylesheet' href='../su_css/super_backoffice.css' type='text/css'>
<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate'/>
<meta http-equiv='Pragma' content='no-cache'/>
<meta http-equiv='Expires' content='0'/>

<meta charset='UTF-8'>
</head>
<body onload='carrega_botoes()'>
<div class='cabecalio'>
<h1>".$mensagens['Mens04']."</h1>
</div>

<div class='sobe_arquivos'>
<p>".$mensagens['Mens01']."</p>

<form method='post' action='super_sobe_multiplos.php' enctype='multipart/form-data'>
 
 <input type='file' name='file[]' id='file' multiple>
 <input type='submit' name='submit' value='Upload'>

</form>
</div>

<table class='botoeira'>
<tr>
<th colspan=5>".$mensagens['Mens13']."</th>
</tr>
<tr>
<td>".$mensagens['Mens05']."</td>
<td>".$mensagens['Mens06']."</td>
<td>".$mensagens['Mens07']."</td>
<td>".$mensagens['Mens08']."</td>
<td>".$mensagens['Mens09']."</td>
<td>".$mensagens['Mens10']."</td>
</tr>
<tr>
<td id='fks_0'></td><td id='fks_1'></td><td id='fks_2'></td><td id='fks_3'></td><td id='fks_4'></td><td id='fks_5'></td>
</tr>
<tr>
<td id='n_fks_0'>0</td><td id='n_fks_1'>0</td><td id='n_fks_2'>0</td><td id='n_fks_3'>0</td><td id='n_fks_4'>0</td><td id='n_fks_5'>0</td>
</tr>
<tr>
<td></td>
<td></td>
<td>".$mensagens['Mens11']."</td>
<td></td>
<td></td>

</tr>
<tr>
<tr>
<td></td>
<td></td>
<td id='left_join'></td>
<td></td>
<td></td>
</tr>
</table>
<script>

function carrega_botoes()
{
";

fwrite($fs,iconv('UTF-8','UTF-8',$html)."\n");

} // fim function cabecalio
//
/* ######################## >>>>   FUNÇÃO 23: Peseira_main   <<<<< ########################                       */
// objetivo:
function Peseira_main($fs){
	$html='
}
function Abre_insere(codigo_php){
	
var w=window.open("","Insere_backoffice_hiper","width=900 height=600");
w.document.body.innerHTML="<div id=\'aguarde_inicio\' style=\'position: absolute; left: 50%; top: 50%; font-size: 50px; padding: 10px; color: black; border: 10px solid black; background-color: yellow; \'>AGUARDE</div>";

setTimeout(
function(){
           var resposta="";
           var url=codigo_php;
           var oReq=new XMLHttpRequest();
           oReq.open("GET", url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     w.document.write(resposta);
                     }
           oReq.send();
}, 300);
}

function Abre_VerDef(tabela){

var w=window.open("","EstruturaDaTabela","width=900 height=600");
           var resposta="";
           var url="super_verdef.php?tabela="+tabela;
           var oReq=new XMLHttpRequest();
           oReq.open("GET", url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
                     w.document.write(resposta);
                     }
           oReq.send();
}
</script>
</body>
</html>
';

fwrite($fs,$html."\n");

}
//
/* ######################## >>>>   FUNÇÃO 24: CriaBotao   <<<<< ########################                       */
// objetivo: criar os botoes que aparecerao na tela de backoffice
function CriaBotao($fs,$tabela,$n_fks){
	global $banco_de_dados;
	global $limitador_registros;
	global $mensagens;
	if ($n_fks>5) {$n_fks=5;} // faz os botoes cairem em fks_5 se o numero de FKs for maior ou igual a 5.
	$botao="
var txt=document.getElementById('fks_".$n_fks."').innerHTML;
var conta=document.getElementById('n_fks_".$n_fks."').innerText;
var valor=parseInt(conta)+1;
document.getElementById('fks_".$n_fks."').innerHTML=txt+'<input type=".'"'."button".'"'." value=".'"'.$tabela.'"'." onclick=\"Abre_insere(\\'super_insere_".$tabela.".php?offset=0&limit=".$limitador_registros."&campo_busca=&valor_busca=\\')\"/><input  type=".'"'."button".'"'." value=".'"'.$mensagens['Mens14'].'"'." style=".'"font-size: x-small; color:white; background-color: blue; border: 1px solid black"'." onclick=\"Abre_VerDef(\\'".$tabela."\\')\"/><br>';
document.getElementById('n_fks_".$n_fks."').innerText=valor;
";

fwrite($fs,$botao."\n");
if ($n_fks==2) // cria os botões para visualização join com dois FKs
	{
		
		$botao_join="
var txt2=document.getElementById('left_join').innerHTML;
document.getElementById('left_join').innerHTML=txt2+'<input type=".'"'."button".'"'." value=".'"join: '.$tabela.'"'." onclick=\"Abre_insere(\\'super_join_".$tabela.".php\\')\"/><br>';

			";

fwrite($fs,$botao_join."\n");
	}

}
/* ######################## >>>>   FUNÇÃO 25: Reescreve a função de acesso à tabela   <<<<< ########################  */
// objetivo: a tabela só deve ser acessada via Painel de Administração da Superinterface. Inibir o acesso via Potlatch
function Reescreve_funcao($fs,$tabela){
	global $arqconfig;
	global $mensagens;
	require("$arqconfig");
$php='<?php
require_once "'.$arqconfig.'";
$identscript=$pag_backoffice1;      // identificação do script super_backoffice.php
require_once "../su_admin/super_config_includes.php";
echo "
<html>
<head>
<title>Inserção de dados na tabela de usuários</title>
<link rel=\'stylesheet\' href=\'../su_css/super_cria_insere.css\' type=\'text/css\'>
<meta http-equiv=\'Cache-Control\' content=\'no-cache, no-store, must-revalidate\'/>
<meta http-equiv=\'Pragma\' content=\'no-cache\'/>
<meta http-equiv=\'Expires\' content=\'0\'/>

<meta charset=\'UTF-8\'>
</head>
<body id=\'conteudo\'>
<div class=\'cabecalio\'>
<h1>'.$mensagens['Mens12'].$tabela.'</h1>
<div id=\'id_comentario_tabela\' style=\'border: 2px solid blue; background: yellow\'></div>
</div>
<div id=\'insercao\' class=\'botoeira\'>
</div>

<div style=\'border: 1px solid black; background-color: orange; width: 100%\'>
	<table style=\'width: 100%\'>
	<tr><td> </td><td> </td><td> </td></tr>
	</table>
</div>
"; 

echo "<div style=\'width: 100%; height: 40px; overflow-y: scroll\'></div>";

echo "
<div class=\'centrar\'><h2> Desculpe!!</h2></div><br />
<div class=\'centrar\'><h3>Mas esta tabela só pode ser acessada via o <br />Painel de Administração da Superinterface.</h3></div>

<div class=\'centrar\'>
<input type=\'button\' class=\'w3-button w3-verde\' value=\'Fechar\'  onclick=\'window.close()\'></div>

</body>
</html>";
?>';
fwrite($fs,$php);
}
/*
+ --------------------------------------------------------------------------------------------------------------------------+
|																															|
|                                             INÍCIO DO PROGRAMA															|
|																															|
+---------------------------------------------------------------------------------------------------------------------------+
*/
setlocale(LC_ALL, 'pt_BR');
$dir=getcwd();
$date=date('d/m/Y h:i:s a', time());
$database=$banco_de_dados;
//
$fs=fopen('../su_autophp/super_backoffice.php','w');
// 						Porta de entrada para o Backoffice exclusivo para a aldir blanc, que tem id_curador
// 						em documentos - nesta versao ele usa o nome do usuario para escolher apenas os documentos
// 						daquele usuario, atraves de id_curador
$fs_2=fopen('../su_autophp/super_backoffice_aldir_blanc_por_nome.php','w'); 
//						Porta de entrada para o Backoffice exclusivo para a aldir blanc, que tem id_curador em 
//						documentos - nesta versao ele usa o id do usuario para passar para insere_documentos,
//						ao inves do nome do usuario. O id do usuario vem de outro pedaço de código em HTML que é 
//						o super_backoffice_aldir_entrada_principal.html
$fs_3=fopen('../su_autophp/super_backoffice_aldir_blanc_por_id.php','w');
$fs_4=fopen('../su_autophp/super_backoffice_aldir_entrada_principal.html','w');

//
Cria_puxa_lista_NtoN();
Cria_VerDef(); 			// cria o programa PHP que permite ver a definição de uma tabela
Cria_Insercao(); 		// cria o programa PHP que permite ver a definição de uma tabela, juntamente com a visão 
						// dos campos de insercao de dados
Cria_Insercao_N_to_N(); // cria o programa PHP que pode ser chamado de dentro de um super_insere_<tabela>.php para 
						//permitir a atualizacao de uma relacao N_to_N
Cria_auto_ler_php(); 	//cria o programa em PHP que permite ver todas as tabelas (coracao do programa)
Cria_Busca_Like(); 		// cria o PHP para buscar a lista de nomes_ de uma tabela FK, usando where X like %
Cria_super_busca_registro_inteiro();
Cria_auto_apaga_php(); 	//cria o programa em PHP que permite apagar um registro (delete)
Cria_auto_alterar_php();//cria o programa em PHP que permite alterar um campo (update)
Cria_auto_insere_php(); //cria o programa em PHP que permite inserir registros numa tabela do banco de dados (insert)
Cria_pdf_thumb();
Cria_sobe_multiplos();
Cria_Upload_PHP();  	// cria o programa PHP que é chamado pelo POST para dar UPLOAD nas su_imagens.
Cria_Mostra_Diretorios_PHP(); // cria a página que vai buscar a lista de arquivos de su_imagens
Cria_seleciona_fk(); 	// cria o php que vai permitir selecionar um valor de registro numa tabela fk
Cabecalio_simplificado($fs_2);
Cabecalio_simplificado_por_id($fs_3);
Cria_Entrada_Para_Aldir_Blanc($fs_4);
Cabecalio_main($fs);
$conn= new mysqli("localhost", $username, $pass, $database);

$sql_delete="delete from su_tabelas_ligacao;";  // precisa limpar essa tabela toda vez
if ( $conn->query($sql_delete) !== true){
		throw new Exception ($mensagens['Mens31']);
}

$saida_html="
	<!--
	<!DOCTYPE html>
	<html lang=\"pt-br\">
	<head>
	<title>Criador de Interfaces do Platuósh(c) 2021</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate'/>
	<meta http-equiv='Pragma' content='no-cache'/>
	<meta http-equiv='Expires' content='0'/>
	<!-- <link rel='stylesheet' href='../su_css/super_criador.css' type='text/css'> -->
<!--
	</head>
	<body>
	<div id='menu'>
	</div>
	<div id='mensagem'>
	</div>
-->
	<div id='conteudo'>
	<p class='titulo'>".$mensagens['Mens02'].$banco_de_dados."</p>
	<p class='subtitulo'>".$mensagens['Mens43'].": ".$date."</p>
<!--	<input type='button' value='".$mensagens['Mens33']."'>; -->
";

$sql="
select col.TABLE_NAME as 'table',
       col.ordinal_position as col_id, col.data_type as dt, col.character_maximum_length as ml,
       col.COLUMN_NAME as COLUMN_NAME,
       case when kcu.REFERENCED_TABLE_SCHEMA is null
            then null
            else '>-' end as rel,
       concat(kcu.REFERENCED_TABLE_NAME) as primary_table,
       kcu.REFERENCED_COLUMN_NAME as pk_COLUMN_NAME,
       kcu.constraint_name as fk_constraint_name
       from information_schema.columns col
       join information_schema.tables tab
            on col.TABLE_SCHEMA = tab.TABLE_SCHEMA
	        and col.TABLE_NAME = tab.TABLE_NAME
		left join information_schema.key_column_usage kcu
		      on col.TABLE_SCHEMA = kcu.TABLE_SCHEMA
		      and col.TABLE_NAME = kcu.TABLE_NAME
			  and col.COLUMN_NAME = kcu.COLUMN_NAME
			  and kcu.REFERENCED_TABLE_SCHEMA is not null
			  where col.TABLE_SCHEMA not in('information_schema','sys',
			           'mysql', 'performance_schema')
			            and tab.table_type = 'BASE TABLE'
			    		and col.TABLE_SCHEMA = '".$banco_de_dados."'
						order by col.TABLE_SCHEMA,
						col.TABLE_NAME,
						col.ordinal_position;
;";

$conta=0;
$conta_fks=0;
$old_table="";
$campos = array();
$fks_table = array();
$fks_campos = array();
$result=$conn->query("$sql");
$saida_html=$saida_html."<table class='com_FK'>"; 
//fwrite($fs,iconv('UTF-8','UTF-8',"</td><td>")."\n");
$fs_temp = Null;
$fs_join = Null;
if ($result->num_rows>0) {
	while($row=$result->fetch_assoc())	// loop em cada campo do conjunt de tabelas
	{
		$table=$row["table"];
      	if ($old_table==$table){}
		else	// acabou o tratamento dos campos de uma tabela
      	{
			if ($old_table!=""){
				$saida_html=$saida_html."<tr><td>Total de Fks</td><td colspan=5>".$conta_fks."</td></tr>";
				CriaBotao($fs,$old_table,$conta_fks);
				//$fs_temp=fopen($dir.'/su_autophp/super_insere_'.$old_table.'.php','w');
				if (is_resource($fs_temp)) {fclose($fs_temp);}
				if ((is_resource($fs_join)) && ($conta_fks==2)) {fclose($fs_join);}
				setlocale(LC_ALL, 'pt_BR');
				$dir=getcwd();
				$fs_temp=fopen($dir.'./../su_autophp/super_insere_'.$old_table.'.php','w');
				if ($conta_fks==2) {$fs_join=fopen($dir.'./../su_autophp/super_join_'.$old_table.'.php','w');}
        		//fwrite($fs_temp,print_r($campos, true));	      
        		Cria_insere($fs_temp,$banco_de_dados, $old_table,$campos,$fks_table,$fks_campos);
				if ($conta_fks==2) {  
					// a tabela contém duas chaves estrangeiras
					Cria_join_view($fs_join,$banco_de_dados, $old_table,$campos,$fks_table,$fks_campos);
				}
				$campos=[];
				$fks_campos=[];
				$fks_table=[];
			}	// if
			$conta_fks=0;
			$conta=$conta+1;
			$saida_html=$saida_html."</table><br /><br /><table class='com_FK'><caption>".$conta.") ".$table."</caption><tr><th>Tabela</th><th>Campo</th><th>Tipo</th><th>Tamanho</th><th>Foreign table</th><th>Foreign column</th></tr>";
		}	// if
	    $old_table=$table;
	    $coluna=$row["COLUMN_NAME"];
        $campos[]=$coluna;
        $type=$row["dt"];
        $length=$row["ml"];
        $rtn=$row["primary_table"];
        $fks_table[$table.$coluna]=$rtn;             
        $rcn=$row["pk_COLUMN_NAME"];
        $fks_campos[$table.$coluna]=$rcn;             
        if ($rtn!=""){$conta_fks=$conta_fks+1;}
		$saida_html=$saida_html."<tr><td>".$table."</td><td> ".$coluna."</td><td>".$type."</td><td>".$length."</td><td>".$rtn."</td><td>".$rcn."</td></tr>";  
	}	// while
	// varreu todos os campos das tabelas
	CriaBotao($fs,$old_table,$conta_fks);
	$saida_html=$saida_html."<tr><td>Total de Fks</td><td colspan=5>".$conta_fks."</td></tr>";
	if (is_resource($fs_temp)) {fclose($fs_temp);}
	setlocale(LC_ALL, 'pt_BR');
	$dir=getcwd();
	$fs_temp=fopen($dir.'./../su_autophp/super_insere_'.$old_table.'.php','w');
	Cria_insere($fs_temp,$banco_de_dados, $old_table,$campos,$fks_table,$fks_campos);
	if ($conta_fks==2) {
		$fs_join=fopen($dir.'./../su_autophp/super_join_'.$old_table.'.php','w');
		Cria_join_view($fs_join,$banco_de_dados, $old_table,$campos,$fks_table,$fks_campos);
		fclose($fs_join);
	}
} // if
else {
	throw new Exception ($mensagens['Mens32']);
}
$tabela="su_usuarios";
$fs_temp=fopen($dir.'./../su_autophp/super_insere_'.$tabela.'.php','w');
Reescreve_funcao($fs_temp,$tabela);
$saida_html=$saida_html."</table><br /><br /><br /><br /><br /><br /></div>";
#$saida_html=$saida_html."</body></html>";
if(file_exists( $pastalogs."/".$listatabelas )){
	unlink ($pastalogs."/".$listatabelas);
}
$fp = fopen($pastalogs."/".$listatabelas, "a+");
fwrite($fp, $saida_html);
fclose($fp);
Peseira_main($fs);
fclose($fs);

?>


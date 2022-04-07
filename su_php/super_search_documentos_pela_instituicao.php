<?php
if(isset($_GET["banco"])){
  $banco = $_GET["banco"];
}


if(isset($_GET["instituicao"])){
  $instituicao_entrada = $_GET["instituicao"];
}
require('../su_admin/super_config_php.cnf');
$database=$banco;
$conn= new mysqli("localhost", $username, $pass, $database);

// $sql="select d.id_chave_documento as id, d.sigla as dsigla, d.data_doc as ddata, d.descricao as ddescricao, d.relevancia as drelevancia, d.photo_filename_documento as dpath, d.alt_foto_jpg as jpg, i.nome_instituicao as ninstituicao, d.nome_documento as dnome, di.ocorrencia_inst as dcorrencia from su_instituicoes as i, su_documents as d, su_docs_instituicoes as di where di.id_documento=d.id_chave_documento and i.id_chave_instituicao=di.id_instituicao and i.instituicao_sem_acentuacao like '".$instituicao_entrada."%' group by id_chave_documento order by i.nome_instituicao asc, di.ocorrencia desc;";

$sql="select d.id_chave_documento as id, d.sigla as dsigla, d.data_doc as ddata, d.descricao as ddescricao, d.relevancia as drelevancia, d.photo_filename_documento as dpath, d.alt_foto_jpg as jpg, i.nome_instituicao as ninstituicao, d.nome_documento as dnome, di.ocorrencia_inst as dcorrencia from su_docs_instituicoes as di, su_documents as d, su_instituicoes as i where di.id_documento=d.id_chave_documento and i.id_chave_instituicao=di.id_instituicao and i.instituicao_sem_acentuacao like '".$instituicao_entrada."%' group by id_chave_documento order by i.nome_instituicao asc;";

$result=$conn->query("$sql");
if ($result->num_rows>0)
{
		$conta=0;
		while ($row=$result->fetch_assoc())
		{
				$conta=$conta+1;
				$id=$row["id"];
				$inst=$row["ninstituicao"];
				$ocorrencia=$row["dcorrencia"];
				$data=$row["ddata"];
				$larg_data="10%";
				$style_data="";
				$sigla=$row["dsigla"];
				$nome=$row["dnome"];
				$larg_nome="10%";
				$descricao=$row["ddescricao"];
				$larg_descricao="20%";
				$relevancia=$row["drelevancia"];
				$larg_relevancia="35%";
				$path=$row["dpath"];
				$larg_botao="5%";
				$jpg=$row["jpg"];
				$signatario="";
				$sql2="select r.nome_registrado as signatario from su_registrados as r, su_documents as d,  su_docs_signatarios as ds where d.id_chave_documento=ds.id_documento and r.id_chave_registrado=ds.id_signatario and id_documento='".$id."';";
				$conta_2=0;
				$result2=$conn->query("$sql2");
				if ($result2->num_rows>0){
						while ($row2=$result2->fetch_assoc())
						{
								if ($conta_2==0) {$virgula="";} else {$virgula=", ";}
								$signatario=$signatario.$virgula.$row2["signatario"];
								$conta_2++;
						}
				} else {$signatario="sem dado";}

				$instituicao="";
				$sql2="select i.nome_instituicao as instituicao from su_instituicoes as i, su_documents as d,  su_docs_instituicoes as di where d.id_chave_documento=di.id_documento and i.id_chave_instituicao=di.id_instituicao and id_documento='".$id."';";
				$conta_2=0;
				$result2=$conn->query("$sql2");
				if ($result2->num_rows>0){
						while ($row2=$result2->fetch_assoc())
						{
								if ($conta_2==0) {$virgula="";} else {$virgula=", ";}
								$instituicao=$instituicao.$virgula.$row2["instituicao"];
								$conta_2++;
						}
				} else {$instituicao="sem dado";}

				$larg_signatario="10%";
				$larg_instituicao="5%";
				echo 
						"<div class='ops barras' id='".$conta."' style='display: none'>
						<table id='table_".$conta."'>
						<tr>";

				echo "<td width='".$larg_data."'>
						<table style='font-size: 1.3em;'>
						<tr>
						<th>".$data."</th>
						</tr>
						<tr>
						<th>".$sigla."</th>
						</tr>
						<tr>
						<th>".$instituicao."</th>
						</tr>

						</table>

						</td>";
				echo "<td width='".$larg_nome."'      title='".$nome."' style='font-size: 1.4em;'><b>".$nome."</b></td>";
				echo "<td width='".$larg_descricao."' title='".$descricao."' style='font-size: 1.2em;'>".$descricao."</td>";
				echo "<td width='".$larg_relevancia."' title='".$relevancia."' style='font-size: 1.2em;'>".$relevancia."</td>";
				echo "<td width='".$larg_signatario."' style='font-size: 1.1em;'>".$signatario."</td>";
				echo "<td width='".$larg_botao."'>
				<table>
				<tr>
				<td style='font-size: 0.8em;'>
						<input type='button' value='amplia' id='but_".$conta."' data-id='".$path."' data-jpg='".$jpg."' style='height: auto'
						onclick='
						var file_=".'"'.str_replace("../","",$path).'"'.";
				console.log(file_);
				if (file_ != ".'""'.") {
						var wu=window.open( ".'""'.", ".'"Janela_Ampliacao"'.", ".'"width="'."+screen.availWidth+".'" height="'."+screen.availHeight);
						if (file_.indexOf(".'"pdf"'.")>-1){
								wu.document.write(".'"<embed src="+`\"`+file_+`\"`+" width=800px height=2100px/>"'." );
						} 
						else
						{
								wu.document.write(".'"<embed src="+`\"`+file_+`\"`+" width=800px height=auto/>"'." );
						}	
				} else {alert(`Você não selecionou uma imagem!`);}
				'

						>
				</td>		
				</tr>
				<tr>
				<td style='font-size: 0.6em;'>
				<b>".$inst."</b>
				</td>
				</tr>
				<tr>
				<td  style='font-size: 0.6em;'>
				Qtd.:
				".$ocorrencia."
				</td>
				</tr>
				</table>
						</td>";
				echo "</tr></table>";
				echo"</div>";
		}
}

?>

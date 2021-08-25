<script>
// "Ver3D" Software. (executable filename: fotos_hiper.php)
// This is free software for spheric visualization  of "SELECT" results obtained from a QUERY applied to a given database. 
// This version is for collaborative development. This version only works on CHROME - Please, help to PORT it!
//
// This software was developed by Victor Mammana in June, 2019.
//
// You are free to use this version, provided it is not used for fascists purposes.
//
// A dummy database is provided in the file "Ver3D.sql". Just upload it to MYSQL using the command "mysql -u user -p Ver3D < Ver3D.sql". Before uploading it, don't forget to create in on MYSQL prompt, by use of "create database Ver3D". Don't forget to grant privileges to "desenvolvedor" user, through "grant all privileges on Ver3D.* to etc... etc...  
// The database is called Ver3D (translated to English it would sound something like "Watch3D" or "3DView").
// The "Ver3D" example database is available at the repository and it is constituted of 2 tables: eventos (events) and fotos (photos). The name "eventos" is totally incidental, so change it for the name you prefer. 
// The tables of Ver3D database are described as follows:
//
// TABLE EVENTOS (disrefard the name of the table and change it for the name you prefer)
// mysql> desc eventos;
//+-----------+--------------+------+-----+---------+----------------+
//| Field     | Type         | Null | Key | Default | Extra          |
//+-----------+--------------+------+-----+---------+----------------+
//| id        | int(11)      | NO   | PRI | NULL    | auto_increment |
//| descricao | varchar(100) | YES  |     | NULL    |                |
//+-----------+--------------+------+-----+---------+----------------+
// comments: contains the description of the events (field "descricao") and a primary auto_increment key: field "id".
//
//TABLE FOTOS (translation to English: Photos)
//mysql> desc fotos;
//+-----------+-------------+------+-----+---------+----------------+
//| Field     | Type        | Null | Key | Default | Extra          |
//+-----------+-------------+------+-----+---------+----------------+
//| id        | int(11)     | NO   | PRI | NULL    | auto_increment |
//| path      | varchar(10) | YES  |     | NULL    |                |
//| id_evento | int(11)     | YES  | MUL | NULL    |                |
//+-----------+-------------+------+-----+---------+----------------+
// comments: "id" is a auto_increment key, 
//           "path" is the name of the file with path, respecful to html directory where APACHE looks for its php files. 
//           Put images (jpg or png) in any directory below "../html" directory and guarantee that the APACHE user has privileges to 
//               access it
//           "id_evento" is a cross reference to "id" from TABLE EVENTOS
//
// Modify the database to make it useful for your needs.
// 20 jpg files are provided for testing. Just substitute it by your own images. Your files can be named as desired. Just put the names of your files on the "path" field. For simplicity, the example files were named with numbers (1 to 20.jpg).
// 
// There is a unique key to avoid two diffent register on "fotos" with the same "id_evento"/"path" just to avoid duplicity.
//
// The challenges that need to be improved are:
//
// a) include "photographic hole box" perspective, to improve the 3D appearance of the screen
// b) perhaps substtute the management of 3D appearance by some solution available on CSS  
// c) improve the downloading speed by use of some real time thumbnail conversion, instead of the full image download
// d) improve the 3D appearance of the DIV components
// e) make it work on FIREFOX, SAFARI and INTERNET EXPLORER (it only works on Chrome)
// f) avoid the squared appearance of div components, making it showup on perspective
// g) fix some bugs on the extremes of the algorithm. For example, when the scroll hits the end of the list of registers.
//
// 2021-04-10 VPM -> the item (e) was approached and it is now working on FIREFOX
// 2021-04-10 VPM -> inclusion of the search box when evidente=1


var velho_evidente=0;
var zeroTouch=0;
var delta;
var larg_primeiro=100; // estava 80 - determina o tamanho do div central, portanto afeta os demais
var fator=0.5;
var divisao=10;
var alt_corte=5;

var evidente=1;
var max_reg=0;
var animacao=0;
var animacao_touch=0; // trava o scroll com o touch, senao fica pulando de 3 em 3 na hora que arrasta com o dedo
var executa_animacao;
var desktop_igual_mobile=false; // se for true entao vai ter um comportamento unico para mobile e desktop. False, tem comportamentos diferentes para mobile e desktop

var conta_disparo;
var flag_carregando;
var timeoutId = [];
var toggle_cor=false; // truque para fazer a janela de avisos (carregando) mudar de cor a cada iteração do setInterval


var aviso_carregando; // aviso no meio da tela que é acionado quando o sujeito tecla no textbox de busca de cidade e o httprequest ainda não retornou
window.addEventListener('load', function(){
				document.body.addEventListener('wheel', trata_wheel, true);
				document.body.addEventListener('touchstart', function(e1){zeroTouch=e1.changedTouches[0].pageY;});
				document.body.addEventListener('touchmove', function(e2){
								if (animacao_touch>0) {return;}
								animacao_touch++;
								if (e2.changedTouches[0].pageY-zeroTouch>0){delta=-1;} else {delta=1;};
								evidente=evidente+delta;
								setTimeout(function(){animacao_touch=0;},100); // segura um tempo antes de permitir uma nova acao, senao ele pula varias barras no touch
								if (evidente<1){evidente=1;}
								if (evidente>max_reg){evidente=max_reg;}
								mostra(evidente,Math.trunc(altura_minimizada/2),300);

								});
				document.body.addEventListener("keydown", keyDownPaleta, false);
				document.getElementById("search_nome").addEventListener('keyup',
										function (e10)
											{
												var keyCode = e10.keyCode;
												var code=keyCode;
												//var code = (keyCode ? keyCode : e10.which);
												var itz= document.getElementById("search_nome").value;
												if (!isArrowHomeEnd(code)) {keyBusca("nome");}
												console.log("tecla: "+isArrowHomeEnd(code));
											}
									);
				document.getElementById("search_cidade").addEventListener('keyup',
									    function (e11)
											{
												var keyCode = e11.keyCode;
												var code = (keyCode ? keyCode : e11.which);
												var itz= document.getElementById("search_cidade").value;
												if (!isArrowHomeEnd(code) && large_enough(itz)) {keyBusca("cidade");}
												else { if (!large_enough(itz)){limpa_barras();}}

											}
									);
				document.getElementById("search_cidade").addEventListener('blur',
								    function (e12)
										{
											document.getElementById("search_cidade").value="";
											console.log("blur: "+flag_carregando+" conta_disparo: "+conta_disparo);
											keyBusca("nome");
										}
									);

				},false);
document.body.style.zoom = "1.0";

function large_enough(str){ // verifica se o string é grande o suficiente para evitar buscas demoradas

console.log("tama: "+ str.replace(/ /g,"").length)
return str.replace(/ /g,"").length>2;

} //fim

function isArrowHomeEnd(asc){ // verifica se o ascii é de arrow, home ou end para evitar disparar buscas quando está navegando e o text box está com foco (porque nesse caso o keyup é disparado e isso gera uma busca demorada, o que não é desejável)

var boole= asc==35 || asc==36 || asc==40 || asc==38;
return boole;
}

function keyBusca(tipo) { // trata os eventos de keyup nos text de busca
console.log("catso: "+flag_carregando+" conta_disparo: "+conta_disparo);
if (flag_carregando==0) 
		{
				flag_carregando=1; 
				aviso_carregando=setInterval
						(
								function()
									{
											toggle_cor=!toggle_cor;
											document.getElementById("aviso_carregando").style.visibility = "visible"; 
											document.getElementById("aviso_carregando").innerText="Carregando "+tipo+"...";
											document.getElementById("aviso_carregando").style.backgroundColor=(toggle_cor==1 ? "yellow" : "red");
											document.getElementById("aviso_carregando").style.top=  parseInt(document.getElementById("search_box_instancia").style.top.replace("px","")) + 
																									parseInt(document.getElementById("search_box_instancia").style.height.replace("px","")) - 
																								  	parseInt(document.getElementById("aviso_carregando").clientHeight) + "px";
											document.getElementById("aviso_carregando").style.left=Math.trunc(document.getElementById("paleta_instancia").clientWidth/2-parseInt(document.getElementById("aviso_carregando").clientWidth)/2)+"px";

											if (flag_carregando==0) 
														{
															document.getElementById("aviso_carregando").style.visibility = "hidden"; 
															clearInterval(aviso_carregando);
														}  
									},200);   
		console.log("zanja antes: "+conta_disparo+"flag_carregando: "+flag_carregando);
	if (conta_disparo==0) {
		conta_disparo++;  // conta o número de disparos de carrega que estão esperando para ocorrer via setTimeout
		console.log("zanja depois: "+conta_disparo+"flag_carregando: "+flag_carregando);		
		timeoutId.push(
		setTimeout
				(
					function()
						{
								console.log("tipao: "+tipo);
								var itz=document.getElementById("search_"+tipo).value;
								if (tipo=="cidade")
									{
										if (large_enough(itz)){carrega_dados(tipo,document.getElementById("search_"+tipo).value);}
										else {conta_disparo--; flag_carregando=0;}
									}								
									if (tipo=="nome")
									{
										carrega_dados(tipo,document.getElementById("search_"+tipo).value);
									}
						},1000
				));
		}
			 
		} else {console.log("disparo nao entrou: "+flag_carregando);}
} // fim keyBusca

function carrega_dados(tipo,texto_busca){  // chama o PHP que vai pegar os dados na base e joga na paleta_instancia

           var resposta="";

if (eh_mobile) {alert("ainda não disponível para mobile");return;}

else
{
		   if (tipo=="nome") {var url='su_php/super_search_documentos_pelo_nome.php?banco='+banco_de_dados+'&nome='+texto_busca;}
		   if (tipo=="cidade") {var url='su_php/super_search_documentos_pela_cidade.php?banco='+banco_de_dados+'&cidade='+texto_busca; console.log("texto: "+texto_busca);}
		   if (tipo=="palavra") {var url='su_php/super_search_documentos_pela_palavra.php?palavra='+texto_busca;}
} 
           var oReq=new XMLHttpRequest();
           oReq.open("GET", url, false);
           oReq.onload = function (e) {
                     resposta=oReq.responseText;
					 limpa_barras();

					 var itz_HTML=document.getElementById("paleta_instancia").innerHTML;
										 var quantidade= document.getElementsByClassName("barras").length;
//                     document.getElementById("paleta_instancia").innerHTML=itz_HTML + resposta;i // esta opção destroi tudo, inclusive os conteúdos dos input  text
					 document.getElementById("paleta_instancia").insertAdjacentHTML('beforeend', resposta);
					 flag_carregando=0;
					 conta_disparo--;
					 timeoutId.pop();
					mostra(1,Math.trunc(altura_minimizada/2),quantidade);

                     }
           oReq.send();


} // function carrega_dados()


function tela_na_vertical(){
		if(window.innerHeight > window.innerWidth){
				return true; //alert("na vertical");
		} else {return false;}
}


function limpa_barras(){

const elements = document.getElementsByClassName("barras");

while (elements.length > 0) elements[0].remove();

} // fim limpa_barras


function responde_ao_flip(){  // responde ao flip da tela do celular
		// nem precisa verificar se é celular, porque só o celular troca largura com altura (no flip)
		// para desktop é capaz que essa função seja chamada quando o usuário der zoom, o que é interessante para reorganizar os tamanhos das coisas

		if (conta_flip>0) {location.reload(); return;}

		if (verifica_se_eh_mobile())
		{
				if (tela_na_vertical())
				{
						larg_primeiro=150;
						divisao=5;	
				}
				else
				{
						larg_primeiro=50;
						divisao=5;

				}
				var altura_minimizada = Math.min( getDocHeight(), 
								body.offsetHeight,
								body.clientHeight, 
								html.clientHeight, html.scrollHeight, html.offsetHeight 
								);


				//limpa_barras(); // nao posso chamar limpa_barras porque o javascript não sabe recriar as barras. Elas são criadas pelo PHP
				mostra(1, Math.trunc(altura_minimizada/2), 300);

		}

} // function responde_ao_flip()

function verifica_se_eh_mobile() {

		if (desktop_igual_mobile) {return true;}

		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
				// true for mobile device
				return true;
		}else{
				// false for not mobile device
				return false;
		} // fonte desse if eh o site timhuang

}


function anima(){

		evidente=evidente+delta;
		if (evidente<1)
		{
				evidente=1; 
				animacao--; 
				transition_string="all 0.2s linear";
				if (eh_mobile) 
				{
						document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-jpg").replace("../","");
				}
				else
				{
						document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-id").replace("../","");
				}

				clearInterval(executa_animacao);
				return;
		}

		if (evidente>max_reg)
		{
				evidente=max_reg; 
				animacao--; 
				transition_string="all 0.2s linear";
				if (eh_mobile) 
				{
						document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-jpg").replace("../","");
				}
				else
				{		
						document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-id").replace("../","");
				}
				clearInterval(executa_animacao);
				return;
		}

		mostra(evidente,Math.trunc(altura_minimizada/2),300);

} // function anima()


function keyDownPaleta(e) {
		if (animacao>0) {return;}
		var keyCode = e.keyCode;

		var code = (keyCode ? keyCode : e.which);
		if (code == 35) {
		        e.preventDefault();
				animacao++;
				delta=1;
				transition_string="all 0.2s ease";
				executa_animacao=setInterval(anima,10);
				code=0;
				return;            
		}
		if (code == 36) {
		        e.preventDefault();
				animacao++;
				delta=-1;
				code=0;
				transition_string="all 0.2s ease";
				executa_animacao=setInterval(anima,10);
				return;
		}


		delta=0;

		if (keyCode==40) {e.preventDefault();delta=1;} 
		if (keyCode==38){e.preventDefault();delta=-1;}

		evidente=evidente+delta;
		if (evidente<1){evidente=1;}
		if (evidente>max_reg){evidente=max_reg;}
		mostra(evidente,Math.trunc(altura_minimizada/2),300);
}

function mostra(evidente, meio, max){
var total_barras=document.getElementsByClassName("barras").length; // eh a mesma definicao para numdiv. Reproduzi aqui para nao atrapalhar o algoritmo principal (teria que puxar de lah e isso exigiria mais custos com testes 


		document.getElementById("indice_instancia").innerHTML=evidente+"/" + total_barras;
		var meio_lateral=Math.trunc(document.getElementById("paleta_instancia").clientWidth/2);

		max_height_search_box=altura_minimizada/3;
		if (evidente>4) {
				document.getElementById("search_box_instancia").style.opacity=1.5/((evidente)*1.5);	
		
			//document.getElementById("search_box_instancia").style.opacity=0;	
			// verificar se é o caso de usar visibility ou opacity=0, porque pode ser que perca os dados do input:text quando faz visibility=hidden (não deveria)
		} else 
		{
				document.getElementById("search_box_instancia").style.opacity=1.5/((evidente)*1.5);	
				document.getElementById("search_box_instancia").style.fontSize=document.getElementById("table_1").style.fontSize.replace("px","") * 1.4;
				document.getElementById("search_box_instancia").style.visibility="visible";
				var altura_search=max_height_search_box*(Math.cos((evidente-1)*Math.PI/8 ));

				document.getElementById("search_box_instancia").style.height=Math.trunc(altura_search)+"px";
				document.getElementById("search_box_instancia").style.width=Math.trunc(altura_search * inv_razao_aspecto)+"px";
				document.getElementById("search_box_instancia").style.top="3%";
				document.getElementById("search_box_instancia").style.left=meio_lateral - Math.trunc(altura_search * inv_razao_aspecto/2) + "px";
		}

		document.getElementById("mostra_pdf").width=document.getElementById("conteudo").clientWidth;
		document.getElementById("mostra_pdf").height=document.body.clientHeight+"px";
		//document.getElementById("conteudo").innerHTML=document.getElementById("conteudo").innerHTML+"<br>"+document.getElementById("but_"+evidente).getAttribute("data-id");
		if (animacao==0) 
		{

				if (eh_mobile) 
				{
						document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-jpg").replace("../","");
				}
				else
				{
						document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-id").replace("../","");
				}
		}


		var numdiv=document.getElementsByClassName("barras").length;
		max=numdiv;
		var largura = document.getElementById("paleta_instancia").clientWidth;
		console.log("largura: "+largura);
		var larg_percent=1;
		max_reg=max;
		console.log("max_reg: "+max_reg);

		console.log("evidente: "+evidente);
		document.getElementById(evidente).style.display="block";
		document.getElementById(evidente).style.position="absolute";
		document.getElementById(evidente).align="center";
		document.getElementById(evidente).style.left=Math.trunc((largura-largura*larg_percent)/2)+"px";
		document.getElementById(evidente).style.height=larg_primeiro+"px";
		document.getElementById(evidente).style.width=Math.trunc(largura*larg_percent)+"px";

		document.getElementById(evidente).style.top=Math.trunc(meio-larg_primeiro/2)+"px";
		document.getElementById(evidente).style.border="1px solid black";

		if (velho_evidente>0) {

				document.getElementById(velho_evidente).style.backgroundColor="#F2C72B";
				document.getElementById(velho_evidente).style.color="black";
		}

		document.getElementById(evidente).style.color="white";
		document.getElementById(evidente).style.backgroundColor="#42A0FF";  /* darkblue xxxx */
		velho_evidente=evidente;

		// teste de Children
		var c = document.getElementsByName("img_"+evidente);
		console.log("matriz c -> ",c);
		var j;
		for (j = 0; j < c.length; j++) {
				c[j].style.height=larg_primeiro+"px";
		}

		//

		document.getElementById("table_"+evidente).style.fontSize=Math.trunc(larg_primeiro/divisao)+"px";


		var top_antes;
		var alt_antes;
		var top_depois;
		var top_depois_menos_meio;
		var razao;
		var arco;
		var cos;
		var alt_depois;
		var bottom;
		console.log(largura);
		var i=evidente;
		do {
				i++;

				document.getElementById(i).style.display="block";
				document.getElementById(i).style.position="absolute";
				document.getElementById(i).align="center";
				document.getElementById(i).style.transition=transition_string;

				top_antes=(+document.getElementById(i-1).style.top.replace('px',''));
				alt_antes=(+document.getElementById(i-1).style.height.replace('px',''));
				top_depois=(top_antes)+(alt_antes);

				document.getElementById(i).style.top=top_depois+"px";

				top_depois_menos_meio=(top_depois)-meio;
				razao=top_depois_menos_meio/(meio);
				arco=Math.asin(razao);
				cos=Math.cos(arco);
				alt_depois=(larg_primeiro)*cos;
				bottom=(alt_depois+top_depois);
				document.getElementById(i).style.width=Math.trunc(largura*larg_percent*cos)+"px";
				document.getElementById(i).style.left=Math.trunc((largura-(largura*larg_percent*cos))/2)+"px";

				document.getElementById(i).style.height=alt_depois+"px";
				// teste de Children
				var c = document.getElementsByName("img_"+i);
				var j;
				for (j = 0; j < c.length; j++) {
						c[j].style.height=alt_depois+"px";
				}

				//
				document.getElementById("table_"+i).style.fontSize=Math.trunc(alt_depois/divisao)+"px";


				console.log("i>"+i+" arco="+arco+" bottom:"+bottom+" meio*2:"+meio*2+" evi:"+evidente);
		}
		while ((i < max) && (bottom<(meio*2)) && (alt_depois>alt_corte)); 

		if (i<max){document.getElementById(i+1).style.display="none"; console.log("retira: "+(+i+1));}


		var i=evidente;
		if (i>1){
				do {
						i--;
						document.getElementById(i).style.display="block";
						document.getElementById(i).style.position="absolute";
						document.getElementById(i).align="center";

						top_antes=(+document.getElementById(i+1).style.top.replace('px',''));
						alt_antes=(+document.getElementById(i+1).style.height.replace('px',''));
						top_antes_menos_meio=top_antes-meio;

						razao=(top_antes_menos_meio)/(meio);
						arco=Math.asin(razao);
						cos=Math.cos(arco);
						alt_depois=(alt_antes)*cos;
						document.getElementById(i).style.top=(+top_antes)-(+alt_depois)+"px";

						document.getElementById(i).style.width=Math.trunc(largura*larg_percent*cos)+"px";
						document.getElementById(i).style.left=Math.trunc((largura-(largura*larg_percent*cos))/2)+"px";


						top_depois=(document.getElementById(i).style.top.replace('px',''));
						topo=(top_depois);

						document.getElementById(i).style.height=alt_depois+"px";
						// teste de Children
						var c = document.getElementsByName("img_"+i);
						var j;
						for (j = 0; j < c.length; j++) {
								c[j].style.height=alt_depois+"px";
						}

						//

						document.getElementById("table_"+i).style.fontSize=Math.trunc(alt_depois/divisao)+"px";


						console.log("i>"+i+" arco="+arco+" bottom:"+bottom+" meio*2:"+meio*2+" evi: "+evidente);
				}
				while ((i > 0) && (topo>0) && (alt_depois>alt_corte)); 

		}

						document.getElementById("search_box_instancia").style.fontSize=document.getElementById("table_1").style.fontSize.replace("px","")*1.4;
} // function mostra() 

function taca(){ // para debug
		if (delta < 0){
				console.log("DOWN");
		}else if (delta > 0){
				console.log("UP");
		}


}

function getWheelDelta(event) {

		try {
				return event.wheelDelta || -event.detail || event.deltaY || null;
		}
		catch (erro) {alert(erro);}

}

function trata_wheel(event){
  event.preventDefault();

		var girada=getWheelDelta(event);

		if (girada>0){
				//delta = event.wheelDelta;
				delta=1;
		}else{
				//delta = -1 * event.deltaY;
				delta=(-1);
		}

		console.log("girou botao -> "+girada+" delta: "+delta);

		evidente=evidente+delta;
		if (evidente<1){evidente=1;}
		if (evidente>max_reg){evidente=max_reg;}
		mostra(evidente,Math.trunc(altura_minimizada/2),300);

}


function getDocHeight() {
		var D = document;
		return Math.max(
						Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
						Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
						Math.max(D.body.clientHeight, D.documentElement.clientHeight)
					   );
}





</script>

<?php


#if(isset($_GET["banco"])){
#  $banco = $_GET["banco"];
#}
require('./su_admin/super_config_php.cnf');
echo "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
<title>Plataforma Potlatch</title>
<link rel='stylesheet' href='su_css/super_portlet.css' type='text/css'>
</head>
<body onload='conta_disparo=1; flag_carregando=0; carrega_dados(\"nome\",\"\");'>
<div id='conteudo'>
<iframe id='mostra_pdf' src='' width='300' height='375'></iframe>
</div>

<div id='paleta_instancia' class='paleta'>

<div id='aviso_carregando' class='avisos'>Carregando...</div>

<div id='indice_instancia' class='indice'></div>

<div id='search_box_instancia' class='search_box'>
<span id='titulo_search_box'><b>Busca:</b></span>

<table class='padrao'>
	<tr>
		<th  class='padrao'>
		Por título
		</th>
		<th  class='padrao'>
		Por cidade
		</th>
		<th  class='padrao'>
		Por palavra
		</th>
	</tr>
	<tr>
		<td  class='padrao'>
		<input id='search_nome' type='text' placeholder='Entre título aqui' />
		</td>
		<td  class='padrao'>
		<input id='search_cidade'  type='text' placeholder='Entre cidade aqui' />
		</td>
		<td  class='padrao'>
		<input  type='text' placeholder='Entre palavra aqui'/>

		</td>
	</tr>
	<tr>
		<td  class='padrao'>
		<input type='button' value='busca' onclick='carrega_dados(\"nome\",document.getElementById(\"search_nome\").value);'>
		</td>
		<td  class='padrao'>
		<input type='button' value='busca'>
		</td>
		<td  class='padrao'>
		<input type='button' value='busca'>
		</td>
	</tr>
	<tr>
		<td class='dicas' colspan='3'>
		Dicas: nesse quadro você pode buscar documentos pelo título, pela cidade, por palavras chaves e por tipo de documento.<br>
		Basta digitar as palavras nos campos acima e observar os dados serem carregados na lista abaixo.<br>
		Para inspecionar os documentos vocẽ pode usar o mouse ou o teclado.<br>
		Para usar o teclado, clique neste quadro e será possível usar <i>setas</i>, <i>home</i>, <i>end</i>.
		No mouse você pode usar a rodinha para girar pelos documentos.
		
		</td>
	</tr>
</table>


</div>

";



echo "</div>
</body>
<script>
var banco_de_dados='".$banco."';
var tamanho=0.5;

var body = document.body,
	html = document.documentElement;

var altura_testando=document.getElementById('paleta_instancia').clientHeight;

console.log(' get ->'+getDocHeight() + ' styleheight: '+ altura_testando);
var altura_minimizada = parseInt(altura_testando);

var i;
var eh_mobile; // true se for mobile. false se for desktop
var na_vertical; // true se a tela estiver na vertical e false se estiver na horizontal
var conta_flip=0; // conta o numero de resizes (no primeiro nao faz sentido reload();)
var transition_string= 'all 0.2s linear';
var inv_razao_aspecto=2.5; // razao de aspecto do search box invertida. Ou seja é o valore de largura/altura;
var max_height_search_box=30; // medido em percentual %


const retamanho = new ResizeObserver(entries => { // executado quando começa o programa e quando ajusta o zoom da tela
        for (let entry of entries) {
			responde_ao_flip();
			conta_flip++;
        }
});


retamanho.observe(document.body);
eh_mobile=verifica_se_eh_mobile();


</script>


</html>";

?>

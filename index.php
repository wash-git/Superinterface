<?php
?>

<script type="text/javascript">
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
	document.body.addEventListener('wheel', trata_wheel, true); // O evento wheel é acionado quando o usuário gira a roda do mouse
	document.body.addEventListener('touchstart', function(e1){zeroTouch=e1.changedTouches[0].pageY;}); // toque em telas sensíveis ao toque
	document.body.addEventListener('touchmove', function(e2){ // movimentos com os dedos em telas sensíveis ao toque
		if (animacao_touch>0) {return;}
		animacao_touch++;
		if (e2.changedTouches[0].pageY-zeroTouch>0){delta=-1;} else {delta=1;};
		evidente=evidente+delta;
		setTimeout(function(){animacao_touch=0;},100); // segura um tempo antes de permitir uma nova acao, senao ele pula varias barras no touch
		if (evidente<1){evidente=1;}
		if (evidente>max_reg){evidente=max_reg;}
		mostra(evidente,Math.trunc(altura_minimizada/2),300);
	});
	document.body.addEventListener("keydown", keyDownPaleta, false); // A função keyDownPaleta é acionada quando o usuário pressiona 
																	 // uma tecla no campo de entrada
	document.getElementById("search_nome").addEventListener('keyup', // Transforma o caracter digitado para maiúsculo
			function (e10){
						var keyCode = e10.keyCode;
						var code=keyCode;
						//var code = (keyCode ? keyCode : e10.which);
						var itz= document.getElementById("search_nome").value;
						if (!isArrowHomeEnd(code)) {keyBusca("nome");}
			}
	);
	document.getElementById("search_cidade").addEventListener('keyup',
		    function (e11){
						var keyCode = e11.keyCode;
						var code = (keyCode ? keyCode : e11.which);
						var itz= document.getElementById("search_cidade").value;
						if (!isArrowHomeEnd(code) && large_enough(itz)) {keyBusca("cidade");}
						else { if (!large_enough(itz)){limpa_barras();}}
			}
	);
	document.getElementById("search_cidade").addEventListener('blur',
			// blur: ao sair do campo de entrada, é acionada uma função que transforma o texto de entrada em maiúsculas.
		    function (e12){
						document.getElementById("search_cidade").value="";
						keyBusca("nome");
			}
	);
	document.getElementById("search_instituicao").addEventListener('keyup',
			function (e13){
						var keyCode = e13.keyCode;
						var code = (keyCode ? keyCode : e13.which);
						var itz= document.getElementById("search_instituicao").value;
						if (!isArrowHomeEnd(code) && large_enough(itz)) {keyBusca("instituicao");}
						else { if (!large_enough(itz)){limpa_barras();}}
			}
	);
	document.getElementById("search_instituicao").addEventListener('blur',
			// blur: ao sair do campo de entrada, é acionada uma função que transforma o texto de entrada em maiúsculas.
			function (e14){
						document.getElementById("search_instituicao").value="";
						keyBusca("nome");
			}
	);

},false);
document.body.style.zoom = "1.0";

function large_enough(str){ 
	// verifica se o string é grande o suficiente para evitar buscas demoradas
	return str.replace(/ /g,"").length>2;
} //fim

function isArrowHomeEnd(asc){ 
	// verifica se o ascii é de arrow, home ou end para evitar disparar buscas quando está navegando e 
	// o text box está com foco (porque nesse caso o keyup é disparado e isso gera uma busca demorada,
	// o que não é desejável)
	var boole= asc==35 || asc==36 || asc==40 || asc==38;
	return boole;
}

function keyBusca(tipo) { 
	// trata os eventos de keyup nos text de busca
	if (flag_carregando==0){
		flag_carregando=1; 
		aviso_carregando=setInterval
			(
				function(){
					toggle_cor=!toggle_cor;
					document.getElementById("aviso_carregando").style.visibility = "visible"; 
					document.getElementById("aviso_carregando").innerText="Carregando "+tipo+"...";
					document.getElementById("aviso_carregando").style.backgroundColor=(toggle_cor==1 ? "yellow" : "red");
					document.getElementById("aviso_carregando").style.top=  parseInt(document.getElementById("search_box_instancia").style.top.replace("px","")) + parseInt(document.getElementById("search_box_instancia").style.height.replace("px","")) -  	parseInt(document.getElementById("aviso_carregando").clientHeight) + "px";
					document.getElementById("aviso_carregando").style.left=Math.trunc(document.getElementById("paleta_instancia").clientWidth/2-parseInt(document.getElementById("aviso_carregando").clientWidth)/2)+"px";
					if (flag_carregando==0) {
						document.getElementById("aviso_carregando").style.visibility = "hidden"; 
						clearInterval(aviso_carregando);
					}  
				},200);   
		if (conta_disparo==0) {
			conta_disparo++;  // conta o número de disparos de carrega que estão esperando para ocorrer via setTimeout
			timeoutId.push(
				setTimeout(
					function(){
						var itz=document.getElementById("search_"+tipo).value;
						if (tipo=="cidade")	{
								if (large_enough(itz)){carrega_dados(tipo,document.getElementById("search_"+tipo).value);}
								else {conta_disparo--; flag_carregando=0;}
						}			
						if (tipo=="instituicao")	{
								if (large_enough(itz)){carrega_dados(tipo,document.getElementById("search_"+tipo).value);}
								else {conta_disparo--; flag_carregando=0;}
						}			
						if (tipo=="nome"){carrega_dados(tipo,document.getElementById("search_"+tipo).value);}
					},1000
			)
			);
		}
			 
	} 
} // fim keyBusca

function carrega_dados(tipo,texto_busca){  // chama o PHP que vai pegar os dados na base e joga na paleta_instancia
	var resposta="";
	if (eh_mobile) {alert("ainda não disponível para mobile");return;}
	else{
		if (tipo=="nome") {var url='su_php/super_search_documentos_pelo_nome.php?banco='+banco_de_dados+'&nome='+texto_busca;}
		if (tipo=="cidade") {var url='su_php/super_search_documentos_pela_cidade.php?banco='+banco_de_dados+'&cidade='+texto_busca;}
		//if (tipo=="palavra") {var url='su_php/super_search_documentos_pela_palavra.php?palavra='+texto_busca;}
		if (tipo=="instituicao") {var url='su_php/super_search_documentos_pela_instituicao.php?banco='+banco_de_dados+'&instituicao='+texto_busca;}
	} 
	var oReq=new XMLHttpRequest();
	oReq.open("GET", url, false);
	oReq.onload = function (e) {
		resposta=oReq.responseText;
		 limpa_barras();
		var itz_HTML=document.getElementById("paleta_instancia").innerHTML;
		var quantidade= document.getElementsByClassName("barras").length;
      	// document.getElementById("paleta_instancia").innerHTML=itz_HTML + resposta;i // esta opção destroi tudo, inclusive os conteúdos dos input  text
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
	if (verifica_se_eh_mobile()){
		if (tela_na_vertical()){
			larg_primeiro=150;
			divisao=5;	
		}
		else{
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
	if (evidente<1){
		evidente=1; 
		animacao--; 
		transition_string="all 0.2s linear";
		if (eh_mobile) {
			document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-jpg").replace("../","");
		}
		else{
			document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-id").replace("../","");
		}
		clearInterval(executa_animacao);
		return;
	}
	if (evidente>max_reg){
		evidente=max_reg; 
		animacao--; 
		transition_string="all 0.2s linear";
		if (eh_mobile) {
			document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-jpg").replace("../","");
		}
		else{		
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
	var total_barras=document.getElementsByClassName("barras").length;  // eh a mesma definicao para numdiv. Reproduzi aqui para nao atrapalhar o algoritmo 
																		// principal (teria que puxar de lah e isso exigiria mais custos com testes 
	document.getElementById("indice_instancia").innerHTML=evidente+"/" + total_barras;
	var meio_lateral=Math.trunc(document.getElementById("paleta_instancia").clientWidth/2);
	max_height_search_box=altura_minimizada/3;
	if (evidente>4) {
		document.getElementById("search_box_instancia").style.opacity=1.5/((evidente)*1.5);	
		//document.getElementById("search_box_instancia").style.opacity=0;	
		// verificar se é o caso de usar visibility ou opacity=0, porque pode ser que perca os dados do input:text quando faz visibility=hidden (não deveria)
	} else {
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
	if (animacao==0) {
		if (eh_mobile) {
			document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-jpg").replace("../","");
		}
		else{
			document.getElementById("mostra_pdf").src=document.getElementById("but_"+evidente).getAttribute("data-id").replace("../","");
		}
	}
	var numdiv=document.getElementsByClassName("barras").length;
	max=numdiv;
	var largura = document.getElementById("paleta_instancia").clientWidth;
	var larg_percent=1;
	max_reg=max;
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
		}
		while ((i > 0) && (topo>0) && (alt_depois>alt_corte)); 
	}
	document.getElementById("search_box_instancia").style.fontSize=document.getElementById("table_1").style.fontSize.replace("px","")*1.4;
} // function mostra() 

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
#require('./su_admin/super_config_php.cnf');
echo "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
<title>Plataforma Potlatch</title>
<link rel='stylesheet' href='su_css/super_portlet.css' type='text/css'>
<link rel='icon' type='image/x-icon' href=\"./su_icons/super_favicon.svg\"/>
</head>
<body onload='conta_disparo=1; flag_carregando=0; carrega_dados(\"nome\",\"\");'>
<div id='conteudo'>
<iframe id='mostra_pdf' src='' width='300' height='375'></iframe>
</div>

<div id='paleta_instancia' class='paleta'>

<div id='aviso_carregando' class='avisos'>Carregando...</div>

<div id='indice_instancia' class='indice'></div>

<div id='search_box_instancia' class='search_box'>
<span id='titulo_search_box'><b>Buscar por:</b></span>

<table class='padrao'>
	<tr>
		<th  class='padrao'>
		Nome Documento
		</th>
		<th  class='padrao'>
		Cidade
		</th>
		<th  class='padrao'>
		Instituição
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
		<input id='search_instituicao'  type='text' placeholder='Entre instituicao aqui'/>
		</td>
	</tr>
	<tr>
		<td  class='padrao'>
		<input type='button' value='Limpar' onclick='carrega_dados(\"nome\",document.getElementById(\"search_nome\").value);'>
		</td>
		<td  class='padrao'>
		<input type='button' value='Limpar'>
		</td>
		<td  class='padrao'>
		<input type='button' value='Limpar'>
		</td>
	</tr>
	<tr>
		<td class='dicas' colspan='3'>
		Dicas: nesse quadro pode-se buscar documentos pelo seu nome, pela cidade, e por instituição.<br>
		Para inspecionar os documentos, use o mouse ou o teclado.<br>
		Para usar o teclado, clique neste quadro e será possível usar <i>setas</i>, <i>home</i>, <i>end</i>.
		No mouse você pode usar a rodinha para girar pelos documentos. Veja mais detalhes no <a href=\"su_docs/super_documentacao.php#manual_usuario\" target=\"_blank\">manual Superinterface</a>.
		</td>
	</tr>
</table>
</div>
";

echo "</div>
</body>
<script type='text/javascript' src='./su_js/super_index2.js'></script>
</html>";

?>


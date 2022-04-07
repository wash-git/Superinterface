
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

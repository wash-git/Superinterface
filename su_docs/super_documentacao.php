<!DOCTYPE html>
<html lang='pt-br'>
<head>
<title>Referência Técnica da Superinterface</title>
<meta charset="utf-8">
<meta name="keywords"  content="Superinterface,Giramundonics,portlet">
<meta name="author"    content="Antonio Albuquerque,Vitor Mammana">
<link rel='stylesheet' href='../su_css/super_documentacao.css' type='text/css'>
</head>
<body onload="lista_h2()">
<div id="menu">
Superinterface:
</div>

<div id="conteudo">
<h1>Superinterface - Referência Técnica</h1>
<table>
<tr><td>
<img src="./super_wash.jpg" width="400" style="border: 1px solid black"></td>
<td><div class="comentario">
<b>Objetivo</b>
<p></p><p></p>
Descrever as características da solução Superinterface, criando as condições para o usuário instalar e utilizar a solução.
<br \><br \>
A Superinterface visa criar um acervo de documetos PDF sobre uma determinada temática, podendo realizar buscas textuais neste acervo e permitir aos responsáveis
pelo acervo a entrada de metadados e outras informações sobre estes documentos. O objetivo também é estabelecer um instrumento para a busca de dados no acervo, para que o público possa ter a melhor visibilidade sobre os documentos do acervo. 
<p></p>
Este projeto é mais uma iniciativa do <a href="http://wash.net.br" target="_blank">Programa Wash</a> - Workshop Aficionados em Software e Hardware.

<br \><br \>Seja Bem Vind@, e aproveite!!
</div>
</td></tr></table>
<h2 id="consideracoes_iniciais">Considerações Iniciais</h2>
A solução Superinterface constitui de um sistema formado de três blocos distintos:
<dl>
<dt>Blocos Superinterface:</dt>
<dd>a) a plataforma Potlatch: um sistema CRUD (Create, Retrieve, Update & Delete), voltado para a entrada de dados de forma estruturada no banco de dados
localizado no servidor MySQL. A Potlatch não é voltada para o usuário final;</dd>
<dd>b) um visualizador de dados: Giramundônics.  É destinado ao usuário final, ermitindo a visualização do acervo da Superinterface e realizar busca de dados.
Não tem ferramentas de entrada de dados. Não é um CRUD.</dd>
<dd>c) uma ferramenta de manutenção ou backoffice: dá acesso a todas as tabelas da Superinterface, peritindo edição das informações.  É um CRUD.</dd>
</dl>

A Superinterface visa criar um acervo de documetos PDF sobre uma determinada temática, podendo realizar buscas textuais neste acervo e permitir aos responsáveis pela criação do acervo a entrada de metadados e outras informações sobre estes documentos. O objetivo também é estabelecer um instrumento para a busca de dados no acervo, para que o público possa ter a melhor visibilidade sobre os documentos do acervo.

Dentre as informações que podem ser disponibilizados para cada arquivo através da Superinterface, estão:
<dl>
<dt>Informações:</dt>
<dd>- instituições envolvida;</dd>
<dd>- autoridades;</dd>
<dd>- empresas e entidades;</dd>
<dd>- valores financeiros envolvidos;</dd>
<dd>- distribuição geográfica de valores;</dd>
<dd>- identificação da atuação da sociedade civil;</dd>
<dd>- registro de indicadores (e.g. número de editais, número de participantes, etc)</dd>
</dl>

O principal aspecto que foi perseguido no desenvolvimento da solução foi a automatização da coleta das informações:
<ul>
<li>Nomes de Cidades</li>
<li>Nomes Próprios</li>
<li>Nomes de Instituições</li>
<li>CPFs e CNPJs de beneficiários</li>
</ul>

Os dados estão organizados por documento e, sempre que possível, geo-localizados. Várias ferramentas de automatização estão sendo avaliadas e utilizadas para que a Superinterface consiga fazer essa coleta de dados, inclusive:
<dl>
<dt>Ferramentas:</dt>
<dd>* ferramentas de tratamento de texto convencionais (sed, regexp, grep, awk, head, tail, cat, entre outras)</dd>
<dd>* ferramentas de análise de linguagem natural (Unitex)</dd>
<dd>* ferramentas baseadas em algoritmo genético (desenvolvimento próprio)</dd>
</dl>

Destas 3 abordagens, a mais madura é a primeira e já vem sendo usada amplamente para gerar parte dos metadados da plataforma Superinterface.

<h2 id="instalacao">Instalação</h2>
Para realizar a instalação da Superinterface, proceda da seguinte forma:
<ol>
<li><h3 id="preparacao_ambiente">Preparação do Ambiente</h3>
<ol style="list-style-type:lower-alpha">
<li>Sistema Operacional, linguagens e outros aspectos gerais:</li>
GNU/LINUX-Debian 9 ou superior<br />
Interpretador de comandos Bash (#!/bin/bash)<br />
LAMP (LINUX-APACHE-MYSQL-PHP)<br /> 
Obs:PHP 7.0 ou superior)<br />
<p></p>
<li>Módulos Apache necessários:</li>
Módulo rewrite<br />
Módulo mpm-itk<br />
Módulo php-mysql<br />
<p></p>
<li>Virtual Host:</li>
Um bom exemplo de uma configuração de Virtual Host para esta aplicação da Superinterface está mostrado abaixo, o qual o criaremos este arquivo na pasta /etc/apache2/sites-available com nome super.conf:
<pre>
&lt;VirtualHost *:80&gt;
   ServerName     exemplo.br
   ServerAlias    www.exemplo.br
   ServerAdmin    webmaster@exemplo.br
   DocumentRoot   "/var/www/html/host1"
   &lt;Directory "/var/www/html/host1"&gt;
      &lt;IfModule mpm_itk_module&gt;
         # to run each of your vhost under a separate uid and gid 
         AssignUserId   web1  web1
      &lt;/IfModule&gt;
      # proibir retornar listagem do diretório
      Options	-Indexes
      # controle de acesso das requisições aos arquivos:
      Require all granted
      Options   -SymLinksIfOwnerMatch
      AllowOverride All
      &lt;IfModule mod_rewrite.c&gt;
         RewriteEngine on
         RewriteBase /
         RewriteRule ^su_install/(.*)$ http://exemplo.br/index.php [R=301,L]
         RewriteRule ^su_admin/(.*)$ http://exemplo.br/index.php [R=301,L]
      &lt;/IfModule&gt;
   &lt;/Directory&gt;
   ErrorLog /var/log/apache2/error.log
   LogLevel warn
   CustomLog /var/log/apache2/access.log combined
&lt;/VirtualHost&gt;
</pre>
Observações:
<ul><li> "web1" se refere ao usuário/grupo que você irá adotar como proprietário dos arquivos da aplicação.  Substitua "web1" pela identificação do usuário/grupo real da sua instalação.</li>
<li> "exemplo.br" se refere a URL da instalação da Superinteface.  Substitua esta referência pela URL verdadeira da sua instalação.</li>
<li>Para que o novo virtual host tenha efeito, não esquecer os dois comandos básicos para o apache:</li>
<pre>
   # a2ensite super.conf
   # /etc/init.d/apache2 reload
</pre>
</ul>
<p></p>
<li>Cron job:
A solução tem um "vigilante" que monitora de tempos em tempos se existem arquivos PDF para serem incorporados ao acervo da Superinterface. Para isto funcionar, crie uma entrada no crontab do usuário da solução da seguinte forma:
<pre>
MAILTO=""
*/1  *  *  *  *  cd /var/www/html/host1/su_install/; ./super_novospdf.sh cron
</pre>
Observações:
<ul><li> no caso exemplificado, o vigilante está sendo ativado a cada 1 minuto.</li>
<li>Comandos para editar e exibir a crontab do usuário:</li>
<pre>
    $ crontab -e
    $ crontab -l
</pre>
</ul></li>
<p></p>
<li>Instalar Mariadb</li>
#apt-get install mariadb-server php-mysql
<p></p>
Criar o banco de dados, usuário e permissões:<br />
MariaDB [(none)]&gt; CREATE DATABASE nome_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci;<br />
MariaDB [(none)]&gt; CREATE USER usuario_bd@localhost IDENTIFIED BY 'senha_usuario_bd';<br />
MariaDB [(none)]&gt; GRANT ALL PRIVILEGES ON nome_bd.* TO 'usuario_bd'@'localhost';<br />
MariaDB [(none)]&gt; flush privileges;<br />
<p></p>
Obs: limite os privilégios do usuário do banco conforme exemplificado nestes comandos.<p></p>
<li>Instalar unoconv</li>
# apt-get install unoconv python3-uno libreoffice-core libreoffice-common libreoffice-calc- libreoffice-draw- libreoffice-math- libreoffice-impress- x11-xserver-utils- xdg-utils-
<p></p>
Obs: no comando acima, algumas bibliotecas tiveram inibidas suas instalações por não se fazer necessárias a esta aplicação, já que mão utilizaremos o LibreOffice no módulo gráfico.  Para uma instalação numa máquina com interface gráfica e uso do LibreOffice, instalar o unoconv sem a necessidade de inibições (apt-get install unoconv).
<p></p>
<li>Instalar também:</li>
# apt-get install figlet cowsay detox imagemagick php-imagick php-common poppler-utils qpdf<br />
No ambiente Debian/linux, pode ainda se fazer necessário a criação de um link simbólico:
<pre># ln -s /usr/games/cowsay  /usr/bin/cowsay</pre>
<li>Configurar ImageMagick</li>
Inserir no arquivo  /etc/ImageMagick-6/policy.xml, se ainda não existir esta linha de configuração, a seguinte permissão:
<pre>
&lt;policy domain="coder" rights="read | write" pattern="PDF" /&gt;</pre>
</ol></li>
<p></p><br />

<li><h3 id="preparacao_scripts">Preparação dos Scripts</h3>
<ol style="list-style-type:lower-alpha">
<li>Todo código está disponível no GitHub, bastando baixar a <a href="https://github.com/wash-git/Superinterface">última release da aplicação Superinterface</a></li>.
<li>Evite fazer a instalação da aplicação como usuário root. Deve-se realizar todas instalação do código da aplicação Superinterface como um usuário normal, sem prerrogativas de administrador.</li>
<li> Desempacote a aplicação na raiz (document root) do virtual host.  Para isto, utilize um dos seguintes comandos dependendo do pacote baixado (tar.gz
ou zip):</li><br />
<pre>
..../host1$  tar -xvf Superinterface-1.0.tar.gz
..../host1$  unzip Superinterface-1.0.zip
</pre>
Obs:  no exemplo acima, 1.0 se refere a versão da aplicação.  Verifique a versão baixada para fazer a indicação do comando de forma correta.
<li>Após desempacotar a aplicação, as seguintes pastas e arquivos deverão estar presentes na raiz do virtual host:</li>
<p></p><pre>
.../host1/
	su_admin/
	su_css/
	su_docs/
	su_exemplos_tabelas/
	su_icons/
	su_install/
	su_php/
	index.php
	LICENSE
	README.md
</pre><p></p>
obs:<br \>
a) Em especial, a pasta su_install conterá os arquivos necessários à instalação da Superinterface<br />
b) O arquivo com a documentação técnica da Superinterface (super_documentacao.php) poderá ser acessado via navegador da seguinte forma:<br />
http://exemplo.br/su_docs/super_documentacao.php<br />
<p></p>
<li>Na pasta su_install, alterar as propriedades dos seguintes arquivos conforme mostrado abaixo:</li>
<pre>
$  chmod 600 super_config.cnf
$  chmod 750 super_install.sh
$  chmod 750 super_novospdf.sh
</pre>
<p></p>
<li>Abrir o aquivo super_config.cnf (que está na pasta su_install/) e fornecer as seguintes informações:</li>
<dl>
<dt>Informações:</dt>
<dd>- nome da base de dados</dd>
<dd>- usuário da base de dados</dd>
<dd>- senha do usuário para acessar a base de dados</dd>
<dd>- indicação do dominio onde estará funcionando a Superinterface</dd>
</dl>
Obs: por segurança, não é recomendado que o usuário da aplicação tenha privilégios de criação de base de dados. 
<p></p>
<li>Duas possibilidades de instalação:<br />
A instalação pode ser realizada de duas formas:
<ol><li>apenas gerando as tabelas padrão da Superinterface;</li>
<li>gerando as tabelas padrão da Superinterface junto com tabelas de uma aplicação do usuário.</li></ol></li><br />
O procedimento padrão de instalação, após desempacotar a aplicação, é seguir o primeiro caso: gerar apenas as tabelas da Superinterface. Isso se deve ao fato de não ser encontrado na pasta su_install um arquivo de nome super_tab_aplicacao.sql.<br />
<br />
Caso exista este arquivo super_tab_aplicacao.sql, os comandos SQL deste arquivo serão executados logo após a geração das tabelas padrão da Superinterface, caracterizando a segundo opção da instalação. Todas as tabelas serão geradas em uma única base de dados.<br /><br />
<strong>Dica:</strong> na pasta su_exemplos_tabelas/ existem arquivos SQL exemplos de aplicação de usuários.  Se desejar realizar um teste, copie um dos arquivos para a pasta su_install/, renomeando o arquivo escolhido para super_tab_aplicacao.sql. Para construir seu arquivo SQL de aplicação, observe a estrutura desses arquivos SQL exemplos e faça algo parecido.<br />
<p></p>
<li>Realizar a instalação da aplicação
<pre>
su_install$ ./super_install.sh
</pre>
Obs: acompanhe o log da instalação através do arquivo super_logshell.log que estará na pasta su_logs/<p></p>
Se a instalação foi realizada com sucesso, ao seu final terá sido gerada pastas adicionais necessárias ao funcionamento da solução. Deverão
existir as seguintes pastas:
<pre>
drwxr-----  web1 web1  su_admin
drwxr-----  web1 web1  su_autophp
drwxr-----  web1 web1  su_css
drwxr.....  web1 web1  su_docs
drwxr.....  web1 web1  su_exemplos_tabelas
drwxr-----  web1 web1  su_icons
drwxr-----  web1 web1  su_imagens
drwxr-----  web1 web1  su_install
drwxr-----  web1 web1  su_logs
drwxr-----  web1 web1  su_pdfuploads
drwxr-----  web1 web1  su_php
drwxr-----  web1 web1  su_quarentine
drwxr-----  web1 web1  su_work
</pre>
<dl>
  <dt>Observações</dt>
  <dd><strong>* su_admin:</strong> pasta com os arquivos de controle das funções de administração da Superinterface.</dd>
  <dd><strong>* su_autophp:</strong> pasta que contém os arquivos PHP e HTML gerados automaticamente pela SuperInterface</dd>
  <dd><strong>* su_css:</strong> pasta com os arquivos de estilos da Superinterface.</dd>
  <dd><strong>* su_docs:</strong> pasta com os arquivos relativos a documentação da Superinterface.</dd>
  <dd><strong>* su_exemplos_tabelas:</strong> pasta com exemplos de arquivos SQL que podem ser instalados em conjunto com as tabelas padrão da Superinterface.</dd>
  <dd><strong>* su_icons:</strong> pasta com imagens utilizadas em páginas da Superinterface.</dd>
  <dd><strong>* su_logs:</strong> pasta com os logs de todas as operações da solução, desde o momento da instalação até o presente momento. A pasta também será utilizada para guardar arquivos temporários necessários ao funcionamento da aplicação.</dd>
  <dd><strong>* su_imagens:</strong> pasta onde estarão guardados os arquivos PDF pertencentes ao acervo da Superinterface, juntamente com sua imagem jpg, versão texto puro e outras versões necessárias.</dd>
  <dd><strong>* su_install:</strong> pasta com os arquivos de configuração, arquivos SQL com informações iniciais de preenchimento de tabelas e outros arquivos necessários à instalação da Superinterface, além dos scripts shell necessários ao seu funcionamento.</dd> 
  <dd><strong>* su_pdfuploads:</strong> pasta para onde serão direcionados os arquivos PDF após seu upload pelo usuário, com objetivo de fazer incorporações ao acervo da aplicação Superinterface.  A execução deste processo de incorporação de novos documentos PDF ao acervo estará sob responsabilidade do vigilante (ativado pelo cron).</dd>
  <dd><strong>* su_php:</strong> pasta com arquivos PHP referente as funções de administração da Superinterface.</dd>
  <dd><strong>* su_primitivo:</strong> pasta onde serão guardados os arquivos originais não PDF que forem submitidos ao acerco da aplicação</dd> 
  <dd><strong>* su_quarentine:</strong> pasta para onde serão destinados os arquivos PDF que apresentarem problemas para serem incorporados ao acervo, ou quando  houver a tentativa de incorporação de arquivo que já pertença ao acervo.</dd>
  <dd><strong>* su_work:</strong> pasta auxiliar para tratamento dos arquivos PDF disponibilizados pelo usuário.</dd> 
  <dd>* Neste momento, já se pode verificar as páginas iniciais da aplicação funcionando:
	<ul class="list-circle">
	<li>obs: no momento da instalação, as credenciais "usuário/senha" de acesso ao Portal de Administração é "admin/admin", respectivamente.  É aconselhável, por segurança, trocar estas credenciais logo no primeiro acesso à aplicação Superinterface.</li>
  </ul></dd>
</dl>
<p></p></li>
<li>Reinstalar a Superinterface<br />
A Superinterface pode ser reinstalada a qualquer momento sem maiores burocracias.  Lembrando que toda base de dados será apagada. Para isso, basta executar novamente o comando:
<pre>
su_install$ ./super_install.sh
</pre>
Este procedimento limpa as tabelas existentes na base, recria as tabelas e executa o script de instalação da mesma forma como fora executado na primeira vez.
</li>
</ol>
</li>
</ol>
<p></p>
<p></p>
<h2 id="manual_usuario">Manual do Usuário</h2>
Após instalação da solução, existem três possibilidades ao usuário (considerando a instalação na URL www.exemplo.br):
<table>
<tr><th>Função</th><th style="width:70%">URL</th></tr>
<tr><td>Giramundonics</td><td>http://www.exemplo.br</td></tr>
<tr><td>Painel de Administração</td><td>http://www.exemplo.br/su_php/super_admin.php</td></tr>
<tr><td>Documentação</td><td>http://www.exemplo.br/su_docs/super_documentacao.php</td></tr>
</table>
Inicialmente, o visualizador Giramundonics não mostrará nenhum arquivo, já que na instalação da Superinterface nenhum arquivo PDF é incorporado ao acervo.
O acesso ao painel de administração se faz através das credenciais admin/admin. Ao abrir o painel, o usuário terá um menu com as seguintes opções:
<pre>
Upload PDF|Giramundonics|BackOffice|Acervo|Quarentena|Usuários|Tabelas|Logs|Status
</pre>
<ul>
<li>Upload PDF: disponibilizar arquivos PDF para compor o acervo de documentos da Superinterface.</li>
<li>Giramundonics: visualizador gráfico dos arquivos pertencentes ao acervo de documentos da Superinterface</li>
<li>BackOffice: interface para edição de metadados dos arquivos pertencente ao acervo da Superinterface. Um CRUD.</li>
<li>Acervo: lista dos arquivos PDF já pertencentes ao acervo da Superinterface.</li>
<li>Quarentena: lista dos arquivos PDF em quarentena (arquivos inconsistentes ou em duplicata)</li>
<li>Usuários: administração de usuários da Superinterface</li>
<li>Tabelas: lista de tabelas geradas automaticamente pela Superinterface</li>
<li>Logs: logs de funcionamento da Superinterface</li>
<li>Status: conjunto de informações sobre a configuração do ambiente de funcionamento da Superinterface</li>
</ul>
<ol>
<li>Upload de arquivos PDF:<br />
Esta facilidade tem uma limitação de tamanho de arquivo por dois fatores: pela configuração do PHP (que pode ser visualizada através da opção "Status" do menu), e também limitado pelo arquivo de configuração de uploads da aplicação (em su_admin/super_config_upload.cnf).</li>
</ol>
</div>
<script>
function lista_h2(){
var i;
$x=document.querySelectorAll('h2,h3');
//$x=document.getElementsByTagName("H2");
menuzinho=document.getElementById("menu");
menuzinho.innerHTML=menuzinho.innerHTML+"<br><br>";
for (i=0; i<$x.length; i++){
menuzinho.innerHTML=menuzinho.innerHTML+"<br><a class='lista_de_conteudo' href='#"+$x[i].id+"'>"+$x[i].innerHTML+"</a><br>";

}
}
</script>
</body>
</html>


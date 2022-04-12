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
<span class="indice"><< Conteúdo >></span>
</div>

<div id="conteudo">
<h1>Superinterface - Referência Técnica</h1>
<table>
<tr><td>
<img src="./super_wash.jpg" width="300"></td>
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
<!--  ******************************************* -->
<h2 id="apresentacao">Apresentação</h2>
A solução Superinterface constitui de um sistema formado de três blocos distintos, conforme exposto a seguir:
<dl>
<dt>Blocos:</dt>
<dd>- a plataforma Potlatch: um sistema CRUD (Create, Retrieve, Update & Delete), voltado para a entrada de dados de forma estruturada no banco de dados localizado no servidor MySQL. A Potlatch não é voltada para o usuário final;</dd><br \>
<dd>- um visualizador de dados: Giramundonics.  É destinado ao usuário final, permitindo a visualização do acervo da Superinterface e realizar busca de informações. Não possui facilidades de entrada de dados. Não é um CRUD.</dd><br \>
<dd>- uma ferramenta de manutenção ou backoffice: dá acesso a todas as tabelas da Superinterface, permitindo edição das informações.  É um CRUD.</dd>
</dl>

A Superinterface visa criar um acervo de documetos PDF sobre uma determinada temática, podendo realizar buscas textuais neste acervo e permitir aos responsáveis pela criação do acervo a entrada de metadados e outras informações sobre estes documentos. O objetivo também é estabelecer um instrumento para a busca de informações no acervo, para que o público possa ter a melhor visibilidade sobre os documentos do acervo.

Dentre as informações que podem ser disponibilizadas para cada arquivo através da Superinterface, estão:
<dl>
<dt>Informações:</dt>
<dd>- instituições envolvida;</dd>
<dd>- autoridades;</dd>
<dd>- cidades envolvidas;</dd>
<dd>- identificação da atuação da sociedade civil.</dd>
</dl>

O principal aspecto que foi perseguido no desenvolvimento da solução foi a automatização da coleta das informações:
<dl>
<dt></dt>
<dd>- nomes de Cidades</dd>
<dd>- nomes Próprios</dd>
<dd>- nomes de Instituições</dd>
</dl>

Os dados estão organizados por documento. Várias ferramentas de automatização estão sendo avaliadas e utilizadas para que a Superinterface consiga fazer essa coleta de dados, inclusive:
<dl>
<dt>Ferramentas:</dt>
<dd>- ferramentas de tratamento de texto convencionais (sed, regexp, grep, awk, head, tail, cat, entre outras)</dd>
<dd>- ferramentas de análise de linguagem natural (Unitex)</dd>
<dd>- ferramentas baseadas em algoritmo genético (desenvolvimento próprio)</dd>
</dl>

Destas 3 abordagens, a mais madura é a primeira e já vem sendo usada amplamente para gerar parte dos metadados da plataforma Superinterface.<p></p>
<!--  ******************************************* -->
<h2 id="instalacao">Manual Instalação</h2>
Para realizar a instalação da Superinterface, proceda da seguinte forma:
<ol>
<!-- ...................... -->
<li><h3 id="preparacao_ambiente">Ambiente</h3>
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
<li>Cron job:<br />
A solução tem um "vigilante" que monitora de tempos em tempos se existem arquivos para serem incorporados ao acervo da Superinterface. A pasta que este vigilante verifica é /su_uploads.  Se existirem arquivos nesta pasta, o vigilante inicia o tratamento destes arquivos.<br />
Para isto funcionar, crie uma entrada no crontab do usuário da aplicação, por exemplo, da seguinte forma:
<pre>
MAILTO=""
*/1  *  *  *  *  cd /var/www/html/host1/su_install/; ./super_novospdf.sh cron
</pre>
Dicas e observações:
<ul><li> no caso exemplificado, o vigilante está sendo ativado a cada 1 minuto.</li>
<li>deve haver um equilíbrio entre a quantidade máxima de arquivos a serem tratados a cada ativação do vigilante (lote de arquivos: parâmetro ajustável no arquivo de configuração da Superinterface) e o intervalo de tempo entre cada ativação do vigilante programado no Cron.  Além disso, o tamanho dos arquivos e a capacidade de processamento da máquina também são fatores críticos.  Para arquivos de tamanho pequenos (até 5 laudas), e ativação do vigilante a cada minuto, trabalhe com um lote máximo de 4 arquivos para serem tratados a cada ativação.</li>
<li>a quantidade deste lote de arquivos, bem como o intervalo de tempo de ativação do vigilante, podem ser alterados a qualquer instante do funcionamento da Superinterface.  Observe na prática o tempo de processamento que estão sendo necessários para proessamento dos arquivos através do arquivo de log.</li> 
<li>comandos úteis para listar e editar a crontab referente a aplicação:</li>
<pre>
    $ crontab -l
    $ crontab -e
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
<li>Instalar aha</li>
# apt-get install aha<br /><p></p>
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
<!-- ...................... -->
<li><h3 id="preparacao_scripts">Scripts</h3>
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
	su_exemplos/
	su_icons/
	su_install/
	su_js/
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
<li>Realizar a instalação da aplicação
<pre>
su_install$ ./super_install.sh
</pre>
Obs: acompanhe o log da instalação através do arquivo super_logshell.log que estará na pasta su_logs/<p></p>
Se a instalação foi realizada com sucesso, ao seu final terá sido gerada pastas adicionais necessárias ao funcionamento da solução. Deverão
existir as seguintes pastas:
<pre>
drwxr-x---  web1 web1  su_admin
drwxr-x---  web1 web1  su_autophp
drwxr-x---  web1 web1  su_css
drwxr-x---  web1 web1  su_docs
drwxr-x---  web1 web1  su_exemplos
drwxr-x---  web1 web1  su_icons
drwxr-x---  web1 web1  su_imagens
drwxr-x---  web1 web1  su_install
drwxr-x---  web1 web1  su_js
drwxr-x---  web1 web1  su_logs
drwxr-x---  web1 web1  su_php
drwxr-x---  web1 web1  su_primitivos
drwxr-x---  web1 web1  su_quarentine
drwxr-x---  web1 web1  su_uploads
drwxr-x---  web1 web1  su_work
</pre>
<dl>
  <dt>Observações</dt>
  <dd><strong>* su_admin:</strong> pasta com os arquivos de controle das funções de administração da Superinterface.</dd>
  <dd><strong>* su_autophp:</strong> pasta que contém os arquivos PHP e HTML gerados automaticamente pela SuperInterface</dd>
  <dd><strong>* su_css:</strong> pasta com os arquivos de estilos da Superinterface.</dd>
  <dd><strong>* su_docs:</strong> pasta com os arquivos relativos a documentação da Superinterface.</dd>
  <dd><strong>* su_exemplos:</strong> pasta com exemplos de arquivos SQL que podem ser instalados em conjunto com as tabelas padrão da Superinterface.</dd>
  <dd><strong>* su_icons:</strong> pasta com imagens utilizadas em páginas da Superinterface.</dd>
  <dd><strong>* su_logs:</strong> pasta com os logs de todas as operações da solução, desde o momento da instalação até o presente momento. A pasta também será utilizada para guardar arquivos temporários necessários ao funcionamento da aplicação.</dd>
  <dd><strong>* su_imagens:</strong> pasta onde estarão guardados os arquivos PDF pertencentes ao acervo da Superinterface, juntamente com sua imagem jpg, versão texto puro e outras versões necessárias.</dd>
  <dd><strong>* su_install:</strong> pasta com os arquivos de configuração, arquivos SQL com informações iniciais de preenchimento de tabelas e outros arquivos necessários à instalação da Superinterface, além dos scripts shell necessários ao seu funcionamento.</dd>
  <dd><strong>* su_js:</strong> pasta com os arquivos javascript.</dd>
  <dd><strong>* su_pdfuploads:</strong> pasta para onde serão direcionados os arquivos PDF após seu upload pelo usuário, com objetivo de fazer incorporações ao acervo da aplicação Superinterface.  A execução deste processo de incorporação de novos documentos PDF ao acervo estará sob responsabilidade do vigilante (ativado pelo cron).</dd>
  <dd><strong>* su_php:</strong> pasta com arquivos PHP referente as funções de administração da Superinterface.</dd>
  <dd><strong>* su_primitivos:</strong> pasta onde serão guardados os arquivos originais que forem submitidos ao acervo, tais como DOCX, DOC, RTF, ODT e TXT.  Os arquivos PDF submetidos ao acervo não são guardados nesta pasta, e sim diretamente na pasta principal do acervo.  Arquivos PDF com problemas na sua estrutura, bem como outros tipos de arquivos, estes serão enviados para pasta da quarentena.</dd> 
  <dd><strong>* su_quarentine:</strong> pasta para onde serão enviados os arquivos PDF que apresentarem problemas para serem incorporados ao acervo, arquivos submetidos em duplicidade ao acervo, bem como tipos de arquivos não aceitos pela Superinterface.</dd>
  <dd><strong>* su_work:</strong> pasta auxiliar para tratamento dos arquivos submetidos ao acervo. É uma pasta que retém os arquivos submetidos ao acervo apenas durante o tempo em que estes estão sendo trabalhados para serem incorporados ao acervo.</dd> 
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
<p></p>
<p></p>
<!-- ...................... -->
<li><h3 id="tabelasibge">Tabelas IBGE</h3>
Informações oriundas de tabelas do IBGE serão utilizadas pela Superinterface como fonte de informações primárias para preenchimento das suas tabelas.
<ol style="list-style-type:lower-alpha">

<li>Códigos dos Países</li>
O IBGE disponibiliza um aquivo com códigos e abreviações de países e territórios do mundo. Esse arquivo pode ser baixado de <a href="https://ftp.ibge.gov.br/Registro_Civil/Codigos_dos_paises/paises_e_territorios_codigos_e_abreviacoes.xls">Códigos dos países</a>.
<li>Códigos dos Estados Brasileiros</li>
O código dos Estados brasileiros está definido pelo IBGE, conforme pode-se verificar em <a href="https://www.ibge.gov.br/explica/codigos-dos-municipios.php" target="_blank">Código dos Estados brasileiros</a>
<li>Códigos dos Municípios Brasileiros</li>
O IBGE disponibiliza um aquivo com os códigos de identificação dos municípios brasileiros. Esse arquivo pode ser baixado de <a href="https://www.ibge.gov.br/explica/codigos-dos-municipios.php" target="_blank">Tabela de Códigos de Municípios do IBGE</a>.
</ol>
</li>
<!-- ...................... -->
<li><h3 id="tabelasexternas">Tabelas Externas</h3>
Existem duas possibilidades de instalação da Superinterface:<br />
<ol style="list-style-type:lower-alpha">
<li>apenas gerando as tabelas padrão da Superinterface;</li>
<li>gerando as tabelas padrão da Superinterface junto com tabelas necessárias à uma aplicação do usuário.</li>
</ol><br />
O procedimento mais comum de instalação da Superintrface é seguir o primeiro caso: gerar apenas as tabelas padrão da Superinterface. Isso é feito automaticamente pelo script de instalação caso não seja encontrado na pasta /su_install um arquivo de nome super_tab_aplicacao.sql.</li>
<br />
Caso exista este arquivo super_tab_aplicacao.sql, os comandos SQL deste arquivo serão executados logo após a geração das tabelas padrão da Superinterface, que é o caso do segundo método da instalação. Todas as tabelas serão geradas em uma única base de dados.<br /><br />
<strong>Dica:</strong> na pasta su_exemplos/ existem arquivos SQL exemplos de aplicação de usuários.  Se desejar realizar um teste, copie um dos arquivos para a pasta su_install/, renomeando o arquivo escolhido para super_tab_aplicacao.sql. Para construir seu arquivo SQL de aplicação, observe a estrutura desses arquivos SQL exemplos e faça algo parecido.<br />
<p></p>
</li>
<!-- ...................... -->
<li><h3 id="verbetes">Verbetes para Buscas</h3>
Para a Superinterface possibilitar ao usuário a facilidade de busca de verbetes nos conteúdos dos arquivos, é necessário definir o seu vocabulário controlado. Existem duas fontes de dados que o administrador da Superinterface deve fornecer, as quais já vêm fornecidas inicialmente quando se baixa e instala a solução:<p></p>
<table>
<tr><th>Informação</th><th style="width:70%">Descrição</th></tr>
<tr><td>Cidades</td><td>Através do arquivo:     su_install/super_insere_cidades.sql</td></tr>
<tr><td>Instituições</td><td>Através do arquivo:     su_install/super_instituicoes.csv</td></tr>
</table><p></p>
Estes arquivos podem (e devem) ser alterados no momento da instalação da solução, possibilitando melhor adequar a solução à realidade em que será utilizada.  Apenas deve-se observar a estrutura desses arquivos de forma a mantê-la. 
<p></p>
<ol style="list-style-type:lower-alpha">
<li>Cidades</li>
O IBE fornece uma planilha com a listagem de todos os municipios brasileiros, como pode-se observar na sessão de <a href="https://www.ibge.gov.br/explica/codigos-dos-municipios.php">Códigos dos municípios</a> desta entidade.
<li>Instituições</li>
Para o caso das instituições, a Superinterface fará a importação das informações a partir da leitura de uma planilha. Durante a instalação, já existe uma planilha básica fornecida a título de exemplo e o sistema pode ser instalado utilizando este arquivo. As figuras abaixo mostram uma planilha csv típica de instituições (à esquerda), e a configuração básica deste arquivo (à direita):<p></p>
<div class="img_container">
<img src="./super_csv_tipico.png"  height="82%" class="img_item"  />
<img src="./super_csv_configuracao.png" class="img_item"  />
</div>
<dl>
<dt>Ou seja:</dt>
<dd>- conjunto de caracteres: UTF-8</dd>
<dd>- separação de campos: por vírgula</dd>
<dd>- delimitador de texto: aspas</dd>
</dl>
</ol>
<p></p>
<!-- ...................... -->
<li><h3 id="logs">Registro de Logs</h3>
Todas as atividades batch da Superinterface, inclusive qualquer anormalidade no tratamento do acervo, são registradas em seu arquivo de log de forma a permitir ao usuário administrador o acompanhamento destas atividades. Na verdade, na pasta de logs desta aplicação existem dois arquivo de logs:
<ol style="list-style-type:square">
<li> su_logs/super_logshell.log</li>
<li> su_logs/super_logshell.html</li>
</ol><br />
O segundo arquivo, super_logshell.html, é apenas uma cópia do primeiro arquivo destinado a ser visualizado através da interface administrativa da Superinterface.  Mas seu conteúdo é exatamente igual ao do primeiro arquivo.<br />
A Superinterface realiza a compressão do arquivo de log quando o tamanho deste arquivo atinge um determinado valor predeterminado por configuração.  Para isso, é gerado um arquivo comprimido ".tar", o qual fica guardado na própria pasta de logs.
<p></p>
É muito importante verificar sistematicamente o arquivo de log, certificando que todas as operações estão sendo realizadas sem ocorrências de exceções.<p></p>
Código de cores: para facilitar a visualização das mensagens, estas obedecem um código de cores: (a) na cor branca estão as mensagens informativas, de forma o usuário acompanhar o que fora realizado pela Superinterface; (b) na cor azul, as operações mais críticas que foram realizadas com sucesso; (c) e na cor vermelha, as mensagens de exceções que merecem uma atenção maior do administrador do serviço.
<li><h3 id="troubleshoot">Troubleshoot</h3>
Eventuais anormalidades no tratamento do acervo são registradas em seu arquivo de log (su_logs/super_logshell.log) de forma a permitir ao usuário administrador o acompanhamento e as intervenções de correção necessárias. Recomenda-se o acompanhamento continuado deste arquivo de log por parte do usuário administrador desta aplicação.<p></p>
Durante a instalação, caso se verifique alguma dificuldade e o arquivo de log não tenha o registro completo da situação, execute alternativamente o script abaixo via comando do terminal, e acompanhe as mensagens:<br />
$ ./super_scriptinicial.sh<br /> <br />
Após realizar o diagnóstico do problema e ter solucionado a dificuldade, (re)instale a solução via seu comando padrão:<br />
$ ./super_install.sh<br /><br />
</ol>
</ol>
<!--  ******************************************* -->
<h2 id="manual_usuario">Manual do Usuário</h2>
<ol>
<!-- ...................... -->
<li><h3 id="menuprincipal">Menu Principal</h3></li>
Após instalação da solução, existem três possibilidades ao usuário (considerando a instalação na URL www.exemplo.br):<p></p>
<table>
<tr><th>Função</th><th style="width:70%">URL</th></tr>
<tr><td>Giramundonics</td><td>http://www.exemplo.br</td></tr>
<tr><td>Portal de Administração</td><td>http://www.exemplo.br/su_php/super_admin.php</td></tr>
<tr><td>Documentação</td><td>http://www.exemplo.br/su_docs/super_documentacao.php</td></tr>
</table><p></p>
Inicialmente, o visualizador Giramundonics não mostrará nenhum arquivo, já que na instalação da Superinterface nenhum arquivo está incorporado ao acervo.
O acesso ao Portal de Administração se faz inicialmente através das credenciais admin/admin. Recomenda-se trocar estas credenciais logo no primeiro acesso.<p></p>
Ao abrir o portal, o usuário terá um menu com as seguintes opções:
<pre>
    Upload|Giramundonics|BackOffice|Acervo|Quarentena|Originais|Usuários|Tabelas|Logs|Status|Manual
</pre>
<ol style="list-style-type:square;">
<li>Upload: disponibilizar arquivos para compor o acervo de documentos da Superinterface.</li>
<li>Giramundonics: visualizador gráfico dos arquivos pertencentes ao acervo de documentos da Superinterface</li>
<li>BackOffice: interface para edição de metadados dos arquivos pertencente ao acervo da Superinterface. Um CRUD.</li>
<li>Acervo: lista dos arquivos já pertencentes ao acervo da Superinterface.</li>
<li>Quarentena: lista dos arquivos em quarentena (arquivos inconsistentes, em duplicidade ou tipo não aceito)</li>
<li>Originais: lista de arquivos originais que forem submitidos ao acervo, de tipos aceitos pelo Superintrface, mas não PDF (tais como DOCX, DOC, RTF, ODT e TXT).</li>
<li>Usuários: administração de usuários da Superinterface.</li>
<li>Tabelas: lista de tabelas geradas automaticamente pela Superinterface.</li>
<li>Logs: logs de funcionamento da Superinterface.</li>
<li>Status: conjunto de informações sobre a configuração do ambiente de funcionamento da Superinterface.</li>
<li>Manual: este documento.</li>
</ol>
<!-- ...................... -->
<li><h3 id="uploads">Upload de Arquivos</h3></li>
Os arquivos podem ser submetidos ao acervo da Superinterface a qualquer tempo. Estes devem pertencer a um certo conjunto de tipos de arquivos predeterminados.  Os tipos aceitos estão definidos no arquivo de configuração da Superinterface, onde para cada tipo existe um tratamento específico. Para submeter arquivos ao acervo, existem duas maneiras básicas:
<ol style="list-style-type:square;">
<li>Grande quantidade de arquivos: se você tem acesso direto as pastas da aplicação via ftp ou ssh, copie os arquivos a serem submetidos ao acervo para a pasta /su_uploads.</li>
<li>Alguns poucos arquivos: utilize a interface gráfica da Superinterface, atravé das opção "Uploads" do menu principal.</li>
</ol><p></p>Alguns comportamentos devem ser observados:
<ol style="list-style-type:square;">
<li>Utilizando a opção "Uploads" da interface gráfica da Superinterface, haverá duas limitações referente ao tamanho dos arquivos: pela configuração php.ini do PHP (que pode ser visualizada através da opção "Status" do menu); por limitação da prórpia Superintrface, programada através do arquivo de configuração da aplicação.  As duas limitações podem ser visualizadas através da opção "Status" do menu principal.</li>
<li>Utilizando a opção "Uploads" da interface gráfica da Superinterface, haverá a verificação do tipo de arquivo que está sendo submetido. Somente alguns tipos de arquivos são aceitos pela Superinterface, conforme estabelecido através de seu arquivo de configuração.</li>
<li>Utilizando o acesso via ftp ou ssh diretamente à pasta /su_uploads, as verificações de segurança quanto ao tamanho limite de cada arquivo e quanto ao tipo de arquivo não serão realizadas.  Use esta opção com parcimônia.</li>
</ol>

<li><h3 id="visibilidade">Visibilidade do Acervo</h3></li>
A visibilidade dos arquivos que estão no acervo da Superinterface é disponibilizada através da interface gráfica Giramundonics. O Giramundonics possibilita se ter a visualização de uma miniatura da apresentação original de cada arquivo e, se desejar, o usuário poderá abrir os arquivos de interesse. Além disso, o Giramundonics disponibiliza ao usuário facilidades de busca de termos nos conteúdos dos arquivos, de forma que se localize com rapidez e facilidade quais os arquivos que trazem os verbetes de interesse. 

<li><h3 id="crescimento">Crescimento do Acervo</h3></li>
O acervo do Giramundonics vai se constituindo cumulativamente ao longo do tempo. Após uploads de arquivos, estes serão incorporados gradativamente ao acervo a partir de cada ativação do "vigilante", que deve ser programado através da facilidade do Cron do sistema operacional.  A cada ativação, um lote de arquivos é tratado e incorporado ao acervo.  Assim, é normal que imediatamente após o upload de arquivos estes ainda não apareçam no acervo. Espere o tratamento gradativo dos lotes de arquivos.<br \>

O tratamento em lotes dos arquivos possibilita um uso mais racional da capacidade de processamento da máquina.

<li><h3 id="buscas">Buscas no Acervo</h3></li>
As buscas de conteúdos no acervo da Superinterface estão disponíveis na interface gráfica disponibilizada pelo Giramundonics, e pode ser realizada de três formas:
<ul>
<li>Pelo nome do arquivo: a busca se inicia pelo primeiro caractere do nome do arquivo.</li>
<li>Pelo nome da cidade.</li>
<li>Pelo nome da instituição.</li>
</ul>
A medida que se inicia a digitação do termo a ser buscado, as buscas já são iniciadas.<br \>
Os termos que estão indexados pertencem a um vocabulário controlado, constituindo um conjunto normalizado de termos que serve à indexação e à recuperação da informação. Esses termos são predefinidos através de arquivos de configuração, os quais o administrador da Superinterface pode alterar.
<li><h3 id="perguntas">Perguntas Frequentes</h3></li>
<ol style="list-style-type:square;">
<li>Por que após fazer o upload de arquivo ele não aprece imediatamente no acervo?</li>
Antes de tudo, isso é normal e pode estar acontecendo devido algumas razões:
<ol style="list-style-type:circle;">
<li>o "vigilante" ainda não foi acionado. Neste caso, espere um pouco mais para o arquivo ser tratado.</li>
<li>o "vigilante" foi acionado, mas pode  existir uma fila de arquivos para serem tratados. Espere o tratamento gradativo dos arquivos, o qual é realizados em lotes.</li>
<li>pode ser que o tratamento do arquivo já foi realizado e alguma inconsistência na estrutura do documento foi detectada. Neste caso utilize a opção "Quarentena" da interface administrativa da Superintrface e verifique se o arquivo foi enviado para lá.</li>
</ol>
<li>Como alterar o tamanho limite para uploads de arquivos?</li>
Para fazer isto é necessário ter conhecimento técnico para alterar um dos arquivos de configuração descritos abaixo.  Três situações:
<ol style="list-style-type:circle;">
<li>Se a limitição se refere ao PHP, o parâmetro referente a uploads de arquivos na configuração do PHP deve ser alterado.</li>
<li>Se a limitação se refere a configuração da Superinterface, e a Superinterface ainda não foi instalada, altere o parâmetro de uploads de arquivos em /su_install/super_config.cnf.</li>
<li>Se a limitação se refere a configuração da Superinterface, e a Superinterface já está em funcionamento, altere o parâmetro de uploads de arquivos /su_admin/em super_config_php.cnf</li>
</ol>
<li>Como posso saber qual o tamanho máximo permitido para upload de arquivos?</li>
Essas informações estão disponíveis através da opção "Status" do Portal de Administração da Superinterface. Observe que o controle está sendo realizado tanto pela configuração do PHP (php.ini) como através de parâmetro da Superinterface.  Vale o menor valor.
<li>Como outras pessoas podem ter acesso ao Painel de Administração?</li>
Para isso cadastre essas pessoas através da opção "Usuários" do Painel de Administração. Cada usuário pode ser cadastrado com o perfil de "Administrador" ou "Conteudista".
<li>Que tabelas existem na base de dados da Superinterface?</li>
Essa informação está disponível através da opção "Tabelas" do Portal de Administração.  Inclusive se a instalação fora feita com tabelas externas, estas também aparecerão quando se usar esta facilidade do portal.
<li>Como posso acompanhar as operações da Superinterface?</li>
Através da opção "Logs" do Painel de Administração se tem acesso as informações em tempo real a respeito das operações que os scripts da Superinterface estão realizando. 
</ol>
</ol>
</div>
<script type="text/javascript">
function lista_h2(){
var i;
$x=document.querySelectorAll('h2,h3');
menuzinho=document.getElementById("menu");
menuzinho.innerHTML=menuzinho.innerHTML+"<br><br>";
for (i=0; i<$x.length; i++){
	if ($x[i].tagName == "H2" ) {
		menuzinho.innerHTML=menuzinho.innerHTML+"<br>* <a class='lista_de_conteudo2' href='#"+$x[i].id+"'>"+$x[i].innerHTML+"</a><br>";
	}
	else {    /*  será H3 */
		menuzinho.innerHTML=menuzinho.innerHTML+"&ensp;<a class='lista_de_conteudo3' href='#"+$x[i].id+"'>"+$x[i].innerHTML+"</a><br>";
	}
}
}
</script>
</body>
</html>


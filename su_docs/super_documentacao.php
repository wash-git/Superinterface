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
<b>Bem vind@ a Superinterface!</b>
<p></p><p></p>
A  Superinterface visa proporcionar o suporte tecnológico necessário para se criar um acervo documental na internet sobre uma determinada temática, podendo realizar buscas textuais e permitir à equipe envolvida com este acervo a possibilidade da entrada de metadados e outras informações sobre cada documento, de forma fácil e ágil. <br /><br />

Se destina a ser um sistema fácil de ser utilizado e mantido, com poucas formalidades arquivísticas, rapidez na recuperação da informação e que proporcione aos usuários da solução uma experiência diferenciada de visibilidade dos conteúdos dos documentos.
<p></p>
Este projeto é mais uma iniciativa do <a href="http://wash.net.br" target="_blank">Programa Wash</a> - Workshop Aficionados em Software e Hardware.

<br \><br \>Seja muito Bem Vind@, e aproveite!!
</div>
</td></tr></table>
<!--  ******************************************* -->
<h2 id="apresentacao">Apresentação</h2>
A Superinterface é destinada a dar o suporte tecnológico para criação de acervos documentais digitais, agrupando todos e quaisquer documentos que estão relacionados a uma determinada questão específica de interesse de uma coletividade. O significado tomado aqui para "acervo" é de uma coleção de documentos. Assim, a Superinterface se presta a disponibilizar uma coleção de documentos na internet para consultas.<br /><br />

Essa reunião de documentos apoiada pela Superinterface deveria ter por base alguma característica comum definida por seus usuários, embora a solução exija poucos formalismos de classificação e proveniência dos documentos. Isso tudo para possibilitar o máximo de fluidez na gestão dos documentos por parte dos curadores.
<br /><br />
A recuperação da informação sempre foi uma questão delicada para a ciência da informação. Neste sentido, a Superinterface oferece facilidades de indexação e busca de termos na coleção de documentos, permitindo a criação de arquiteturas de acordo com as necessidades da aplicação. São muito amplas as possibilidades de indexação dos conteúdos dos arquivos presentes no acervo. No momento da instalação deste pacote, as seguintes informações estarão automaticamente disponíveis para serem buscadas nos conteúdos dos arquivos:
<dl>
<dd>- instituições citadas;</dd>
<dd>- autoridades citadas;</dd>
<dd>- cidades citadas;</dd>
<dd>- nomes de pessoas citadas.</dd>
</dl>

Os dados estão organizados por documento. Ferramentas de automatização estão continuamente sendo avaliadas e utilizadas para que a Superinterface consiga fazer essa coleta de dados, inclusive:
<dl>
<dd>- ferramentas de tratamento de texto convencionais (sed, regexp, grep, awk, head, tail, cat, entre outras);</dd>
<dd>- ferramentas de análise de linguagem natural (Unitex);</dd>
<dd>- ferramentas baseadas em algoritmo genético (desenvolvimento próprio).</dd>
</dl>

Destas 3 abordagens, a mais madura é a primeira e já vem sendo utilizada amplamente para gerar parte dos metadados da plataforma Superinterface.<p></p>
<!--  ******************************************* -->
<h2 id="manualinstalacao">Manual Instalação</h2>
<ol>
<!--
 ..................................................................................................
 -->
<li><h3 id="introducao">Introdução</h3></li>
Antes de iniciar a instalação da Superinterface, considere ler com atenção esta documentação que objetiva ser um roteiro prático de auxílio ao instalador da solução. Os procedimentos de instalação da Superinterface foram planejados de forma a instalação ser realizada de maneira fácil e rápida, e pode ser dividida em quatro etapas:
<dl>
<dd>- preparação do ambiente do servidor;</dd>
<dd>- preparação da modelagem da base de dados;</dd>
<dd>- preparação das informações a serem populadas as tabelas da base de dados;</dd>
<dd>- preparação de códigos complementares aderentes a modelagem realizada.</dd>
</dl><br />
Este manual irá descrever em detalhes cada uma destas etapas. Mas já adianta-se que após se ter o ambiente do servidor preparado, o pacote da Superinterface já disponibiliza uma modelagem inicial da base de dados e com todos os arquivos necessários para se ter uma primeira experiência desta aplicação.  O único trabalho seria fornecer 4 (quatro) informações básicas necessárias ao funcionamento da aplicação através do arquivo su_install/super_config.cnf:
<dl>
<dd>- nome da base de dados;</dd>
<dd>- usuário da base de dados;</dd>
<dd>- senha do usuário da base de dados;</dd>
<dd>- url do host-name da Superinterface.</dd>
</dl><br />
Assim, recomenda-se fortemente a realização dessa primeira experiência de funcionamento da Superinterface antes de se implementar a modelagem específica da aplicação do usuário.  É uma forma prática de verificar que todo ambiente foi configurado corretamente e a aplicação Superinterface está em pleno funcionamento.<br /><br />
A seguir iremos descrever estas etapas e esperamos que ela possa ser útil. Uma boa leitura!
<!--
 ..................................................................................................
 -->
<li><h3 id="arquitetura">Arquitetura da Solução</h3></li>
A figura abaixo representa os blocos que compõem a Superinterface: <br /><br />
<img src="./super_superinterfacediagrama.png" alt="Blocos que compõem a Superinterface" class="centerimage"></td>
<br /><br />
Origem dos códigos da Superinterface e das informações necessárias ao funcionamento da solução:
<ul>
<li><span class="spelling-sublinhado">Módulo Shell:</span> os códigos dos scripts são construídos previamente e responsáveis pela instalação da solução e inserção de novos arquivos no acervo da solução;</li>
<li><span class="spelling-sublinhado">Potlatch:</span> código gerado automaticamente no momento da instalação da solução. É um sistema CRUD (Create, Retrieve, Update & Delete), voltado para a entrada de dados de forma estruturada no banco de dados, em especial dos metadados. A Potlatch não é destinada ao usuário final, mas aos curadores do acervo;</li>
<li><span class="spelling-sublinhado">Giramundonics:</span> código construído previamente e fornecido no pacote da solução. É o código do motor de busca que faz a recuperação de informações dentro do acervo. É destinado ao usuário final, permitindo a visualização do acervo. Não possui facilidades de entrada de dados. Não é um CRUD;</li>
<li><span class="spelling-sublinhado">Painel de Administração:</span> código construído previamente e fornecido no pacote da solução. Possibilita acesso as funções administrativas da Superinterface;</li>
<li><span class="spelling-sublinhado">Base de Dados:</span> arquivo com códigos SQL para criação das tabelas estão fornecidos no pacote da solução;</li>
<li><span class="spelling-sublinhado">Base de Informações:</span> arquivos com um repertório de termos utilizados para indexação do acervo e, de forma complementar, informações para popular tabelas auxiliares da solução.</li>
</ul>
<p></p>
<!--
 ..................................................................................................
 -->
<li><h3 id="ambienteservidor">Ambiente do Servidor</h3></li>
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
<!--
 ..................................................................................................
-->

<li><h3 id="instalacao">Instalar a Superinterface</h3></li>
<ol style="list-style-type:lower-alpha">
<li>Todo código da solução e demais arquivos necessários ao funcionamento da Superinterface estão disponíveis no GitHub, bastando baixar a <a href="https://github.com/wash-git/Superinterface/releases" target="_blanck">última release da aplicação Superinterface</a>;</li>
<li>Não é permitido realizar a instalação da aplicação como usuário root. Deve-se realizar todas instalação do código da aplicação Superinterface como um usuário normal, sem prerrogativas de administrador;</li>
<li> Desempacotar a aplicação na raiz (document root) do virtual host.  Para isto, utilize um dos seguintes comandos dependendo do pacote baixado (tar.gz
ou zip):</li><br />
<pre>
..../host1$  tar -xvf Superinterface-3.0.tar.gz
..../host1$  unzip Superinterface-3.0.zip
</pre>
Obs:  no exemplo acima, 3.0 se refere a versão da aplicação.  Verifique a versão baixada para fazer a montagem da instrução da forma correta.
<li>Após desempacotar a aplicação, as seguintes pastas e arquivos deverão estar presentes na raiz do virtual host:</li>
<p></p><pre>
.../host1/
	su_admin/
	su_css/
	su_docs/
	su_exemplos/
	su_icons/
	su_info/
	su_install/
	su_js/
	su_php/
	index.php
	LICENSE
	README.md
</pre><p></p>
obs:<br \>
a) Em especial, a pasta su_install/ conterá os arquivos necessários à instalação da Superinterface<br />
b) O arquivo com a documentação técnica da Superinterface (super_documentacao.php) poderá ser acessado via navegador da seguinte forma: &nbsp;&nbsp;&nbsp;
http://&#60;host-instalacao&#62;/su_docs/super_documentacao.php<br />
<p></p>
<li>Na pasta su_install/, alterar as propriedades dos seguintes arquivos conforme mostrado abaixo:</li>
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
<dd>- indicação do host onde estará funcionando a Superinterface</dd>
</dl>
Obs: por segurança, não é recomendado que o usuário da aplicação tenha privilégios de criação de base de dados. 
<p></p>

<li>Reinstalar a Superinterface<br />
A Superinterface pode ser reinstalada a qualquer momento sem maiores burocracias, repetindo o processo descrito.  Mas toda vez que se fizer a reinstalação todas as tabelas existentes na base serão apagadas e recriadas.
</li>
</ol>
</li>
<p></p><p></p>
Pronto. Agora já se pode ter a primeira experiência de funcionamento da Superinterface, a qual será descrita na próxima seção deste documento.
<p></p>
<p></p>
<!--
 ..................................................................................................
-->
<li><h3 id="experiencia">Primeira Experiência</h3></li>
Após se ter o ambiente do servidor preparado, conforme descrito na seção <a href="#preparacao_ambiente" title="Ambiente do Servidor">Ambiente do Servidor</a>, é hora de se ter uma primeira experiência de funcionamento da Superinterface.  Vamos conhecer a Superinterface funcionando de verdade.<p></p>
O pacote da Superinterface já vem completo para proporcionar uma primeira experiência de seu funcionamento. Para isto, é necessário apenas dois paços:
<ul><li>forneça as 4 (quatro) informações básicas através do arquivo de configuração da solução em su_install/super_config.cnf,  conforme descrito anteriormente na seção <a href="#introducao" title="Introdução à instalação da Superinterface">Introdução</a>;</li>
<li>estando na pasta de instalação (su_install/), execute o script de instalação super_install.sh da seguinte forma:<br />
su_install$ ./super_install<p></p>
</ul><p></p>
Acompanhe o log da instalação através do arquivo super_logshell.log que estará na pasta su_logs/<p></p>
Apenas isso. Depois é passar a se certificar que realmente tudo fora realizado durante a instalação e, em seguida,  passar a fazer os primeiros usos da Superinterface como mostra o roteiro a seguir: 
<ol style="list-style-type:lower-alpha">
<li>Se a instalação foi realizada com sucesso, ao seu final terá sido gerada pastas adicionais necessárias ao funcionamento da solução. Deverão existir as seguintes pastas:</li>

</pre>
<pre>
drwxr-x---  web1 web1  su_admin/
drwxr-x---  web1 web1  su_autophp/
drwxr-x---  web1 web1  su_css/
drwxr-x---  web1 web1  su_docs/
drwxr-x---  web1 web1  su_exemplos/
drwxr-x---  web1 web1  su_icons/
drwxr-x---  web1 web1  su_imagens/
drwxr-x---  web1 web1  su_info/
drwxr-x---  web1 web1  su_install/
drwxr-x---  web1 web1  su_js/
drwxr-x---  web1 web1  su_logs/
drwxr-x---  web1 web1  su_php/
drwxr-x---  web1 web1  su_primitivos/
drwxr-x---  web1 web1  su_quarentine/
drwxr-x---  web1 web1  su_uploads/
drwxr-x---  web1 web1  su_work/
</pre>
Explicações:
<ul>
  <li><strong> su_admin:</strong> pasta com os arquivos de controle das funções de administração da Superinterface.</li>
  <li><strong> su_autophp:</strong> pasta que contém os arquivos PHP e HTML gerados automaticamente pela SuperInterface</li>
  <li><strong> su_css:</strong> pasta com os arquivos de estilos da Superinterface.</li>
  <li><strong> su_docs:</strong> pasta com os arquivos relativos a documentação da Superinterface.</li>
  <li><strong> su_exemplos:</strong> pasta com exemplos de arquivos SQL.</li>
  <li><strong> su_icons:</strong> pasta com imagens utilizadas em páginas da Superinterface.</li>
  <li><strong> su_logs:</strong> pasta com os logs de todas as operações da solução, desde o momento da instalação até o presente momento. A pasta também será utilizada para guardar arquivos temporários necessários ao funcionamento da aplicação.</li>
  <li><strong> su_imagens:</strong> pasta onde estarão guardados os arquivos PDF pertencentes ao acervo da Superinterface, juntamente com sua imagem jpg, versão texto puro e outras versões necessárias.</li>
  <li><strong> su_info:</strong> pasta destinada ao usuário colocar os arquivos dependentes da modelagem da base de dados e com objetivo de popular esta base. Sejam planilhas, arquivos sql ou scripts shell.</li>  
  <li><strong> su_install:</strong> pasta com os arquivos de configuração, arquivos SQL com informações iniciais de preenchimento de tabelas e outros arquivos necessários à instalação da Superinterface, além dos scripts shell necessários ao seu funcionamento.</li>
  <li><strong> su_js:</strong> pasta com os arquivos javascript.</li>
  <li><strong> su_pdfuploads:</strong> pasta para onde serão direcionados os arquivos PDF após seu upload pelo usuário, com objetivo de fazer incorporações ao acervo da aplicação Superinterface.  A execução deste processo de incorporação de novos documentos PDF ao acervo estará sob responsabilidade do vigilante (ativado pelo cron).</li>
  <li><strong> su_php:</strong> pasta com arquivos PHP referente as funções de administração da Superinterface.</li>
  <li><strong> su_primitivos:</strong> pasta onde serão guardados os arquivos originais que forem submitidos ao acervo, tais como DOCX, DOC, RTF, ODT e TXT.  Os arquivos PDF submetidos ao acervo não são guardados nesta pasta, e sim diretamente na pasta principal do acervo.  Arquivos PDF com problemas na sua estrutura, bem como outros tipos de arquivos, estes serão enviados para pasta da quarentena.</li>
  <li><strong> su_quarentine:</strong> pasta para onde serão enviados os arquivos PDF que apresentarem problemas para serem incorporados ao acervo, arquivos submetidos em duplicidade ao acervo, bem como tipos de arquivos não aceitos pela Superinterface.</li>
  <li><strong> su_work:</strong> pasta auxiliar para tratamento dos arquivos submetidos ao acervo. É uma pasta que retém os arquivos submetidos ao acervo apenas durante o tempo em que estes estão sendo trabalhados para serem incorporados ao acervo.</li>
</ul>
<br />
<li>verifique através do arquivo de log  (vide seção <a href="#logs" title="Logs da Superinterface">Registro de Logs</a>) se tudo foi realizado corretamente. Se a instalação chegou ao seu final com sucesso.  Mas se ocorrer algum problema na instalação, a indicação de problema estará sinalizada através do arquivo de log. Faça a correção necessária e volte a executar o script de instalação;</li><br />
<li>com a instalação executada corretamente, use o navegador e acesse o Portal de Administração da Superinterface (http://&#60;url-instalacao&#62;/su_php/super_login.php).  Navegue através dos diversos links da página principal deste Portal, de forma a conhecer melhor as possibilidades desta aplicação;</li><br />
<li>utilize a opção de "uploads" do Portal de Administração e faça o envio de um arquivo PDF.  Espere o tempo do cronjob atuar (vide seção <a href="#ambienteservidor" title="Ambiente do Servidor">Ambiente do Servidor</a>) e verifique que o arquivo já pertence ao acervo conforme ele é mostrado através da página do Giramundonics em "http://&#60;url-instalacao&#62;/"    (vide seção <a href="#visibilidade" title="Visibilidade do Acervo">Visibilidade do Acervo</a>).  Observe a figura abaixo que mostra a tela do Giramundonics após o primeiro arquivo submetido ao acervo já estar incorparado:<p></p>
<img class="centerimage" src="./super_giramundonics_primeiroupload.png" width="70%"></li>
</dl>
<p>Com isso já podemos considerar que a instalação da Superinterface está correta e a aplicação está em pleno funcionamento.  Mas observe que está em funcionamento com a modelagem da base que foi fornecida e com seu conjunto de informações associados.  Se a modelagem fornecida contempla as necessidades, tudo bem.  Pode-se continuar a utilizar a Superinterface do jeito que está, sem necessidade de qualquer modificação.</p>
<p>No entanto se há uma necessidade diferente, é necessário trazer uma outra modelagem da base e uma nova base de informações iniciais.  É isso que a próxima seção deste documento tentará explicar.</p>
<p></p><br />
</ol>
<!--
 ..................................................................................................
-->
<li><h3 id="modelagem">Modelagem</h3></li>
A modelagem da base de dados é uma tarefa crucial para o bom funcionamento da Superinterface. A partir desta modelagem será possível realizar as seguintes operações:
<ul>
<li>a inserção de forma automatizada de informações na base de dados sobre o acervo;</li>
<li>a geração automática de códigos PHP;</li>
<li>facilidades aos usuários de manipulação de informações com integridade, especialmente com a utilização da Plataforma Potlatch.</li>
</ul><br />
Assim, preparar a base de dados obedecendo algumas regras é fator crucial para sucesso das operações da Superinterface. Regras estas que estaremos descrevendo a partir de agora.<br></br>
<ol style="list-style-type:lower-alpha">
<li>Nome das Tabelas</li>
Para que seja possível gerar automaticamente os códigos PHP da Plataforma faz-se necessário que o banco de dados tenha algumas características especiais.  As tabelas devem ter seus nomes no plural, para indicar o carater coletivo dos dados de uma tabela (conjunto de registros). Na modelagem fornecida com o pacote, são exemplos de tabelas existentes: su_documents, su_tiposdocumentos e su_cidades.
<p></p>
Não utilizaremos o uso de maiúsculas na primeira letra do nome da tabela em função da existência de questões associadas à transição dos nomes nas várias versões do MySQL, com diferentes configurações de sensibilidade de case. Portanto, por simplicidade adotou-se a prática de se usar letras minúsculas para todos os nomes, sejam de campos ou de tabelas.<br /><br />
<li>Nome dos Campos das Tabelas</li>
Atenção especial deve-se ter com essas regras de nomeação dos campos das tabelas:
<ul>
<li>id_chave_??????: o campo da chave primária da tabela sempre se inicia com id_chave_, seguido do nome da tabela no singular. Embora o schema do MySQL forneça quais campos são do tipo chave primária, optou-se por usar esse nome especial para os casos de chaves primárias. Na modelagem fornecida com o pacote, são exemplos destes campos: id_chave_documento, id_chave_tipo_de_documento e id_chave_cidade;</li><br />
<li>nome_??????: o campo que se inicia com nome_ indica qual campo da tabela externa será mostrado em drop boxes na potlatch, quando uma tabela tem uma relação do tipo "1 para N" ou "N para N" com outra tabela, seguido do nome da tabela no singular. Na modelagem fornecida com o pacote, são exemplos destes campos: nome_documento, nome_tipo_de_documento e nome_do_estado</li><br />
<li>photo_filename_??????: indica o campo que conterá o path do arquivo do acervo relacionado àquele campo, seguido do nome da tabela no singular. São campos da Superinterface que apontam para arquivos de imagens ou PDFs. Na modelagem fornecida com o pacote, um exemplo deste campo é  photo_filename_documento.</li><br />
</ul>
Obs: a Potlatch não guarda campos BLOBS.  
<p></p>
<li>A pasta su_info/</li>
<p>Esta pasta é muito especial para o usuário que vai fazer a instalação da Superinterface. Os arquivos desta pasta possibilitam ao usuário alternativas de como popular sua base de dados. Parte dos arquivos são aproveitados no momento da instalação da Superinterface, e outros são aproveitados ciclicamente ao longo da execução da solução especialmente quando um novo arquivo é disponibilizado para ser inserido ao acervo. Logo, os arquivos desta pasta são diretamente dependentes da modelagem da base de dados.</p>
<p>Os arquivos que podem existir nesta pasta são:</p>

<table class="tablec3">
<tr><th>Objetivo</th><th>Descrição</th><th>Caráter</th></tr>
<tr><td>Criação das tabelas</td><td>Arquivo com instruções SQL para criação das tabelas</td><td>Obrigatório</td></tr>
<tr><td>Base de Informações</td><td>Conjunto de planilhas .CSV com informações para inserção na base de dados</td><td>Opcional</td></tr>
<tr><td>Base de Informações</td><td>Conjunto de arquivos .SQL com regras e informações para  inserção na base de dados.</td><td>Opcional</td></tr>
<tr><td>Base de Informações</td><td>Script SHELL muito útil no uso com Expressões Regulares (ERs), melhorando as inserções na base de dados</td><td>Opcional</td></tr>
<tr><td>Script em regime</td><td>Script SHELL para inserção informações na base de dados dos novos arquivos submetidos ao acervo</td><td>Obrigatório</td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td></tr>
</table>
<p></p>
<p>Mais adiante será tratado com mais detalhes as estruturas destes arquivos e outras informações importantes necessárias para o perfeito funcionamento da Superinterface. Agora vamos mostrar como configurar a Superinterface.</p>
</ol>
<p></p>
<!--
 ..................................................................................................
-->
<li><h3 id="configuracao">Configuração</h3></li>
<p>Existe um arquivo de configuração o qual possibilita que o usuário forneça as informações relativas ao ambiente em que foi instalado a Superinterface, bem como algumas parametrizações que alteram o seu funcionamento. Este arquivo está disponível em su_install/super_config.cnf.</p>
<p>Este arquivo possui duas partes, chamadas "Parte-1" e "Parte-2", cada uma contendo um conjunto de parâmetros. Recomendamos que só sejam alterados os parâmetros da primeira parte, deixando os parâmetros da segunda parte sempre inalterados.</p>
<ol style="list-style-type:lower-alpha">
<li>Configuração Básica</li>

<p>Para uma primeira experiência com a Superinterface, utilizando a modelagem fornecida com o pacote baixado, basta informar 4 (quatro) informações básicas:<br />
<pre>
CPBASE=""                              # base de dados da aplicação
CPBASEUSER=""                          # usuário da base de dados
CPBASEPASSW=""                         # password da base de dados
CPHTTPHOST=""                          # Host name $_SERVER['HTTP_HOST'] + pasta raiz
</pre>
<p>O fornecimento destas quatro informações já são suficientes para colocar a Superinterface em funcionamento. Após isso, já se pode acionar o script de instalação. Não se preocupe com os demais parâmetros.</p>
<li>Configuração Avançada</li>
<p>Mas há outras informações que podem ser fornecidas neste arquivo de configuração que alteram em certa medida o funcionamento da Superinterface. Passaremos a explicar melhor estes parâmetros que são referenciados ainda na "Parte-1"  do arquivo de configuração:</p>
<ul>
<li> Parâmetro CPNUMERARPDF</li>
Esse parâmetro autoriza a Superinterface a modificar os nomes dos arquivos submetidos ao acervo. Antes de ser incorporado ao acervo, cada arquivo recebe um número único e sequencial na forma de um prefixo agregado ao seu nome original.  Pode ser uma facilidade interessante no sentido de auxiliar a gestão dos arquivos.<p></p> 
<li> Parâmetro CPQPDFLOTE</li>
Esse parâmetro define a quantidade máxima de arquivos a serem tratados a cada ativação do script programado através do cron. Ao submeter arquivos ao acervo, nem todos são tratados simultaneamente, mas esse tratamento é escalonado no tempo em lotes de arquivos.  Isso proporciona um uso mais racional do processador.  Aconselha-se esse número atender a seguinte tabela:<p></p>
<table>
<tr><th>Intervalo de ativação do script pelo Cron</th><th>CPQPDFLOTE</th</tr>
<tr><td>1 min</td><td>até 3</td></tr>
<tr><td>2 min até 5min</td><td>até 5</td></tr>
<tr><td>acima 5min</td><td>até 8</td></tr>
</table>
<li> Parâmetro CPTAMMAX</li>
Esse parâmetro define o tamanho máximo de cada arquivo que pode ser submetido ao acervo. Não é o parâmetro php.ini, mas um parâmetro adicional que tem efeito através da facilidade "Uploads" do Painel de Administração da Superinterface.<p></p>
<li> Parâmetro CPRELATORIO</li>
Esse parâmetro informa à Superinterface como confeccionar o relatório de resumo final de cada ativação do script da Superinterface pelo Cron. Se o relatório será constituído de parte das tabelas (definidas em um arquivo específico), ou contendo todas as tabelas da base de dados.<p></p>
<li> Parâmetro CPRELATORIOTABELAS</li>
Parâmetro com o nome do arquivo CSV que contém a lista de tabelas a constar no resumo final de cada ativação da Superinterface pelo Cron. O arquivo deve ser colocado obrigatoriamente na pasta su_info/.  Esse parâmetro só é obrigatório se CPRELATORIO indicar parte das tabelas.<p></p>
<li> Parâmetro CPCRIATABELAS</li>
Esse parâmetro define o nome do arquico SQL que contém as instruções de criação das tabelas.<p></p>
<li> Parâmetro CPINSERTSCRIPT</li>
Esse parâmetro define o nome do arquivo SHELL com, possivelmente, instruções de expressões Regulares (ERs) e INSERTs na base de dados que é executado na instalação da Superinterface. Esse arquivo não é obrigatório existir.<p></p>
<li> Parâmetro CPINSERTACERVO</li>
Esse parâmetro define o nome do arquivo SHELL com, possivelmente, instruções de expressões Regulares (ERs) e INSERTs na base de dados executado toda vez que o Cron ativa a Superinterface quando da existência de novos arquivos submetidos ao acervo esperando tratamento. Esse arquivo não é obrigatório existir.<p></p>
</ul>
</ol>
<p></p>
<!--
 ..................................................................................................
-->
<li><h3 id="baseinformacoes">Base de Informações</h3></li>
Para possibilitar o perfeito funcionamento da Superinterface, inclusive disponibilizar a facilidade de busca de verbetes nos conteúdos do acervo de arquivos, é necessário alimentar algumas de suas tabelas com informações oriundas de fontes externas. Isso possibilitará a construção do necessário vocabulário controlado da solução.<p></p>

Para facilitar a instalação, ao se baixar o pacote da Superinterface um conjunto completo de informações que constittui uma Base de Informações inicial já estará disponível na pasta su_info/. Esse conjunto de informações é aderente à modelagem trazida pelo pacote.  Assim, para uma primeira experiência da Superinterface não há necessidade de qualquer alteração nestes arquivos.  Entretanto, para uma outra modelagem da base de dados será necessário trocar estes arquivos em função das novas necessidades de informações.<p></p>

Informações para constituir essa Base de Informações podem (e devem) ser fornecidas pelos usuários, conforme as necessidades da modelagem da base de dados realizada. Essa Base de Informações será automaticamente inserida na base de dados pelas rotinas da Superinterface, seja no momento da instalação da solução ou em qualquer outro momento de sua utilização dependendo da fonte de informação. Este processo de alimentação da base de dados tem uma certa sequência de realização predefinida, conforme a tabela explicativa a seguir:
<p></p>
<table class="tablec1">
<tr><th>Formas</th><th colspan="2">Momento</th><th>Sequência</th></tr>
<tr><td></td><td>Na Instalação</td><td>Após Instalação</td><td></td></tr>
<tr><td>Criação Tabelas</td><td>X</td><td></td><td>1</td></tr>
<tr><td>Planilhas .CSV</td><td>X</td><td></td><td>2</td></tr>
<tr><td>Arquivos .SQL</td><td>X</td><td></td><td>3</td></tr>
<tr><td>Shell Script</td><td>X</td><td></td><td>4</td></tr>
<tr><td>Potlatch</td><td></td><td>X</td><td>Após instalação</td></tr>
</table><p></p>
Ou seja, no procedimento de instalação a Superinterface primeiro irá procurar o arquivo contendo comandos SQL de criação de tabelas, depois procurará o conjunto de arquivos de planilha CSV e fará a inserção de seus conteúdos na base de dados, seguido da busca do conjunto de outros arquivos .SQL e, por último, buscará executar um script shell do usuário com mais comandos de inserção de dados.   De forma assíncrona, após passado o momento da instalação, o usuário poderá acessar o Portal de Administração da Superinterface e adicionar metadados a base. 
<p></p>
<ol style="list-style-type:lower-alpha">
<li>Através de Planilhas (arquivos .CSV)</li>
 Este é o modo preferencial utilizado no momento da instalação da solução. Com certeza o modo mais fácil e prático.  O usuário responsável pela instalação deverá disponibilizar essas planilhas na pasta su_info/ e todos os arquivos presentes nesta pasta terão seus conteúdos inseridos na base de dados.  Deve ser destacado que existem exigências quanto as planilhas estarem obedecendo algumas regras especiais construtivas, conforme está explicado mais adiante.<p></p>

Podem ser disponibilizadas tantas planilhas quanto forem necessárias. Isto é, tantas quanto a modelagem da base de dados necessitar. As seguintes planilhas já são fornecidas com o pacote da Superinterface e são aderentes a modelagem da base que está implementada no pacote:<p></p>
<table class="tablec2">
<tr><th>Informação</th><th style="width:70%">Arquivo csv (colocado na pasta su_info/)</th></tr>
<tr><td>Países</td><td>supercsv-ibge_su_paises.csv</td></tr>
<tr><td>Estados</td><td>supercsv-ibge_su_estados.csv</td></tr>
<tr><td>Municípios</td><td>supercsv-ibge_su_cidades.csv</td></tr>
<tr><td>Instituições</td><td>supercsv_su_instituicoes.csv</td></tr>
<tr><td>Nomes de pessoas</td><td>supercsv_su_names_brasil.csv</td></tr>
<tr><td>Tipos de Logradouros</td><td>supercsv_su_tiposlogradouros.csv</td></tr>
<tr><td>Tipos de Documentos</td><td>supercsv_su_tiposdocumentos.csv</td></tr>
<tr><td>Registrados</td><td>supercsv_su_registrados.csv</td></tr>
<tr><td>Curadores</td><td>supercsv_su_usuarios.csv</td></tr>
</table><p></p>
Os conteúdos destes arquivos podem ser alterados no momento da instalação da Superinterface, arquivos poderão ser adicionados ou mesmo removidos. A Superinterface busca de forma automática os arquivos CSV que estiverem na pasta su_info/. Caberá ao usuário responsável pela instalação avaliar as necessidades, tendo como base a modelagem da base de dados que estará sendo utilizada.
<p></p>
As planilhas listadas acima e que trazem a referência "ibge" em seus nomes, tiveram sua fonte em tabelas fornecidas pela instituição IBGE:
<ul>
<li>Códigos dos Países</li>
O IBGE define os códigos dos países e os disponibiliza através de um aquivo, junto com outras informações como  abreviações de países e territórios. Esse arquivo pode ser baixado de <a href="https://ftp.ibge.gov.br/Registro_Civil/Codigos_dos_paises/paises_e_territorios_codigos_e_abreviacoes.xls">Códigos dos países</a> e será utilizado pela Superinterface.
<li>Códigos dos Estados Brasileiros</li>
O código dos Estados brasileiros está definido pelo IBGE, conforme pode-se verificar em <a href="https://www.ibge.gov.br/explica/codigos-dos-municipios.php" target="_blank">Código dos Estados brasileiros</a>, cujas informações será utilizada pela Superinterface.
<li>Códigos dos Municípios Brasileiros</li>
O IBGE disponibiliza um aquivo com os códigos de identificação dos municípios brasileiros. Esse arquivo pode ser baixado de <a href="https://www.ibge.gov.br/explica/codigos-dos-municipios.php" target="_blank">Tabela de Códigos de Municípios do IBGE</a>, cujas informações serão utilizadas pela Superinterface.
</ul>
<p></p>

<li>Através de Arquivos .SQL</li>
O usuário poderá disponibilizar arquivos com instruções SQL (INSERT, UPDATE, ALTER TABLE e outros) para serem executados quando da instalação do sistema. Podem ser disponibilizados tantos arquivos quanto sejam necessários através da pasta su_info/. Rotinas da  Superinterface identificarão estes arquivos e executarão essas instruções SQL.  A Superinterface executará esses arquivos SQL por ordem alfabética dos nomes dos arquivos, um após o outro.
<p></p>
O pacote da Superinterface baixado já disponibiliza na pasta su_info/ um primeiro arquivo SQL o qual é aderente a modelagem da base de dados fornecida. Para uma outra modelagem, o usuário deverá modificar ou mesmo trocar este arquivo.
<p></p>
Obs: não é obrigatório que exista qualquer arquivo SQL no momento da instalação, exceptuando logicamente o arquivo de criação das tabelas.<p></p>

<li>Através de arquivo SHELL script</li>
Esta forma vem sendo utilizada principalmente quando há necessidade de popular a base de dados combinando informações anteriormente inseridas das planilhas e de arquivos SQL, mas onde haja necessidade adicional de preenchimento de alguns campos de tabelas através de processamento de expressões regulares (ERs) ou mesmo de linguagem natural.
<p></p>
<li>Através da Plataforma Potlatch</li>
Passado o momento da instalação, usuários com acesso ao Painel de Administração da Superinterface poderão se utilizar das facilidades da Plataforma Potlatch e inserirem mais informações na base de dados. Os procedimentos para utilização da Potlatch estão detalhadas no Manual do Usuário em seção específica sobre o assunto. 
<p></p>
<li>Padronização dos nomes e dos conteúdos das planilhas</li>
As planilhas devem estar obedecendo a algumas regras de formação, tanto em relação aos nomes destes arquivos quanto aos seus conteúdos. O objetivo dessas regras de formação é possibilitar um processo automatizado de incorporação das informações trazidas pelas planilhas à base de dados. Processo esse que independe da quantidade de planilhas fornecidas. A seguir estão descritas estas regras de formação que devem obrigatoriamente serem seguidas.
<ul>
<li>Quanto ao nome do arquivo:</li>
O nome da planilha é composto de duas partes, onde o primeiro underscore encontrado faz esta separação: a primeira parte vai até o primeiro underscore (inclusive), e a segunda parte começa após este primeiro underscore. Ou seja, o primeiro underscore é um separador: a primeira parte do nome da planilha é um texto livre, e será despezado pela Superinterface; após o primeiro underscore, o texto deve corresponder exatamente ao nome de alguma tabela da base de dados. Dessa forma a Superinterface saberá automaticamente onde fazer a inserção das informações do arquivo.<p></p>
Vejamos um exemplo, através da planilha referente aos países:
<p class="centertext">supercsv-ibge_su_paises.csv</p><br />
Pela regra descrita, o conteúdo deste arquivo será direcionado à tabela "su_paises".
<p></p>
<li>Quanto ao conteúdo do arquivo:</li>
O conteúdo de cada planilha deve obedecer a seguinte construção:

<ol style="list-style-type:circle;">
<li>a primeira linha da planilha deve ter um cabeçalho, onde cada coluna deve ter o nome exatamente igual ao campo da tabela.  Assim, o conteúdo de cada coluna da planilha será inserido no respectivo campo da tabela;</li>
<li>a planilha deve ter os conteúdos separados por vírgulas, e cada conteúdo envolvido por aspas.</li>
</ol><p></p>
Vejamos um exemplo através do arquivo de curadores. Observe através das figuras abaixo que o cabeçalho da planilha está definindo que os conteúdos da primeira coluna devem ser inseridos no campo "username" da tabela, os conteúdos da segunda coluna devem ser inseridos no campo "nome_usuario". Também se observa pela figura da direita que se está atendendo a regra do separador de campos ser uma vírgula e os conteúdos delimitados por aspas.
<div class="img_container">
<img src="./super_csv_curadores_tab.png"  height="90%" class="img_item"  />
<img src="./super_csv_curadores_config.png" height="90%" class="img_item"  />
</div>
<dl>
<dt>Atente ainda:</dt>
<dd>- conjunto de caracteres: UTF-8</dd>
<dd>- aspas em todas as células de texto, mesmo em colunas numéricas</dd>
<dd>- separação de células: por vírgula</dd>
<dd>- delimitador de conteúdo: aspas</dd>
</dl>
</ul>
</ol>
<p></p><br />
<!--
 ..................................................................................................
-->
<li><h3 id="logs">Registro de Logs</h3>
Todas as atividades relevantes da Superinterface, inclusive qualquer ação imprópria no tratamento do acervo, são registradas em seu arquivo de log de forma a permitir ao usuário administrador o acompanhamento destes eventos. O principal objetivo do registro de logs da Superinterface está relacionada à sua conformidade, e registrar o histórico de suas atividades. 
<br /> <br />
Na pasta de logs desta aplicação existem dois arquivo de logs:
<ol style="list-style-type:square">
<li> su_logs/super_logshell.log</li>
<li> su_logs/super_logshell.html</li>
</ol><br />
Todo log é registrado no arquivo super_logshell.log.  Já o segundo arquivo, super_logshell.html, é apenas uma cópia do primeiro arquivo destinado a ser visualizado através da interface administrativa da Superinterface.  Mas seu conteúdo é exatamente igual ao do primeiro arquivo.<br /><br />
A Superinterface realiza a rotação de logs através de um processo automatizado, realizando a compactação do arquivo e renomeando-o. Esse processo ocorre quando o tamanho deste arquivo de log atinge um determinado valor parametrizado através do arquivo de configuração. Essa compactação gera um arquivo ".tar", o qual fica guardado na própria pasta de logs, e um novo arquivo de logs é iniciado.
<p></p>
É muito importante verificar periodicamente o arquivo de log, certificando que todas as operações estão sendo realizadas sem ocorrências de exceções.<p></p>
Código de cores: para facilitar a visualização das mensagens, estas obedecem um código de cores: (a) na cor branca estão as mensagens informativas, de forma o usuário acompanhar o que fora realizado pela Superinterface; (b) na cor azul, as operações mais críticas e que foram realizadas com sucesso; (c) e na cor vermelha, as mensagens de exceções, possivelmente alguma ação imprópria da aplicação, e que merecem uma intervenção do administrador do serviço.
<!--
 ..................................................................................................
-->
<li><h3 id="troubleshoot">Troubleshoot</h3>
Eventuais anormalidades no tratamento do acervo são registradas em seu arquivo de log (su_logs/super_logshell.log) de forma a permitir ao usuário administrador o acompanhamento e as intervenções de correção necessárias. Recomenda-se o acompanhamento continuado deste arquivo de log por parte do usuário administrador desta aplicação. Ou seja, o arquivo de log deve ser acompanhado não apenas durante a instalação da Superinterface, mas rotineiramente durante sua operação.<p></p>
Durante a instalação, caso se verifique alguma dificuldade e o arquivo de log não tenha o registro completo da situação, execute alternativamente o script abaixo via comando do terminal, e acompanhe as mensagens:<br />
$ ./super_scriptinicial.sh<br /> <br />
Após realizar o diagnóstico do problema e ter solucionado a dificuldade, (re)instale a solução via seu comando padrão:<br />
$ ./super_install.sh<br /><br />
<!--
 ..................................................................................................
-->
<li><h3 id="perguntasinstalacao">Perguntas Recorrentes</h3></li>
<ol style="list-style-type:square;">
<li>Desejo utilizar a Superinterface conforme foi fornecida.  Tenho de realizar algum procedimento especial?</li>
Não há necessidade.  É só usar a Superinterface pois ela já vem pronta para uso utilizando a modelagem da base de dados fornecida.  Apenas lembre-se de fornecer as quatro informações básicas, conforme seção <a href="#introducao" title="Introdução à instalação da Superinterface">Introdução</a>.
</ol>
</ol>
<!--  ******************************************* -->
<h2 id="manual_usuario">Manual do Usuário</h2>
<ol>
<!--
 ..................................................................................................
-->
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
<!--
 ..................................................................................................
-->
<li><h3 id="uploads">Upload de Arquivos</h3></li>
Os arquivos podem ser incorporados ao acervo da Superinterface a qualquer tempo. Estes devem pertencer a um certo conjunto de tipos de arquivos predeterminados.  Os tipos aceitos estão definidos no arquivo de configuração da Superinterface, onde para cada tipo existe um tratamento específico. Para submeter arquivos ao acervo, existem duas maneiras básicas:
<ol style="list-style-type:square;">
<li>Grande quantidade de arquivos: se você tem acesso direto as pastas da aplicação via ftp ou ssh, copie os arquivos a serem submetidos ao acervo para a pasta /su_uploads.</li>
<li>Alguns poucos arquivos: utilize a interface gráfica da Superinterface, atravé das opção "Uploads" do menu principal.</li>
</ol><p></p>Alguns comportamentos devem ser observados:
<ol style="list-style-type:square;">
<li>Utilizando a opção "Uploads" da interface gráfica da Superinterface, haverá duas limitações referente ao tamanho dos arquivos: pela configuração php.ini do PHP (que pode ser visualizada através da opção "Status" do menu); por limitação da prórpia Superintrface, programada através do arquivo de configuração da aplicação.  As duas limitações podem ser visualizadas através da opção "Status" do menu principal.</li>
<li>Utilizando a opção "Uploads" da interface gráfica da Superinterface, haverá a verificação do tipo de arquivo que está sendo submetido. Somente alguns tipos de arquivos são aceitos pela Superinterface, conforme estabelecido através de seu arquivo de configuração.</li>
<li>Utilizando o acesso via ftp ou ssh diretamente à pasta /su_uploads, as verificações de segurança quanto ao tamanho limite de cada arquivo e quanto ao tipo de arquivo não serão realizadas.  Use esta opção com parcimônia.</li>
</ol>
<!--
 ..................................................................................................
-->
<li><h3 id="visibilidade">Visibilidade do Acervo</h3></li>
A visibilidade dos arquivos que estão no acervo da Superinterface é disponibilizada através da interface gráfica Giramundonics. O Giramundonics possibilita se ter a visualização de uma miniatura da apresentação original de cada arquivo e, se desejar, o usuário poderá abrir os arquivos de interesse. Além disso, o Giramundonics disponibiliza ao usuário facilidades de busca de termos nos conteúdos dos arquivos, de forma que se localize com rapidez e facilidade quais os arquivos que trazem os verbetes de interesse. 
<!--
 ..................................................................................................
-->
<li><h3 id="crescimento">Crescimento do Acervo</h3></li>
O acervo do Giramundonics vai se constituindo cumulativamente ao longo do tempo. Após uploads de arquivos, estes serão incorporados gradativamente ao acervo a partir de cada ativação do "vigilante", que deve ser programado através da facilidade do Cron do sistema operacional.  A cada ativação, um lote de arquivos é tratado e incorporado ao acervo.  Assim, é normal que imediatamente após o upload de arquivos estes ainda não apareçam no acervo. Espere o tratamento gradativo dos lotes de arquivos.<br \>

O tratamento em lotes dos arquivos possibilita um uso mais racional da capacidade de processamento da máquina.
<!--
 ..................................................................................................
-->
<li><h3 id="buscas">Buscas no Acervo</h3></li>
As buscas de conteúdos no acervo da Superinterface estão disponíveis na interface gráfica disponibilizada pelo Giramundonics, e pode ser realizada de três formas:
<ul>
<li>Pelo nome do arquivo: a busca se inicia pelo primeiro caractere do nome do arquivo.</li>
<li>Pelo nome da cidade.</li>
<li>Pelo nome da instituição.</li>
</ul>
A medida que se inicia a digitação do termo a ser buscado, as buscas já são iniciadas. Os termos que estão indexados pertencem a um vocabulário controlado, constituindo um conjunto normalizado de termos que serve à indexação e à recuperação da informação. Esses termos são predefinidos através de arquivos de configuração, os quais o administrador da Superinterface pode alterar.
<br /><br />
A figura abaixo mostra a caixa que possibilita ao internauta realizar seus processos de busca de termos no acervo:
<br /><br />
<img src="./super_giramundonics_buscas.png" alt="Tela de busca de conteúdos pelo Giramundonics" class="centerimage"></td>
<p></p>
<!--
 ..................................................................................................
-->
<li><h3 id="potlatch">Potlatch</h3></li>
A plataforma Potlatch é um Sistema CRUD, voltado para a entrada de dados de forma estruturada no banco de dados. A Potlatch não é voltada para o usuário final,  mas sim para um conjunto de atores os quais chamamos de curadores de informações.  A missão principal destes curadores é alimentar de metadados descritivos sobre os arquivos que chegam ao acervo da Superinterface, o que permitirá qualificar melhor este conteúdo, bem como complementar ou atualizar os conteúdos das tabelas da base de dados.<br /><br />

O acesso à Potlatch se dá pelo Portal de Administração da solução, através de um processo de autenticação usuário/senha. Sua utilização é bastante simples: ao estar na página inicial da Potlatch, tem-se a visualização da lista de tabelas existentese. Para cada tabela são dadas duas opções ao curador: a visualização/edição de seu conteúdo ou a visualização da descrição da tabela.<br /><br />

Quando da opção visualização/edição da tabela é a escolhida, será mostrado todo o conteúdo da tabela, ao mesmo tempo que se possibilita fazer alterações no seu conteúdo: removendo, alterando ou adicionando conteúdos.  Os campos mostrados em verde sinaliza a existência de uma chave externa daquele campo para um outro de outra tabela. As opções de preenchimento destes campos são visualizadas através de um dropbox utilizando-se das setas "CIMA" e "BAIXO" do teclado.<br /><br />
A página abaixo mostra a página inicial da Potlatch:<br /><br />
<img src="./super_potlatch_primeirapagina.png" alt="Página inicial do Potlatch" class="centerimage">
<p></p>
A principal tabela da Superinterface chama-se su_documentos.   Ao editar esta tabela, o curador pode alterar os seguintes campos:
<table>
<tr><th>Nome do Campo</th><th>Descrição</th></tr>
<tr><td>sigla</td><td>Campo de digitação livre.  Trata-se de um mnemônico, sintético, para ajudar o usuário a identificar o documento. Procure deixar cada documento com siglas diferentes</td></tr>
<tr><td>id_tipo_documento</td><td>Campo dropbox, o qual usando a seta para "BAIXO" serão mostradas as opções possíveis. Com a tecla ENTER realiza-se a seleção da opção. Campos dropbox só permitem o preenchimento com as informações já existentes na base de dados</td></tr>
<tr><td>id_curador</td><td>Campo dropbox, o qual usando a seta para "BAIXO" serão mostrados os curadores cadastrados. Com a tecla ENTER realiza-se a seleção da opção. Campos dropbox só permitem o preenchimento com as informações já existentes na base de dados</td></tr>
<tr><td>originalfilename</td><td>Reservado para uso futuro</td></tr>
<tr><td>titulo</td><td>Campo de digitação livre. Escolha um nome significativo para o documentoi.  Digite normalmente, inclusive podendo usar caracteres acentuados</td></tr>
<tr><td>descricao</td><td>Campo de digitação livre. Faça uma descrição sucinta do conteúdo do documento a partir da leitura do documento.  Algo como 1 parágrafo curto, trazendo informações sobre as características, os objetivos e destinação do documento</td></tr>
<tr><td>relevancia</td><td>Campo de digitação livre. Algo como 1 parágrafo explicando porque o documento é relevante para constar no acervo</td></tr>
<tr><td>data_doc</td><td>Campo para digitação da data do documento (aaaa-mm-dd)</td></tr>
</table><br />
Sempre que um campo for alterado, ele ficará na cor vermelha indicando que aquela informação ainda não foi gravada na base de dados. Na extremidade direita desta linha da tabela encontra-se o botão ATUALIZA para salvar na base de dados as alterações realizadas.
<p></p>
Abaixo temos um recorte da tela do Giramundonics mostrando como são visualizados os campos editados pelo curador (data_doc, sigla, descricao, relevancia), e já com duas buscas realizadas automaticamente pela Superinterface (busca por instituições citadas no documento e busca de signatário do documento):<br /><br />
<img src="./super_giramundonics_metadados.png" alt="Página do Giramundonics com os metadados" class="centerimage">
<p></p>
<!--
 ..................................................................................................
-->
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


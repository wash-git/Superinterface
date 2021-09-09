<!DOCTYPE html>
<html lang='pt-br'>
<head>
<title>Documento de referência técnica da Plataforma Potlatch</title>
<meta charset="utf-8">
<meta name="keywords"  content="Giramundonics,portlet">
<meta name="author"    content="Vitor Mammana">
<link rel='stylesheet' href='../su_css/super_documentacao.css' type='text/css'>
</head>
<body onload="lista_h2()">
<div id="menu">
Conteúdo
</div>

<div id="conteudo">
<h1>Documento de Referência da Plataforma Potlatch</h1>
<h3>Criado por Victor Mammana (maio/2021)</h3>
<table>
<tr><td>
<img src="../su_docs/super_wash.jpg" width="400" style="border: 1px solid black"></td>
<td><div class="comentario">
<b>Objetivo</b>
<br \>
Descrever as características da plataforma Potlatch, criando as condições para que o leitor contribua com o desenvolvimento.
<br \><br \>
O principal aspecto a ser perseguido no desenvolvimento é a automatização da coleta das informações:
<ul>
	<li>Nomes de Cidades</li>
	<li>Nomes Próprios</li>
	<li>Nomes de Instituições</li>
	<li>CPFs e CNPJs de beneficiários</li>
</ul>
Os dados devem estar organizados por documento e, sempre que possível, geo-localizados. No que se refere ao CPF e CNPJ, esses devem ser cruzados com a base de dados do SEBRAE, com milhões de registros.
<br \><br \>
</div>
</td></tr></table>
<p>
A plataforma <i>Potlatch</i> é um Sistema CRUD (Create, Retrieve, Update & Delete), voltado para a entrada de dados de forma estruturada no banco de dados localizado no servidor MySQL. Na sua primeira versão, chamamos esse banco de  <b>doc_aldirex</b>. Como se verá adiante, a  <i>Potlatch</i> criada a partir deste banco  <b>doc_aldirex</b> será referida, em alguns pontos do texto, como  <i>Potlatch</i>/<b>doc_aldirex</b>, devendo ficar claro que  <i>Potlatch</i> é o CRUD que acessa o banco <b>doc_aldirex</b>.</p>
<p>
A visualização desses dados pelo usuário final pode ser feita por outras plataformas, incluindo a <i>Giramundônics</i>. A <i>Potlatch</i> não é voltada para o usuário final. </p>
<p>
Até o presente momento, existem 3 formas de acessar os dados presentes no banco  <b>doc_aldirex</b>:</p>
<ul>
	<li>Modo <b>Usuário Final</b> ou  <i>Giramundônics</i>	: é desenhado para ser usado pela pessoa que não está vinculada ao <i>staff</i> do Observatório da Lei Aldir Blanc. Permite apenas a visualização, <i>browsing</i> e <i>search</i> nos dados. Não tem ferramentas de entrada de dados. Não é um CRUD.</li>
<br /><div class="codigo centrado">
<code>http://observatorio.wash.net.br/dev_vitor/7_firefox_aldir_pdf_hiper.php</code><a href="http://observatorio.wash.net.br/dev_vitor/7_firefox_aldir_pdf_hiper.php" target="_blank">Visitar</a><br />
<code>http://observatorio.wash.net.br/superinterface/</code><a href="http://observatorio.wash.net.br/superinterface/" target="_blank">Visitar</a>
</div><br />
	<li>Modo <b>Curador</b>: é desenhado para ser usado pelo curador(a), facilitando a busca dos documentos que foram atribuídos a ele(a). Permite inserir, alterar e deletar dados e novos documentos no acervo. É um CRUD.</li>
<br /><div class="codigo centrado">
<code>http://observatorio.wash.net.br/dev_vitor/autophp/backoffice_aldir_entrada_principal.html</code><a href="http://observatorio.wash.net.br/dev_vitor/autophp/backoffice_aldir_entrada_principal.html" target="_blank">Visitar</a><br />
<code>http://observatorio.wash.net.br/superinterface/autophp/backoffice_aldir_entrada_principal.html</code><a href="http://observatorio.wash.net.br/superinterface/autophp/backoffice_aldir_entrada_principal.html" target="_blank">Visitar</a>
</div>
<br />
	<li>Modo <b>Manutenção</b> ou <b>Backoffice</b>	: dá acesso a todas as tabelas do  <b>doc_aldirex</b>. É um CRUD.</li>
<br /><div class="codigo centrado">
<code>http://observatorio.wash.net.br/dev_vitor/autophp/backoffice.html</code><a href="http://observatorio.wash.net.br/dev_vitor/autophp/backoffice.html" target="_blank"  >Visitar</a><br />
<code>http://observatorio.wash.net.br/superinterface/autophp/backoffice.html</code><a href="http://observatorio.wash.net.br/superinterface/autophp/backoffice.html" target="_blank">Visitar</a>
</div><br>


</ul>
<p>
O diagrama abaixo mostra as 3 formas de acessar  o banco   <b>doc_aldirex</b>:
</p>

<div class="centrado" style="width: 700px; height: auto">
<img class="centrado" src="../su_docs/super_diagrama_doc_aldirex_correto_geo_base.png" width="700px">
</div>
<p>
Seja qual for a forma de visualização, o importante é garantir a estruturação dos dados, porque isso dará o alicerce sólido para a análise do acervo da Lei Aldir Blanc. Métodos NoSQL conferem rapidez ao tratamento de dados, mas geram imprecisões típicas da falta de estruturação de dados. 

Em razão da estrutura de dados da base <b>doc_aldirex</b> mudar constantemente durante o desenvolvimento, é preciso criar uma forma automática de gerar o CRUD, evitando re-trabalho de codificação da plataforma.
</p>

<p>
Assim, a Plataforma PotLatch é criada automaticamente a partir do "schema" da base de dados <b>doc_aldirex</b>, sem a necessidade de intervenção humana.
</p>

<p>
 <b>IMPORTANTE:</b> a   <i>Giramundônics</i> não é criada automaticamente. Apenas o código presente no diretório  <i>autophp</i> é criado automaticamente.
</p>


<h2 id="finalidade">Finalidade da Potlatch</h2>

<p>
A <i>Potlatch</i> visa criar um instrumento para registrar o histórico da Lei Aldir Blanc no banco de dados (neste primeiro momento criamos o <b>doc_aldirex</b>), identificando atores, autoridades e instituições fundamentais para a consolidação da política. O objetivo também é estabelecer um instrumento para a busca de dados no acervo, para que o público possa ter a melhor visibilidade sobre como esta política foi criada. 
</p>

<p>
Não podemos esquecer que a equipe do observatório já desenvolveu uma plataforma geo-referenciada para a apresentação de dados da política, a qual já está em operação. No entanto, a  <i>Potlatch/doc_aldirex</i> tem um objetivo diferente, podendo contribuir para o georeferenciamento dos dados.
</p>


<p>


Dentre os dados que se desejam disponibilizar através da <i>Potlatch</i> estão:
</p>

<ul>
	<li>Instituições que atuaram na consolidação da lei
		</li>
			<li>Parlamentares-chave na consolidação da lei
				</li>
					<li>Autoridades que atuaram 
						</li>
							<li>Empresas e entidades beneficiadas
								</li>
									<li>Valores destinados para cada entidade
										</li>
											<li>Distribuição geográfica de valores
												</li>
													<li>Identificação da atuação da sociedade civil
														</li>
															<li>Registro de indicadores de execução da política (e.g. número de editais, número de participantes, etc)
																</li>



</ul>

<p>
Sempre que possível, a coleta do acervo e a identificação desses dados no acervo deve ser automatizada.
</p>


<p>
A ideia central na criação da <i>Potlatch</i> foi automatizar o sistema de coleta do acervo da Lei Aldir Blanc, utilizando para isso ferramentas de tratamento de texto para identificar os seguintes  elementos nos documentos do acervo:
</p>

<ul>
	<li>
		Nomes das cidades
	</li>
	<li>
		Nomes próprios
	</li>
	<li>
		Nomes de instituições
	</li>
		<li>CPFs e CNPJs das pessoas e das instituições concedentes e beneficiárias dos incentivos
			</li>
				<li>Valores concedidos
					</li>
						<li>Características dos editais da LAB
							</li>




</ul>

<p>
Abaixo vemos um diagrama simplificado da forma como o Potlatch coleta dados da rede:
</p>


<div class="centrado" style="width: 700px; height: auto">
<img class="centrado" src="../su_docs/super_diagrama_entrada_de_dados_correto.png" width="700px">
</div>

<p>
O diagrama não mostra a coleta de dados de CNPJ e CPF, nem a parte referente a "Características dos Editais", que é a parte mais desafiadora.
</p>


<p>
Várias ferramentas de automatização estão sendo avaliadas e utilizadas para que o Potlatch consiga fazer essa coleta de dados, inclusive:
</p>


<ul>
	<li>
		Ferramentas de tratamento de texto convencionais (<i>sed, regexp, grep, awk, head, tail, cat</i>, entre outras)
	</li>
	<li>
		Ferramentas de análise de linguagem natural (<i>Unitex</i>)
	</li>
	<li>
		Ferramentas baseadas em algoritmo genético (desenvolvimento próprio)
	</li>

</ul>

<p>
Destas 3 abordagens, a mais madura é a primeira e já vem sendo usada amplamente para gerar parte dos metadados da plataforma <i>Potlatch</i>. À frente este documento traz os  <i>scripts</i> referentes ao uso das ferramentas  <i>sed</i>,  <i>awk</i>, entre outras. 

</p>
<p>
A plataforma UNITEX foi testada nas suas funções básicas, mas ainda existem problemas para a integração dela à <i>Potlatch</i>. A última ainda está num campo exploratório, embora um primeiro algoritmo de teste tenha sido implementado e testado.
</p>

<p>
Esses dados serão utilizados para que o usuário possa fazer <b>buscas contextualizadas</b> e <b>buscas geolocalizadas</b>, através das plataformas  <i>Giramundônics</i> e  <i>Geo</i>, já desenvolvidas.
</p>

<h2 id="operacao_interface">Descrição da interface do <i>Potlatch</i> e do Giramundônics</h2>

<p>
Uma descrição detalhada sobre as características da interface do <i>Potlatch</i> e do <i>Giramundônics</i> pode ser encontrada em:
</p>

<iframe width="560" height="315" src="https://www.youtube.com/embed/t2xZZAy--AE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<p>
O vídeo acima trata também das tarefas de curadoria a serem realizadas com a plataforma, mas ao mesmo tempo dá uma boa noção do funcionamento das interfaces do <i>Giramundônics</i> e do <i>Potlatch</i>.
</p>


<h2 id="criacao">Criação automática da <i>Potlatch</i> a partir da Super_interfaces</h2>

<p>
A criação da <i>Potlatch</i>, a partir da  <b>doc_aldirex</b>, é feita pela Plataforma Super_Interfaces, que é um código em PHP/Javascript o qual, a partir do nome do banco de dados presente no MySQL, gera os arquivos PHP pertinentes à Plataforma <i>Potlatch</i>. O Super_Interfaces "roda" no WebBrowser e o nome do banco de dados é passado na URL como parâmetro. A Plataforma Super_Interfaces está em sua versão 5.7.
</p>

<div class="centrado" style="width: 700px; height: auto">
<img class="centrado" src="../su_docs/super_diagrama_criacao_potlatch.png" width="700px">
</div>

<p>
O diagrama acima mostra que toda a criação da  <i>Potlatch</i> é baseada num único arquivo  <i>bash</i>, ou seja, um script do sistema   <i>Linux</i>. Esse arquivo é chamado  <b>gera_sql.bash</b> e fica localizado no diretório  <i>/acervo</i>. Esse arquivo será mostrado mais adiante.
</p>



<p>
Uma revisão dos objetivos e características gerais da Plataforma Super_Interfaces pode ser encontrada no vídeo que descreve a sua primeira versão:
</p>

<iframe width="560" height="315" src="https://www.youtube.com/embed/Akathw3nVcs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<p>
Esse vídeo discute os motivos pelos quais criar um CRUD através do <i>Super_Interfaces</i> é necessário, mesmo considerando a possibilidade de entrada de dados por meio de ferramentas como <i>PHPMyAdmin</i>.
</p>


<p>
A Super_Interfaces é capaz de "ler" a lista de tabelas do banco de dados através de seu <i>schema</i>, identificando suas características e, principalmente, as chaves externas das diversas tabelas, criando uma interface para realizar as tarefas "CRUD" sobre o banco de dados  <b>doc_aldirex</b>.
</p>

<p>
Portanto, a Super_Interfaces cria toda a interface da plataforma automaticamente a partir do  <i>schema</i> do banco  <b>doc_aldirex</b>. A interface do CRUD criada (no caso o Potlatch) é codificada em PHP, que "roda" no servidor que tem acesso à base de dados. Esse mesmo código PHP é responsável por entregar os códigos HTML e Javascript que "rodarão" no lado do client. A Plataforma Super_Interfaces ainda não é capaz de gerar as interfaces de autenticação do sistema.
</p>

<h2 id="caracteristicas">Características do Servidor necessárias para executar a Super_Interfaces</h2>

<p>
Para rodar todos os elementos descritos até agora o servidor deve estar configurado na configuração  <i>L.A.M.P.</i>, ou seja:  <i>Linux</i>, <i>Apache</i>, <i>MySQL</i> e  <i>PHP</i>, como detalhado a seguir:
</p>


<ul>
	<li>
		O Banco de Dados precisa estar presente no MySQL, com as permissões adequadas e as características especiais que descreveremos a seguir
	</li>
	<li>
		O servidor deve ter um APACHE "rodando", com capacidades PHP e o PHP deve ter como acessar o MySQL
	</li>
	<li>
		A plataforma deve ter um diretório principal que normalmente deve ser um subdiretório de /var/www/html, que é o diretório onde ficam as páginas que podem ser acessadas pelo APACHE 
	</li>


	<li>
		O Diretório onde a plataforma vai ser criada deve conter três subdiretórios:
	</li>
			<ul>
				<li>
					<i>/autophp</i>: este diretório conterá os arquivos PHP e HTML gerados pela Super_Interfaces
				</li>
				<li>
					<i>/imagens</i>: todos os arquivos de imagens e PDF são armazenados pelo sistema nesse diretório
				</li>
				<li>
					<i>/sql</i>: é onde os scripts SQL que criam a base são armazenados. O Sistema também tem um organizador de scripts SQL, mas não vamos usar isso por enquanto.
				</li>
				<li>
					O código fonte do Super_Interfaces deve estar no diretório um nível acima de <i>/autophp</i>, ou seja, na pasta do sistema logo abaixo de  <i>/var/www/html</i>
				</li>


			</ul>

	<li>
		Um cuidado especial com as permissões de acesso aos subdiretórios acima deve ser tomado, para garantir que o APACHE/PHP tenha acesso aos arquivos dos 3 subdiretórios. Um diagrama da estrutura de diretórios do sistema pode ser visto mais à frente.
	</li>

</ul>

<p>
Se todos estes elementos estiverem presentes, basta chamar o código da Super_Interfaces através de um Browser, usando o nome do arquivo do código fonte do Super_Interfaces seguido pelo nome do banco de dados no URL do browser, como segue:
</p>

<div class="codigo centrado">
<code>http://observatorio.wash.net.br/dev_vitor/aldir_5_7_super_interfaces.php?banco=doc_aldirex
</code>
<a href="http://observatorio.wash.net.br/dev_vitor/aldir_5_7_super_interfaces.php?banco=doc_aldirex">Entrar</a>
</div>

<p>
Como se vê, a chamada acima traz como parâmetro <b>?banco=</b> o nome da base de dados presente no MySQL: <b>doc_aldirex</b>.
</p>

<p>
Importante frisar que basta chamar o URL acima no browser e todos os arquivos do diretório PHP serão reescritos, perdendo a plataforma anterior. O sistema não tem um pedido de confirmação: chamou, toda a plataforma já está re-escrita.
</p>

<p>
Uma vez criada a plataforma pelo Super_Interfaces, basta usar o seguinte URL para chamá-la:
</p>

<div class="codigo centrado">
<code>http://observatorio.wash.net.br/dev_vitor/autophp/backoffice.html
</code>
<a href="http://observatorio.wash.net.br/dev_vitor/autophp/backoffice.html">Entrar</a>
</div>

<p>
Agora vamos ver como deve ser o banco de dados <b>doc_aldirex</b> para que a Plataforma Super_Interfaces consiga criar o sistema de interface.
</p>

<h2 id="diretorios">Estrutura de Diretórios do Sistema</h2>

<p>
A estrutura de diretórios do sistema pode ser vista no diagrama a seguir:
</p>

<div class="centrado" style="width: 700px; height: auto">
<img class="centrado" src="../su_docs/super_diagrama_estrutura_diretorios.png" width="700px">
</div>

<p>
A descrição de cada diretório está na tabela abaixo:
</p>



<table class="padrao">
	<tr>
		<th  class="padrao" style="width: 15%">
		Diretório
		</th>
		<th  class="padrao" style="width: 60%">
		Descrição
		</th>
		<th  class="padrao">
		Arquivos principais
		</th>
	</tr>
	<tr>
		<td  class="padrao" style="width: 15%">
		 <i>/dev_vitor</i>
		</td>
		<td  class="padrao">
		É o diretório de desenvolvimento do sistema que contém todos os arquivos necessários para rodar o sistema. Este diretório tem que estar logo abaixo de  <i>/var/www/html</i>
		</td>
		<td  class="padrao">
		Super_Interfaces (versão 5.7 exlusiva para Aldir Blanc)
		</td>
	</tr>
	<tr>
		<td  class="padrao">
		<i>/acervo</i>
		</td>
		<td  class="padrao">
		Contém todo o acervo de arquivos original, que está organizado em subdiretórios, seguindo a estrutura criada pela Mirza.
		</td>
		<td  class="padrao">
		 <b>gera_sql.bash</b><br>
		 (outros scripts)
		 (subdiretórios contendo acervo)
		</td>
	</tr>
	<tr>
		<td  class="padrao">
		<i>/autophp</i>
		</td>
		<td  class="padrao">
		Contém os arquivos criados automaticamente pela plataforma  <i>Super_Interfaces</i>.  <b>Atenção:</b> não altere esses arquivos porque eles serão atualizados automaticamente.
		</td>
		<td  class="padrao">
		 <b>backoffice.html</b><br>
		 <b>backoffice_aldir_entrada_principal.html</b><br>

		 (outros scripts)
		 (subdiretórios contendo acervo)
		</td>
	</tr>
	<tr>
		<td  class="padrao">
		<i>/imagens</i>
		</td>
		<td  class="padrao">
		É o diretório para onde a plataforma  <i>Potlatch</i> direciona os arquivos de imagens que são  <i>uploaded</i> para a plataforma. Neste diretório estão os arquivos texto que foram obtidos a partir da aplicação da ferramenta  <b>pdftotext</b>. Além disso contém os arquivos de texto que foram tratados a partir dos vários  <i>script bash</i> que também estão nesse diretório.
		</td>
		<td  class="padrao">
		(blocos de arquivos TXT tratados a partir dos arquivos PDF)<br>
		(arquivos  <i>bash</i>		que tratam os arquivos TXT)<br>
		(arquivos <i>sql</i> temporários, criados a partir dos arquivos  <i>bash</i>)
		</td>
	</tr>
	<tr>
		<td  class="padrao">
		<i>/sql</i>
		</td>
		<td  class="padrao">
		É o diretório para guardar as várias versões do script SQL gerado pelos  <i>mysqldump</i> da base. Há que se avaliar se não seria o caso de colocar o  <b>gera_sql.bash</b> aqui.
		</td>
		<td  class="padrao">
		(backups da base  <b>doc_aldirex</b> obtidos por meio de  <i>mysqldump</i>)
		</td>
	</tr>
	<tr>
		<td  class="padrao">
		<i>/lista_de_nomes</i>
		</td>
		<td  class="padrao">
		É um diretório de suporte ao sistema, onde estão os arquivos referentes ao levantamento dos nomes próprios do Brasil. O trabalho de levantamento dos nomes próprios do Brasil é feito através de listas de aprovados e inscritos em concursos públicos que estão publicas na rede. Esses arquivos (em geral PDF) são baixados, convertidos em TXT e os nomes próprios são extraídos para uma biblioteca de nomes próprios. Os arquivos da Lei Aldir Blanc são cruzados com esses nomes próprios através de uma  <i>stored procedure</i> integrada à base  <b>doc_aldirex</b>. A rigor esse diretório é só de suporte e não é usado pela base de dados durante a execução porque todos os nomes próprios coletados por esse meio já estão numa tabela do banco  <b>doc_aldirex</b>.
		</td>
		<td  class="padrao">
		(arquivos PDF baixados da rede)
		(arquivos HTML baixados da rede)
		(arquivos TXT convertidos a partir dos arquivos PDF)
		(arquivos CSV convertidos a partir dos arquivos TXT)
		(etc.)
		</td>
	</tr>
	<tr>
		<td  class="padrao">
		<i>/downloads_wget</i>
		</td>
		<td  class="padrao">
		É o diretório onde os arquivos do acervo que foram trazidos da rede ficam temporariamente armazenados. Os arquivos são analisados enquanto estão nesse diretório e depois  <b>movidos</b> para o diretório  <i>/imagens</i>
		</td>
		<td  class="padrao">
		(arquivos PDF e HTML recém baixados da rede candidatos a serem incluídos no acervo)
		(alguns scripts de automatização de busca de arquivos na rede)
		</td>
	</tr>
</table>


<h2 id="banco_de_dados">Características do Banco de Dados</h2>

<p>
Para que a Plataforma Super_Interfaces consiga gerar a Plataforma <i>Potlatch</i> automaticamente, é necessário que o banco de dados <b>doc_aldirex</b> tenha algumas características especiais.
</p>

<p>
O principal cuidado é na nomeação dos campos da plataforma <b>doc_aldirex</b>, que precisa seguir uma nomeação especial para que a Super_Interface consiga reconhecer os campos que serão usados para mostrar dados em <i>drop-boxes</i>, no caso de tabelas externas. Embora o <i>Schema</i> do MySQL forneça quais campos são do tipo chave primária, optou-se por usar um nome especial no caso de chaves primárias, também, como forma de ter um pouco mais de flexibilidade. Outro campo importante é o que aponta para arquivos de imagens ou PDFs. A <i>Potlatch</i> não guarda campos BLOBS, mas simplesmente aponta para os arquivos de imagens que são armazenados em um diretório especial. Desta forma temos a seguinte convenção:
</p>

<ul>
		<li><b>id_chave_</b>tal: o campo da chave primária da tabela sempre se inicia com <i>id_chave_</i>, seguido do nome da tabela no singular
			</li>
				<li><b>nome_</b>tal: o campo que se inicia com <i>nome_</i> indica qual campo da tabela externa será mostrado em <i>drop boxes</i>, quando uma tabela tem uma relação do tipo "1 para N" ou "N para N" com outra tabela
					</li>
						<li><b>photo_filename_</b>tal: indica o campo que conterá o <i>path</i> do arquivo de imagem relacionado a aquele campo
							</li>
</ul>

<h2 id="boas">Boas práticas na nomeação de Tabelas e Campos</h2>

<p>
Para facilitar a memorização dos nomes das tabelas e seus derivados (nomes de campos), foi criada uma uniformização na nomeação de tabelas que não é obrigatória, mas simplesmente facilita o trabalho em equipe.
</p>

<p>
As tabelas têm seus nomes no plural, para indicar o caráter coletivo dos dados de uma tabela (conjunto de registros). Assim, estão presentes na base de dados <b>doc_aldirex</b> as seguintes tabelas:
</p>

<ul>
	<li>Documentos: quarda os documentos do acervo
		</li>
			<li>Registrados: guarda os nomes de todos os stake-holders do acervo (signatários, destinatários de documentos, beneficiários do programa, curadores, staff do observatório)
				</li>
					<li>Tipos_de_Documentos: guarda todos os tipos de documentos
						</li>
							<li>Cidades: guarda todas as cidades do Brasil
								</li>

</ul>

<p>
Embora o uso de maiúsculas na primeira letra do nome da tabela seja encorajado (exceto para preposições), existem questões associadas à transição dos nomes nas várias versões do MySQL, com diferentes configurações de sensibilidade de <i>case</i>. Portanto, por simplicidade adotou-se a prática de todos os nomes, seja de campos ou de tabelas, serem em minúscula, com algum prejuízo para a legibilidade.
</p>

<p>
Os nomes de tabelas e campos se vale de <i>underscore</i> para separar as palavras. Essa abordagem facilita a legibilidade, mas é importante tomar cuidado quando um nome de tabela com <i>underscore</i> aparece numa busca do tipo <code>select * from table where campo <b>like</b> "tal_tal_tal"</code>. A questão é que numa busca com <i>like</i> o <i>underscore</i> é um <i>wildcard</i>, gerando resultados de busca imprevisíveis. O cuidado é buscar por <i>scape characters</i> que tirem essa característica do <i>underscore</i> no caso de uma busca com <i>like</i>.
</p>

<p>
O nome dos campos segue também algumas práticas:
</p>

<ul>
	<li>Para os nomes reservados de campos, tais como <b>id_chave_</b>, <b>nome_</b> e <b>photo_filename_</b>, com o nome da tabela é incluido no nome do campo, mas no singular:
	<ul>
		<li>A chave primária da tabela <i>Documentos</i> fica: <i>id_chave_documento</i>
			</li>
				<li>O campo de nome da tabela <i>Registrados</i> fica: <i>nome_registrado</i>
					</li>
						<li>O campo que aponta para os arquivos de imagens da tabela <i>Tipos_de_Documentos</i> fica: <i>photo_filename_tipo_de_documento</i>
							</li>

	</ul>

		<li>Para os nomes de campos externos estes devem ser iniciados com <b>id_</b> seguido do nome da tabela no singular, como segue:
			</li>
			<ul>
				<li>O campo externo da tabela <i>Documentos</i> que aponta para a chave primária da tabela <i>Tipos_de_Documentos</i> fica: <i>id_tipo_de_documento</i>
					</li>
						<li>O campo externo da tabela <i>Registrados</i> que aponta para a chave primária da tabela <i>Cidades</i> ficaria: <i>id_cidade</i>
							</li>
						
			</ul>

	
		
</ul>

<h2 id="estrutura">Tabelas da Base doc_aldirex</h2>

<p>
A estratura de dados da base <b>doc_aldirex</b> visa guardar dados sobre o acervo da Lei Aldir Blanc, bem como links para os arquivos do acervo.
</p>

<p>Para isso foi preciso especificar uma base de dados com as seguintes tabelas:
</p>

<div class="codigo centrado">
<code>+------------------------------+
| Tables_in_doc_aldirex        |
+------------------------------+
| Ordem_de_Criacao             |
| cidades                      |
| classificacoes_de_documentos |
| csss_classes                 |
| csss_tags                    |
| descricoes_das_interfaces    |
| documentos                   |
| documentos_cidades           |
| documentos_classificacoes    |
| documentos_instituicoes      |
| documentos_registrados       |
| documentos_signatarios       |
| documentos_tokens            |
| elementos_classes            |
| estados                      |
| estilos                      |
| gc                           |
| instituicoes                 |
| interfaces                   |
| lista_de_campos              |
| listas_de_tabelas            |
| names_do_brasil              |
| nomes_de_cidades             |
| paises                       |
| registrados                  |
| regras_de_validacao          |
| tabelas_de_ligacao           |
| tabelas_para_o_usuario       |
| temp_atribui                 |
| temp_atribui2                |
| temporario                   |
| tipos_de_documentos          |
| tipos_de_logradouros         |
| tokens_no_acervo             |
+------------------------------+
</code>
</div>

<h2 id="tipos_de_tabelas">Tipos de Tabelas da base doc_aldirex</h2>

<p>
Existem três tipos principais de tabelas:
</p>

<table class="padrao">
	<tr>
		<th  class="padrao">
			Tipos
		</th>
		<th  class="padrao">
			Exemplos
		</th>

	<tr>
		<th  class="padrao">
			Tabelas de dados sobre o acervo
		</th>
		<td  class="padrao">
			Documentos, Cidades, Estados, Países, Registrados, Tipos_de_Documentos, Names_do_Brasil, Instituições, etc.
		</td>
	</tr>
	<tr>
		<th  class="padrao">
			Tabelas de controle da interface
		</th>
		<td  class="padrao">
			Csss_Classes, Csss_Tags, Gc, Ordem_de_Criacao, Lista_de_Campos, Lista_de_Tabelas, Tabelas_para_o_Usuario, etc.
		</td>
	</tr>
	<tr>
		<th  class="padrao">
			Tabelas de Ligação (cardinalidade de N para N)
		</th>
		<td  class="padrao">
			Documentos_Tokens, Documentos_Registrados, Documentos_Signatarios, Documentos_Instituicoes, Documentos_Cidades, etc. 
		</td>
	</tr>

</table>

<h2 id="descrica_das_tabelas">Descrição das Tabelas da base doc_aldirex</h2>

<p>
Abaixo vemos uma descrição apenas das <b>"Tabelas de dados sobre acervo"</b>:
</p>


<table class="padrao">
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"SELECT table_name,',',  table_comment FROM INFORMATION_SCHEMA.TABLES WHERE table_schema='doc_aldirex' and table_comment >''; \" | awk 'BEGIN{FS=\",\"}{print \"<tr><td class=".'\\"'."padrao".'\\"'.">\"$1\"</td><td class=".'\\"'."padrao".'\\"'.">\"$2\"</td></tr>\"}'"); ?>
</table>

<p>
A descrição acima é dinâmica e tem origem nos meta-dados da própria base <b>doc_aldirex</b>.
</p>

<h2 id="lista_de_campos">Lista de Campos da base doc_aldirex</h2>

<p>
Abaixo temos uma lista de todos os campos de todas as tabelas:
</p>

<table class="padrao">
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"select table_name,',', column_name from information_schema.columns where table_schema = 'doc_aldirex' order by table_name,ordinal_position;\" | awk 'BEGIN{FS=\",\"; name=\"\"}{if(name==$1){print \"<tr><td></td><td>\"$2\"</td></tr>\";}else{print \"<tr class=".'\\"'."padrao".'\\"'." ><td></td><td></td></tr><tr><td>\"$1\"</td><td>\"$2\"</td></tr>\";} name=$1;}'"); ?>

</table>

<h2 id="geracao">Geração da base doc_aldirex por meio do gera_sql.bash</h2>

<p>
A ferramenta original de geração da base de dados <b>doc_aldirex</b> é um arquivo bash que cria um sequência de texto em SQL para gerar a base (i.e. <i>script SQL</i>). O nome do arquivo é <b>gera_sql.bash</b> e fica localizado no diretório  <i>/acervo</i>. O código fonte desse arquivo pode ser visto <a href="./acervo/gera_sql.bash">aqui</a>. A saída do arquivo é um texto na tela do terminal que pode ser redirecionada para um arquivo com:
</p>

<div class="codigo centrado">
<code>./gera_sql.bash &gt executa_doc_aldirex.sql
</code>
</div>

<p>
De posse do arquivo <i>executa_doc_aldirex.sql</i> é possível gerar a base com o comando:
</p>

<div class="codigo centrado">
<code>mysql -u vitor -psenha doc_aldirex < executa_doc_aldirex.sql 
</code>
</div>


<p>
Vê-se que o código fonte começa com:
</p>

<div class="codigo centrado">
<code>DROP DATABASE IF EXISTS doc_aldirex;
</code>
</div>

<p>
Esse <i>DROP DATABASE</i> significa que ao executar o <i>script SQL</i> gerado por <b>gera_sql.bash</b>, o banco <b>doc_aldirex</b> será apagado. Portanto, é muito importante gerar um backup dos dados da base <b>doc_aldirex</b> antes de criar uma nova base com <b>gera_sql.bash</b>. O comando para fazer um <i>backup</i> da base pode ser um <b>mysqldump</b>, como segue:
</p>

<div class="codigo centrado">
<code>mysqldump -u vitor -psenha doc_aldirex &gt backup_doc_aldirex_2021_05_21b.sql
</code>
</div>

<p>
Mas esse comando baseado em <b>mysqldump</b> vai levar a estrutura da base junto para o arquivo de backup do <i>script SQL</i>. Então pode ser difícil conciliar o <b>gera_sql.bash</b> com um dump da base, porque dependendo da mudança na estrutura da base feita por <b>gera_sql.bash</b>, pode ser impossível colocar os dados da base antiga na nova. Em alguns casos é possível fazer esse ajuste no <i>script SQL</i> originário do <b>mysqldump</b> usando <i>sed</i>, <i>awk</i> e <i>grep</i>. 
</p>

<p>
De qualquer forma, é importante manter o <b>gera_sql.bash</b> sempre atualizado, porque às vezes é feito algum teste de alteração da base no prompt do MySQL que acaba se consolidando na estrutura de dados, e essa alteração precisa ser registrada no  <b>gera_sql.bash</b>. Se essa alteração não for registrada no  <b>gera_sql.bash</b>, na próxima vez que ele for executado o  <i>script SQL</i> gerado pode estar desatualizado.
</p>

<div class="codigo centrado">
<code>alter table cidades comment='Contém todas as cidades brasileiras, <br>com dados demográficos originários do IBGE. <br>Tem uma chave externa para o Estado, uma vez que o Brasil tem cidades homônimas, mas para estados diferentes.';
</code>
</div>

<h2 id="baixar">Como baixar o acervo da Lei Aldir Blanc da internet</h2>

<p>
Existem muitas estratégias para baixar os arquivos da Lei Aldir Blanc da internet. A utilizada até agora foi baseada no uso do <b>wget</b>. Esse comando é usado para baixar os arquivos <i>PDF</i>. Há uma série de opções e parâmetros que precisam ser utilizados para otimizar o uso do <b>wget</b> para download de <i>PDFs</i>.
</p>

<p>Uma outra estratégia utilizada foi o emprego do <b>lynx</b>, que permite automatizar algumas tarefas simples de busca de arquivos na web.
</p>

<p>
Finalmente tentou-se configurar o <b>scrapy</b> para criar <i>crawlers</i> ou <i>spiders</i>, mas esbarrou-se na complexidade de configuração do <i>python</i>. Durante a instalação verificou-se que alguma versão do <i>python</i> não estava corretamente instalada e não se conseguiu "rodar" o <b>scrapy</b>.
</p>

<p>
Uma das atividades que precisam ser realizadas nas próximas etapas do projeto é automatização de busca de arquivos sobre a Lei Aldir Blanc, principalmente no que se refere à concessão de recursos, editais, etc.
</p>

<p>
Para esse intuito, há que se retomar a criação do  <i>crawler</i> e do  <i>spider</i>, razão pela qual alguma energia precisa ser direcionada para a busca de arquivos na rede automatizadamente.
</p>


<h2 id="arquivos_imagens">Arquivos de imagens e PDFs e seu upload</h2>

<p>
Do ponto de vista do usuário final, é conveniente que as ferramentas de visualização, a exemplo da Giramundônics, ofereçam acesso facilitado para as imagens do acervo de documentos. Por esse motivo, é necessário armazenar o acervo no servidor.
</p>
<p>


O formato preferido para essa armazenagem é o <i>PDF</i>. Esses arquivos ficam guardados no diretório <i>/imagens</i>. A bem da verdade, o PDF não poderia ser chamado de imagem, uma vez que é efetivamente um documento (que pode conter imagens). Mas para os fins desse texto, podemos considerar o PDF como "imagem", no sentido de que a função dele é prover uma imagem do documento original do acervo.
</p>

<p>
É razoável esperar que a maior parte dos documentos do acervo estejam no formato PDF, um formato bastante confortável para o usuário. Para fins de otimização da energia de programação, decidiu-se concentrar o esforço no uso de arquivos PDF, muito embora a <i>Potlatch</i> permita subir qualquer tipo de arquivo.

</p>
<p>

Qualquer tipo de arquivo pode ter <i>upload</i> através da Potlatch, mas só é garantido que a plataforma consiga mostrar PDF, PNG, JPG e GIF. O compartamento de outros tipos de arquivos ainda não foi testado. Posteriormente é possível avaliar o uso de outros formatos.
</p>


<p>
O HTML tem, também, facilidades para exibir arquivos PDF nos web browsers de <i>desktops</i>, razão pela qual também do ponto de vista da programação essa concentração em PDF seja bastante razoável. No caso de <i>web browsers</i> dos <i>mobiles</i> (Safari, Chrome do Android, etc.) a história é um pouco diferente, dado que não existe uma forma interativa de mostrar PDFs no celular. No celular, sempre que o usuário quer ver um PDF, é aberta uma página separada, atrapalhando a navegação. A solução dada para o caso de <i>mobiles</i> será detalhada à frente.
</p>

<p>
Uma característica do PDF é que ele pode ser facilmente convertido em formato texto, através de ferramentas tais como <b>pdftotext</b> do command line do linux. Uma vez convertido para texto, fica muito mais fácil aplicar os algoritmos de busca de palavras almejados neste projeto.
</p>

<p>
A forma como os arquivos são submetidos a <i>upload</i> através da <i>Potlatch</i> é descrita no vídeo abaixo (veja 3min 57seg): 
</p>

<iframe width="560" height="315" src="https://www.youtube.com/embed/paS5ww9gVoA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<h2 id="conteudo_imagens">Descrição do diretório /imagens</h2>

<p>
O arquivo de "imagem" (normalmente um PDF) que foi <i>uploaded</i> é gravado no diretório <i>/imagens</i>. Nesse diretório ficam todos os arquivos pertinentes ao acervo. Talvez esse diretório não devesse ser chamado <i>/imagens</i>, porque ele contém outros tipos de arquivos, além de imagens. Mas por razões históricas acabou ficando assim. Mas devemos pensar que o diretório <i>/imagens</i> contém o acervo da Lei Aldir Blanc, já tratado pelas ferramentas que identificam:
</p>

<ul>
	<li>Nomes de Cidades
		</li>
			<li>Nomes Próprios
				</li>
					<li>Nomes de Instituições
						</li>
	<li>etc
		</li>


</ul>


<p>
A cada etapa de tratamento dos dados, um novo arquivo é gerado no diretório <i>/imagens</i>. No presente esse tratamento é feito através dos arquivos <i>bash</i> que estão, principalmente, nos subdiretórios <i>/imagens</i> e <i>acervo</i>.
Abaixo vemos uma tabela com uma contagem da quantidade de arquivos no diretório <i>/imagens</i>, por formato de arquivo.
</p>

<table class="padrao">
<tr class="padrao"><th>Extensão</th><th>quantidade</th></tr>
<?php echo shell_exec("ls -1 ./imagens | awk 'BEGIN{FS=\"\.\"}{if (length($2)<6)print $2}' | sort | uniq -c | sort -nr -k 1,1 | awk '{print \"<tr class=".'\\"'."padrao".'\\"'."><td>\"$2\"</td><td>\"$1\"</td></tr>\"}'"); ?>
</table>

<p>
Note que há uma grande variedade de extensões, e isso se deve ao fato de ser um ambiente de desenvolvimento. No ambiente de produção esse diretório terá apenas arquivos PDF, JPG e TXT.
</p>

<p>
Vejamos o papel de cada um desses formatos no diretório <i>/imagens</i>:
</p>

<table class="padrao">
	<tr>
		<th  class="padrao">
			Formato

		</th>
		<th  class="padrao">
			função
		</th>
	</tr>
	<tr>
		<td  class="padrao">
			PDF
		</td>
		<td  class="padrao">
			Guarda cópia fidedigna do documento original do acervo da Lei Aldir Blanc, conforme foi "baixada" da internet. Permite que o usuário conheça o documento no formato original, com possibilidade de busca de palavras chave, etc, que só funciona direito no <i>desktop</i>, porque os   <i>browsers</i> de <i>mobiles</i> não têm leitores de PDF embarcados.
		</td>
	</tr>
	<tr>
		<td  class="padrao">
			TXT
		</td>
		<td  class="padrao">
			Contém texto derivado do conteúdo do arquivo PDF. Normalmente esse arquivo texto é obtido a partir do PDF por meio do comando <i>pdftotext</i>. A versão gerada no formato texto não contém imagens ou qualquer outra forma de informação que não possa ser codificada em caráters "ascii". Além do arquivo txt que foi diretamente  convertido a partir do arquivo PDF, há outros obtidos indiretamente a partir de scripts BASH, que fazem tratamento do texto gerado pelo comando <i>pdftotext</i>. Um scrip bash é uma pequeno programa que faz transformações em arquivos. 
		</td>
	</tr>
	<tr>
		<td  class="padrao">
			JPG
		</td>
		<td  class="padrao">
			Para que seja possível mostrar o acervo no celular de forma dinâmica, é preciso ter um versão do arquivo PDF em JPG. Isso porque o celular não tem um componente HTML adequado para <i>embed</i> um arquivo PDF. Normalmente, no celular, é preciso abrir o arquivo PDF numa página de browser separada da atual. Essa limitação dificulta a interatividade da plataforma de visualização (no caso, do Giramundônics). Então é preciso ter cópia do arquivo PDF num formato JPG. Como essa cópia ocuparia muito espaço do servidor, optou-se por converter para JPG apenas a primeira página do PDF. Claro que isso limita um pouco a experiência do usuário no dispositvo mobile, mas é a melhor solução encontrada. No dispositivo desktop não há necessidade desse <i>hack</i>, porque existem elementos HTML disponíveis para mostrar PDF de uma forma interativa.

		</td>
	</tr>
	<tr>
		<td  class="padrao">
			bash, csv, frag, php, etc.
		</td>
		<td  class="padrao">
			São formatos que estão presentes no diretório <i>/imagens</i> apenas no ambiente de desenvolvimento <i>dev_vitor</i>. No ambiente de produção não será adequado manter esses arquivos no diretório.
		</td>
	</tr>


</table>

<h2 id="blocos_de_arquivos">Blocos de Arquivos no diretório /imagens</h2>

<p>
O levantamento na  <i>web</i> de arquivos para o acervo da LAB objetiva colocar arquivos PDF pertinentes à Lei Aldir Blanc no diretório <i>/imagens</i>. Qualquer arquivo PDF que contenha informações sobre a Lei Aldir Blanc interessa.
</p>

<p>
Uma vez copiado no diretório <i>/imagens</i>, é preciso realizar o tratamento de dados nesse arquivo. Esse tratamento resultará num conjunto de arquivos que aqui chamaremos de "Bloco de Arquivos". Abaixo vemos um "Bloco de Arquivos" associado ao item do acervo "Transcricao_Live_3007": 
</p>

<div class="codigo">
<code><?php echo shell_exec("ls -1 ./imagens/Transcricao_Live_3007*"); ?>
</code>
</div>

<p>
Como esse bloco, existem outros quase 150 "Blocos de Arquivos" no diretório <i>/imagens</i>, cada um com 8 arquivos. A cada novo arquivo PDF que é gravado no diretório <i>/imagens</i> é preciso tratá-lo com um procedimento que será descrito a seguir, gerando esses 8 arquivos. Portanto, esse procedimento leva à criação de um novo bloco com vários arquivos como os mostrados.</p>

<p>
Vamos compreender a característica de arquivo do bloco mostrado e como ele é obtido:
</p>

<table class="padrao2">
	<tr>
		<th  class="padrao2" width="10%">
			extensão do arquivo
		</th>
		<th  class="padrao2" width="30%">
			objetivo
		</th>
		<th  class="padrao2" width="15%">
			bash
		</th>
		<th class="padrao2" width="40%">
			resultado da busca
		</th>
		<th class="padrao2" width="40%">
			diretorio
		</th>

	</tr>
	<tr>
		<td  class="padrao2">
			PDF
		</td>
		<td  class="padrao2">
			São os cópias PDF de arquivos originais da Lei Aldir Blanc. Esses arquivos são buscados na rede.
		</td>
		<td  class="padrao2">
			A partir da lista de URLs levantada pelos bolsistas do observatório, foi criado o seguinte arquivo de busca:<br><br>
			<a href="./imagens/bash_wget.bash">bash_wget.bash</a>
		</td>
		<td  class="padrao2">
			O resultado é um conjunto de arquivos de PDF baixados. É oportuno baixar esses arquivos num diretório temporário, para que cada arquivo PDF possa ser avaliado. Algumas vez são trazidos arquivos HTML, que por enquanto não são utilizados. Em alguns casos são trazidos arquivos de Diários Oficiais, que têm muitas páginas não relacionadas à Lei Aldir Blanc. È oportuno fazer a limpeza disso usando algum programa de separação de páginas PDF, como o <b>convert</b> do <i>ImageMagick</i> (gratuito).
		</td>
		<td  class="padrao2">
			downloads_pdf
		</td>

	</tr>
	<tr>
		<td  class="padrao2">
		txt
		</td>
		<td  class="padrao2">
		São os arquivos PDF convertidos para TXT. Os arquivos gerados têm pontuação, caracteres numéricos, formatação (<i>new lines</i>, tabs, <i>end-of-file</i>,<i>form-feed</i>, etc.). Existe uma questão que é decidir se a conversão será com a opção <i>-layout</i> ou sem. A escolha depende do tipo de formatação do arquivo PDF.
		</td>
		<td  class="padrao2">
			<a href="./imagens/gera_converte_pdf_para_txt.bash">gera_converte_pdf_para_txt.bash</a>
		</td>
		<td  class="padrao2">
			O resultado é um bash que pode ser diretamente executado para gerar os txts a partir dos PDFs:<br><br>
			<a href="./imagens/executa_converte_pdf_para_txt.bash">executa_converte_pdf_para_txt.bash</a>
		</td>
		<td  class="padrao2">
			imagens
		</td>
	</tr>
	<tr>
		<td  class="padrao2">
		com_dash
		</td>
		<td  class="padrao2">
		Esse arquivo é resultado da aplicação do primeiro tratamento para a identificação dos tokens. Todos os itens de pontuação são trocados por um #, os algarismos são eliminados, os <i>new_lines</i> são trocados por espaço, os espaços duplos são trocados recursivamente por espaço simples, os <i>form-feeds</i> são eliminados, as aspas fora do padrão utf-8 são eliminadas, os espaços são retransformados em <i>new-lines</i> (deixando um token por linha do arquivo), os # são colocados isolados em uma linha, as linhas vazias são eliminadas e o nome do arquivo é alterado para receber a extensão <i>com_dash</i>. A utilidade de colocar o # é saber onde estavam as pontuações, permitindo validar as estratégias.
		</td>
		<td  class="padrao2">
			<a href="./imagens/gera_txts_com_dashs.bash">gera_txts_com_dashs.bash</a>
		</td>
		<td  class="padrao2">
			O resultado é um bash que pode ser diretamente executado para gerar os txts tratados a partir dos txt que foram criados diretamente dos PDFs:<br><br>
			<a href="./imagens/executa_txts_com_dashs.bash">executa_txts_com_dashs.bash</a>
		</td>
		<td  class="padrao2">
			imagens
		</td>
	</tr>
	<tr>
		<td  class="padrao2">
		com_new_line
		</td>
		<td  class="padrao2">
		O objetivo deste tratamento é semelhante ao do <i>com_dash</i>: identificar os tokens dos arquivos PDF. Este tratamento é independente do <i>com_dash</i>, uma vez que parte diretamente dos arquivos <i>txt's</i> obtidos dos PDFs. A principal diferença em relação ao <i>com_dash</i> é que <i>com_new_line</i> não é usado símbolo # para indicar pontuações.
		</td>
		<td  class="padrao2">
			<a href="./imagens/gera_txts_com_new_lines.bash">gera_txts_com_new_lines.bash</a>
		</td>
		<td  class="padrao2">
			O resultado é um bash que pode ser diretamente executado para gerar os txts tratados a partir dos txt que foram criados diretamente dos PDFs:<br><br>
			<a href="./imagens/executa_txts_com_new_lines.bash">executa_txts_com_new_lines.bash</a>
		</td>
		<td  class="padrao2">
			imagens
		</td>
	</tr>
	<tr>
		<td  class="padrao2">
		sem_acentuacao<br>
		sem_new_line
		</td>
		<td  class="padrao2">
		O objetivo deste tratamento é gerar dois padrões de arquivos: 
		<ul>	
		<li>sem_acentuacao: é o arquivo txt original, obtido do PDF, mas sem acentuação
			</li>
				<li>sem_new_line: é o arquivo sem_acentuacao, sem <i>new_line</i>
					</li>

		</ul>
		</td>
		<td  class="padrao2">
			O <i>script</i> abaixo é usado para duas finalidades: gerar um script único que permite gerar os arquivos sem_acentuação e, a partir dos arquivos sem_acentuacao, gerar os arquivos sem_new_line:<br><br>
			<a href="./imagens/gera_tira_acentuacao_tira_new_line.bash">gera_tira_acentuacao_tira_new_line.bash</a>
		</td>
		<td  class="padrao2">
			O resultado é um bash que pode ser diretamente executado para gerar, de uma vez só, tanto os arquivos sem_acentucao como os arquivos sem_new_line, lembrando que o arquivo sem_new_line é gerado a partir do arquivo sem_acentuacao:
			<a href="./imagens/executa_tira_acentuacao_tira_new_line.bash">executa_tira_acentuacao_tira_new_line.bash</a>
		</td>
		<td  class="padrao2">
			imagens
		</td>
	</tr>
	<tr>
		<td  class="padrao2">
		maiuscula
		</td>
		<td  class="padrao2">
		O objetivo deste tratamento é produzir uma versão do arquivo TXT originado no PDF, mas agora sem_acentuacao, sem_new_line e com todas as letras em minúsculas. Para produzir essa versão o script usa os arquivos sem_new_line como ponto de partida, fazendo apenas a conversão de minúsculas para maiúsculas, uma vez que os arquivos sem_new_line já estão sem acentuação. Note que ter uma versão do arquivo PDF com todas as letras maiúsculas é conveniente quando se busca um nome de cidade, considerando que o nome das cidades também foram convertidos para maiúsculas. Mas pode gerar falso-positivos, dado que perdemos uma informação que costuma caracterizar um nome próprio: primeira palavra em maiúscula. Mas não tem muita saída, porque há muitos documentos nos quais os nomes de cidades  ou os nomes próprios aparecem em maiúsculas (como em listas de aprovados em editais).
		</td>
		<td  class="padrao2">
			O <i>script</i> abaixo usa os arquivos sem_new_line como base para gerar a versão com maiúsculas:<br><br>
			<a href="./imagens/gera_converte_lower_upper_case.bash">gera_converte_lower_upper_case.bash</a>
		</td>
		<td  class="padrao2">
			O resultado é um bash que pode ser diretamente executado para gerar os arquivos com apenas letras maiúsculas:
			<a href="./imagens/executa_converte_lower_upper_case.bash">executa_converte_lower_upper_case.bash</a>
		</td>
		<td  class="padrao2">
			imagens
		</td>
	</tr>

</table>

<p>
Importante ressaltar que os scripts bash da penúltima e última colunas sempre formam pares. Por exemplo:<b>gera_txts_com_dashs.bash</b> deve produzir o arquivo <b>executa_txts_com_dashs.bash</b>. Então, sempre que um arquivo começar com "gera" significa que ele será usado para gerar um arquivo "executa". É o arquivo "executa" que produz o resultado final. No presente momento, antes que se alcance a automatização do tratamento de arquivos PDF, é responsabilidade de quem está fazendo o tratamento dos arquivos textos gerar o arquivo "executa" com o comando abaixo:
</p>

<div class="codigo centrado">
<code>prompt$ ./gera_txts_com_dashs.bash &gt executa_txts_com_dashs.bash
</code>
</div>

<p>
Embora o procedimento não esteja automatizado ainda, essa automatização é relativamente simples. Hoje os <i>scripts</i> disponíveis tratam todo o conjunto de arquivos de uma vez, mas precisam ser acionados manualmente no prompt do linux. Mas em produção, será necessário tratar apenas o arquivo recém <i>uploaded</i>, o que pode ser feito no momento do <i>upload</i>, dentro de um intervalo de tempo razoável, chamado pelo código PHP e sem intervenção humana.
</p>

<p>
A abordagem de processamento escolhida é declaratória, não procedural. Assim, são usadas ferramentas consagradas como <i>sed</i> ou <i>awk</i>. Mas essa abordagem declaratória poderia ser facilmente substituída por uma estratégia procedural, que costuma ser mais prolixa. As abordagens declaratórias costumam ser muito mais fáceis de depurar, verificar resultados e garantir funcionalidades.
</p>

<h2 id="tabelas_principais">Estrutura da tabela Cidades</h2>

<p>
Vamos conhecer primeiro a estrutura da  tabela  <b>Cidades</b>, que foi obtida aplicando o comando SQL  <b>desc cidades;</b> no console do  <i>MySQL</i>:
</p>

<div class="codigo centrado">
<code>desc cidades;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"desc cidades;\" --table"); ?>
</code>
</div>

<p>
Para começar vamos analisar a chave primária. O campo da chave primária é o que aparece com <i>"PRI"</i> na coluna   <i>key</i> da descrição da estrutura da tabela. Veja que o nome desse campo começa com  <i>id_chave_</i>, que é a forma de avisar o  <i>Super_Interfaces</i> de que esse campo é chave primária. O  <i>schema</i> da tabela também poderia ser usado para avisar o  <i>Super_Interfaces</i>, mas existem razões para deixar essa indicação independente do  <i>schema</i>.
</p>

<p>
Outro campo importante é o  <i>id_estado</i>, que é uma chave externa para a tabela  <b>Estados</b>. Esse campo é importante para evitar problemas com cidades homônimas. O Brasil tem vários nomes de cidades que se repetem ao longo dos estados. Assim, ao identificar o nome do estado, é possível desambiguizar a identidade da cidade. O campo de chave externa aparece com o código  <i>MUL</i> na coluna  <i>key</i>.
</p>

<p>
Há também um campo que se inicia com  <i>nome_</i> (<i>nome_cidade</i>), indicando que esse é o nome da cidade e é também o campo que será mostrado no dropbox de uma tabela externa que faça referência à chave primária da tabela  <b>Cidades</b>. 
</p>

<p>
Os demais campos são todos atributos simples da tabela   <b>Cidades</b>, sem consequências para a estrutura relacional. Normalmente são dados de georeferenciamento, a exemplo do campo    <i>codigo</i>, ou dados oriundos do IBGE, a exemplo do campo  <i>densidade_demografica</i>.
</p>

<p>
O número de registros na tabela  <b>Cidades</b> é:
</p>

<div class="codigo centrado">
<code>select count(*) from cidades;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"select count(*) from cidades;\" --table"); ?>
</code>
</div>

<p>
Esse número está um pouco acima do número oficial de municípios no Brasil, que é de 5565 ou 5568, dependendo da fonte. Seria interessante descobrir se a tabela  <b>Cidades</b> tem algum dado equivocado. Um dos motivos para a discrepância é a presença do Distrito Federal na lista, que em algumas contagens não é considerado como município. 
</p>

<h2 id="estrutura_documentos">Estrutura da tabela Documentos</h2>

<p>
A tabela  <b>Documentos</b> é a tabela central da base  <b>doc_aldirex</b>. É ela que registra o  <i>path</i> e nome dos arquivos do acervo, bem como o título do documento associado ao arquivo. Vamos ver sua estrutura com o comando SQL  <i>desc</i>:
</p>

<div class="codigo centrado">
<code>desc documentos;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"desc documentos;\" --table"); ?>
</code>
</div>

<p>
A chave primária dessa tabela é  <i>id_chave_</i>documento. O nome que aparece em drop boxes de chaves externas é o que está no campo  <i>nome_</i>documento. O path para o arquivo do documento, normalmente em formato PDF, é  <i>photo_filename_</i>documento. Além disso, essa tabela tem como chaves externas os campos  <i>id_tipo_de_documento</i>, que aponta para a tabela  <b>Tipos_de_Documento</b> e  <i>id_curador</i>, que aponta para a tabela  <b>Registrados</b>.
</p>

<p>
O campo  <i>photo_filename_documento</i> é do tipo  <i>unique</i>, indicando que não podemos ter dois registros com valores desse campo iguais.
</p>

<p>
Os demais campos são atributos simples do registro de  <b>Documentos</b> e não participam da definição da estrutura relacional do banco  <b>doc_aldirex</b>.
</p>


<p>
O número de registros na tabela  <b>Documentos</b> é:
</p>

<div class="codigo centrado">
<code>select count(*) from documentos;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"select count(*) from documentos;\" --table"); ?>
</code>
</div>

<h2 id="tabela_registrados">Estrutura da tabela Registrados</h2>

<p>
A tabela registrados é aquela que contém as pessoas que têm interesse na Lei Aldir Blanc. Pode ser um beneficiário do programa, pode ser um deputado que apoia o programa, ou pode ser um artista, por exemplo. Além disso, o  <i>staff</i> do Observatório da Lei Aldir Blanc também está registrado na tabela  <b>Documentos</b>, bem como os curadores.
</p>

<p>
Vamos conhecer a estrutura da tabela  <b>Registrados</b> através do comando  <b>desc</b>:
</p>

<div class="codigo centrado">
<code>desc registrados;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"desc registrados;\" --table"); ?>
</code>
</div>

<p>
Como nos demais casos,  <i>id_chave_</i>registrado indica a chave primária e  <i>nome_</i>registrado é o nome da pessoa, que também será usado no drop box de tabelas externas. Importante notar que o campo  <i>nome_</i>registrado está com a coluna  <i>key</i> marcada com  <i>UNI</i>, indicando que dois (ou mais) registros da tabela  <b>Registrados</b> não podem ter exatamente o mesmo  <i>nome_</i>registrado.
</p>

<p>
A tabela tem 3 campos que apontam para tabelas externas:  <i>id_cidade</i>,  <i>id_estado</i> e  <i>id_pais</i>. Na verdade bastaria uma chave externa (<i>id_cidade</i>). Há um erro aqui e a estrutura desta tabela precisa ser alterada, retirando os campos  <i>id_estado</i> e  <i>id_pais</i>. O motivo é que da forma como está é possíve apontar para uma cidade de um determinado estado/país e, com id_estado, apontar para outro estado, criando uma inconsistência de dados. (CORRIGIR!)
</p>

<p>
Abaixo temos a contagem de registros da tabela  <b>Registrados</b>:
</p>

<div class="codigo centrado">
<code>select count(*) from registrados;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"select count(*) from registrados;\" --table"); ?>
</code>
</div>

<p>
Note que já temos um número expressivo de registrados. Esse número foi obtido a partir da automatização de identificação de nomes próprios. No entanto há ainda muitas incosistências, dado que a lista de nomes brasileiros, presente na tabela  <b>Names_do_Brasil</b> ainda é relativamente pequena, como se verá adiante.
</p>

<h2 id="documentos_registrados">Estrutura da tabela Documentos_Registrados</h2>

<p>
Uma das características principais da plataforma é permitir que se saiba todos os nomes próprios de pessoas presentes num documento. Para isso, existe a tabela  <b>Documentos_Registrados</b>, cuja estrutura está a seguir:
</p>

<div class="codigo centrado">
<code>desc documentos_registrados;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"desc documentos_registrados;\" --table"); ?>
</code>
</div>


<h2 id="cidades_em_PDF">Identificando as cidades num dado documento do acervo</h2>

<p>
É possível que os usuários se interessem em saber em quais documentos uma cidade é citada, ou saber quais cidades são citadas por um documento. Essa não é uma questão trivial, por vários motivos.
</p>

<p>
Como os leitores de PDF têm ferramentas de busca de palavras, a primeira solução que alguém pode imaginar para esse problema é o uso do search do leitor de PDF para encontrar o nome de uma cidade. Mas pense na busca pela cidade de  <b>Santos</b>. Santos é um nome bastante comum no Brasil e, considerando que muitos dos documentos do acervo têm listas intermináveis de nomes de beneficiários do incentivos, a simples busca pelo nome "Santos" nos documentos pode produzir uma grande quantidade de falsos positivos.
</p>

<p>
O banco  <b>doc_aldirex</b> foi estruturado para equacionar essas questões, usando uma estrutura relacional para tal. 
</p>

<p>
Há várias tabelas para permitir a identificação do contexto em que um certo nome próprio (seja de cidade ou de pessoa) está aparecendo nos texto. 
</p>

<p>
A tabela  <i>documentos_cidades</i> é preenchida a partir da aplicação dos  <i>scripts bash</i>, que identificam a presença de um nome de cidade num dado documento. Vamos ver como é a estrutura dessa tabela:
</p>

<div class="codigo centrado">
<code>desc documentos_cidades;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"desc documentos_cidades;\" --table"); ?>
</code>
</div>

<p>
Como se vê, é uma tabela que estabelece uma relação de cardinalidade N para N entre as tabelas  <b>Documentos</b> e   <b>Cidades</b>. Os campos externos  <i>id_documento</i> e  <i>id_cidade</i> é que fazem essa conexão.
</p>

<p>
Hoje esta tabela está com a seguinte quantidade de campos:
</p>


<div class="codigo centrado">
<code>select count(*) from documentos_cidades;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"select count(*) from documentos_cidades;\" --table"); ?>
</code>
</div>



<h2 id="busca_documentos_cidades">Verificando todas os nomes que parecem ser de cidades</h2>

<p>
Através dos  <i>scripts bash</i> o sistema faz uma primeira tentativa de descobrir quais cidades aparecem num certo documento. 
</p>

<p>
O sistema faz a busca dos nomes de município nos tokens do documento, inserindo os resultados na tabela  <b>Documentos_Cidades</b>. O problema é que há nomes comuns entre os nomes de município brasileiros. Um exemplo, já citado, é  <i>Santos</i>. Santos é um nome próprio comum, então é possível que o sistema aponte como se aquele documento citasse a cidade de  <i>Santos</i>, mas na verdade o nome aparece como parte de um nome próprio numa lista de pessoas selecionadas em um edital.
</p>

<p>
Outro caso é a cidade de   <i>Cláudia</i>, ou a cidade de  <i>Esteio</i>. Se houver no documento uma pessoa chamada   <i>Cláudia Santos</i>, o sistema vai achar que esse documento cita a cidade de Cláudia e também a cidade de Santos. Vamos ver como esse erro acontece, fazendo um  <i>query</i> na tabela  <i>documentos_cidades</i>.
</p>

<p>
Vamos ver um exemplo dessa situação fazendo um  <i>query</i> na tabela  <b>Documentos_Cidades</b> para o documento cudo o identificador é 140. O identificador 140 se refere ao documento cujo título é "Prêmio Espaços Culturais".
</p>
]

<div class="codigo centrado">
<code>select nome_cidade, nome_documento from documentos, cidades, documentos_cidades where id_chave_documento=140 and id_documento=id_chave_documento and id_cidade=id_chave_cidade;
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"select nome_cidade, nome_documento from documentos, cidades, documentos_cidades where id_chave_documento=140 and id_documento=id_chave_documento and id_cidade=id_chave_cidade;\" --table"); ?>
</code>
</div>

<p>
O resultado da query mostra que o sistema identificou uma série de nomes de cidades no documento que estão fora do contexto. Por exemplo, vemos o caso de  <i>Santos</i>. A palavra  <i>Santos</i> aparece no documento por conta do sobrenome da signatária da portaria, Sra. "FLÁVIA CÂNDIDA FERREIRA SANTOS". Portanto a ocorrência da cidade de  <i>Santos</i> nesse documento é um falso positivo.
</p>

<p>
Outro exemplo de falso positivo é a cidade de  <i>União</i>. Na verdade, embora  <i>União</i> seja de fato um município brasileiro, a ocorrência dessa palavra no documento é por conta do trecho "Transferências de recursos da União", não havendo, de fato, uma referência a essa cidade no documento.
</p>

<p>
Outro falso positivo é referente à cidade de Marco, que também é um município brasileiro, mas no documento não de fato citado. O que ocorreu, nesse caso, é a ocorrência da palavra  <i>março</i>, que após a retirada das acentuações foi confundida com o nome da cidade. (isso é um erro do sistema de tirada de acentuação. Para corrigir é preciso tirar cedilha do conversor. É fácil. Corrigir!)
</p>

<p>
Também é um falso positivo a ocorrência da cidade  <i>Luz</i>. Esse erro de identificação ocorreu por conta do trecho "contas de água, luz, telefone, cartão de crédito,". Esta situação é semelhante para  <i>Patrocínio</i>, que no texto foi identificada equivocadamente por conta do trecho "Patrocínio direto de empresas - sem ser Lei de Incentivo".
</p>

<p>
Um caso complicado é da cidade de  <i>Espírito Santo</i>, uma vez que aparece no texto porque o nome do Estado do Espírito Santo aparece no texto. Acontece que existe de fato a cidade de  <i>Espírito Santo</i> no Rio Grande do Norte. Esta é uma situação bastante difícil para que o sistema identifique o contexto em que esse nome próprio aparece. 
</p>


<h2 id="removendo_falsos_positivos">Reduzindo o número de falsos positivos da busca por cidades</h2>

<p>
Para remover os falsos positivos resultantes das buscas por nome de cidades num dado documento, é preciso utilizar um query especial, que exclui os resultados de nomes de cidades que não estão exatamente com o formato de maiúsculas e minúsculas na tabela  <b>tokens_no_acervo</b>. Além disso, é preciso excluir aqueles nomes próprios que aparecem nos nomes próprios que estão presentes naquele documento.
</p>

<p>
O query vai ficar mais ou menos assim:
</p>

<div class="codigo centrado">
<code>select distinct 
	nome_cidade 
		from 
			documentos_cidades, 
			cidades 
			where 
				id_documento=140 
				and id_cidade=id_chave_cidade 
				and nome_cidade not in  
				(select 
					c.nome_cidade 
						from documentos as d, 
						cidades as c, 
						documentos_cidades as dc, 
						registrados as r, 
						documentos_registrados as dr 
						where 
							d.id_chave_documento=dc.id_documento 
							and c.id_chave_cidade=dc.id_cidade 
							and d.id_chave_documento=140 
							and d.id_chave_documento=dr.id_documento 
							and dr.id_registrado=r.id_chave_registrado 
							and LOCATE(c.nome_cidade, r.nome_registrado)>0 
							and c.nome_cidade in 
								(select 
									nome_token_no_acervo 
										from 
											documentos, 
											tokens_no_acervo, 
											documentos_tokens 
												where 
												id_chave_documento=140 
												and id_documento=id_chave_documento 
												and id_token=id_chave_token_no_acervo order by linha_da_ocorrencia
								)
				 ) 
				and 
					SUBSTRING_INDEX(nome_cidade," ",1) in 
						(select 
							nome_token_no_acervo 
								from 
								documentos, 
								tokens_no_acervo, 
								documentos_tokens 
									where 
										id_chave_documento=140 
										and id_documento=id_chave_documento 
										and id_token=id_chave_token_no_acervo 
											order by linha_da_ocorrencia
						) 
						and SUBSTRING_INDEX(nome_cidade," ", -1) in 
							(select 
								nome_token_no_acervo 
									from 
										documentos, 
										tokens_no_acervo, 
										documentos_tokens 
											where 
												id_chave_documento=140 
												and id_documento=id_chave_documento 
												and id_token=id_chave_token_no_acervo 
													order by linha_da_ocorrencia
							);
<?php echo shell_exec("mysql -u vitor -pSenhaMyVi2021 doc_aldirex -e \"select distinct nome_cidade from documentos_cidades, cidades where id_documento=140 and id_cidade=id_chave_cidade and nome_cidade not in  (select c.nome_cidade from documentos as d, cidades as c, documentos_cidades as dc, registrados as r, documentos_registrados as dr where d.id_chave_documento=dc.id_documento and c.id_chave_cidade=dc.id_cidade and d.id_chave_documento=140 and d.id_chave_documento=dr.id_documento and dr.id_registrado=r.id_chave_registrado and LOCATE(c.nome_cidade, r.nome_registrado)>0 and c.nome_cidade in (select nome_token_no_acervo from documentos, tokens_no_acervo, documentos_tokens where id_chave_documento=140 and id_documento=id_chave_documento and id_token=id_chave_token_no_acervo order by linha_da_ocorrencia)) and SUBSTRING_INDEX(nome_cidade,' ',1) in (select nome_token_no_acervo from documentos, tokens_no_acervo, documentos_tokens where id_chave_documento=140 and id_documento=id_chave_documento and id_token=id_chave_token_no_acervo order by linha_da_ocorrencia) and SUBSTRING_INDEX(nome_cidade,' ', -1) in (select nome_token_no_acervo from documentos, tokens_no_acervo, documentos_tokens where id_chave_documento=140 and id_documento=id_chave_documento and id_token=id_chave_token_no_acervo order by linha_da_ocorrencia);\" --table"); ?>
</code>
</div>

<p>
Como se vê o número de falsos positivos foi bastante reduzido, mas ainda há nomes de estado que estão sendo confundidos com nomes de cidades, como já explicado anteriormente. Já vimos no tópico anter o caso do nome próprio  <i>Mato Grosso</i>, que é um estado mas também é uma cidade na Paraíba. O mesmo ocorre com Espírito Santo, que é o nome de um estado do Sudeste, mas também é o nome de uma cidade no Rio Grande do Norte. 
</p>

<p>
O  <i>query</i> acima conseguiu remover falsos positivos como  <i>Luz</i> e  <i>Modelo</i>. Isso foi feito comparando de forma  <i>case sensitive</i> os nomes de cidades encontradas com os   <i>tokens</i> presentes no texto. O registro de  <i>tokens</i> no texto mantém a ocorrência de maiúsculas e minúsculas original. Assim, como no texto a palavra  <i>luz</i> aparece em minúscula, e como a cidade  <i>Luz</i> tem a primeira letra maiúscula, esse falso positivo é removido. O mesmo ocorre com os falsos positivos  <i>Registro</i>,  <i>Marco</i> e  <i>Modelo</i>.
</p>

<p>
No entanto, a estratégia utilizada não consegue remover os falso positivos  <i>União</i> e  <i>Patrocínio</i>, uma vez que essas palavras, embora não ocorram no contexto de nomes próprios no texto, estão com maiúscula no texto.  <i>Patrocínio</i> está no começo de uma frase, quando mesmo palavras comuns têm a primeira letra em maiúscula. Assim, o sistema não consegue discernir o falso positivo. A palavra  <i>União</i> de fato aparece no documento 140, mas no contexto de União Federal, que é um nome próprio. Ocorre que  <i>União</i> também é uma cidade do Piauí. 
</p>

<p>
Há estratégias ainda para serem exploradas no sentindo de reduzir o número de falsos positivos como os citados acima, mas a redução substancial do número de falsos positivos permite que uma intervenção humana comece a ser um método eficiente de limpar os falsos positivos.
</p>

<h2 id="nova_versao">Instalação da Superinterface</h2>

<p></p>
Para realizar a instalação da Superinterface, proceda da seguinte forma:
<ol>
<li>No diretório raiz do site, crie os seguintes subdiretórios, observando suas propriedades:
<p></p><pre>
drwxr-x---  user user  su_docs
drwxr-x---  user user  su_install
drwxr-x---  user user  su_pdfiniciais
</pre><p></p>
obs:<br \>
a) "user" seria o proprietário do site.<br \>
b) su_docs: conterá os arquivos de documentação desta solução.<br \>
c) su_install: conterá os arquivos necessários à instalação desta solução.<br \>
d) su_pdfiniciais: conterá os arquivos PDF iniciais que constituirá o acervo.
</li>
<p></p>
<li>O diretório su_docs deverá conter os seguintes arquivos:
<pre>
-rw-r----- user user  super_diagrama_criacao_potlatch.png
-rw-r----- user user  super_diagrama_doc_aldirex_correto_geo_base.png
-rw-r----- user user  super_diagrama_entrada_de_dados_correto.png
-rw-r----- user user  super_diagrama_estrutura_diretorios.png
-rw-r----- user user  super_wash.jpg
</pre>
obs: "user" seria o proprietário do site
</li>
<p></p>
<li>O subdiretório su_install e coloque os seguintes arquivos, observando suas propriedades:
<pre>
-r--r-----  user user super_cidades_insere.sql
-r--r-----  user user super_cidades_maiusculas.txt
-rw-------  user user super_config.cnf
-r--r-----  user user super_cowsay1.txt
-r--r-----  user user super_cria_tabelas.sql
-rwxr-x---  user user super_installsuperinterface.sh
-rwxr-x---  user user super_novospdf.sh
</pre>
<p></p>
obs:  "user" seria o proprietário do site.
</li>
<p></p>
<li>O subdiretório su_pdfiniciais deverá conter os arquivos PDF iniciais para compor o acervo.
<p></p>
Obs: este diretório poderá estar vazio caso não se tenha arquivos PDF no momento da instalação desta solução, ou mesmo não se deseje inserir estes arquivos neste momento da instalação.
</li>
<p></p>
<li>O vigilante<br \>
A solução tem um "vigilante" que monitora de tempos em tempos se existem arquivos PDF para serem incorporados ao acervo. Para isto funcionar, crie uma entrada no crontab do usuário da solução da seguinte forma:
<pre>
*/1	*	*	*	*	cd <caminho até a raiz do site>/su_install/; ./super_novospdf.sh cron
</pre>
Obs:<br \>
- na forma mostrada, o vigilante está programado para entrar em ação a cada minuto.<p></p>
 </li>
<p></p>
<li>Quando terminar a instalação, terá sido gerada pastas adicionais necessárias ao funcionamento da solução. Entre outras, serão criadas quatro pastas especiais que o usuário poderá ter acesso a elas:
<pre>
drwxr-----  user user  su_logs
drwxr-----  user user  su_imagens
drwxr-----  user user  su_pdfuploads
drwxr-----  user user  su_quarentine
</pre>
Obs:<br \>
a) su_logs: logs de todas as operações da solução sobre o acervo, desde o processo de instalação, informações sobre as atividades de agregação de novos arquivos PDF ao acervo, até mensagens de erro.<br \>
b) su_imagens: pasta onde estarão guardados os arquivos PDF, juntamente com sua imagem jpg e sua versão texto puro gerada, que foram incorporados ao acervo de documentos.<br \>
c) su_pdfuploads: pasta em que o usuário deverá disponibilizar novos arquivos PDF para serem incorporados ao acervo.  A execução deste processo de incorporação de novos documentos PDF ao acervo estará sob responsabilidade do vigilante.<br \>
d) su_quarentine: pasta para onde serão destinados os arquivos PDF que apresentarem problemas para serem incorporados ao acervo.
</li>
<p></p>
<li>Instalações de aplicativos ao ambiente
<pre>apt-get install detox figlet cowsay</pre>
<p></p>
No ambiente Debian/linux, pode ainda se fazer necessário a criação de um link simbólico:  
<pre>ln -s /usr/games/cowsay  /user/bin/cowsay</pre>
</li>
<p></p>
<li>Apache
Os seguintes módulos devem estar instalados:<br \>
Módulo rewrite<br \>
Módulo mpm-itk<br \>
Módulo php-mysql
</li>

<p></p>
<li>Aspectos de segurança
No virtual host do site, acrescentar o código a seguir para proteger a pasta onde estão definidas as configurações:
<pre>
&lt;IfModule mod_rewrite.c&gt;
	RewriteEngine on
	RewriteBase /
	RewriteRule ^su_install/(.*)$ http://observatorio.wash.net.br/superinterface/index.php?banco=baseportlet [R=301,L]
&lt;IfModule&gt;
</pre>
</li>
</ol>


<p></p>


</div>
<script>
function lista_h2(){
var i;
x=document.getElementsByTagName("H2");
menuzinho=document.getElementById("menu");
menuzinho.innerHTML=menuzinho.innerHTML+"<br><br>";
for (i=0; i<x.length; i++){
menuzinho.innerHTML=menuzinho.innerHTML+"<br><a class='lista_de_conteudo' href='#"+x[i].id+"'>"+x[i].innerHTML+"</a><br>";

}
}
</script>
</body>
</html>


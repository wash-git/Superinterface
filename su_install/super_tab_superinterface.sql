-- Criação de Tabelas de dados sobre o acervo
-- ------------------------------------------
-- ------------------------------------------

-- Criação de usuários administrativos da Superinterface --
CREATE TABLE su_usuarios (username varchar(10) NOT NULL, senha varchar(42) NOT NULL, nome varchar(80) NOT NULL, email varchar(80) NOT NULL, cidade varchar(40) NOT NULL, estado char(2) NOT NULL, privilegio TINYINT unsigned  NOT NULL, ativo bool NOT NULL, primary key (username));
ALTER TABLE su_usuarios comment='Contém a identificação dos usuários para acesso a interface administrativa da Superinterface';

CREATE TABLE su_tipos_logradouros (id_chave_tipo_de_logradouro int not null auto_increment, nome_tipo_de_logradouro varchar(100), abreviatura varchar(50), primary key(id_chave_tipo_de_logradouro), unique(nome_tipo_de_logradouro), unique(abreviatura));

CREATE TABLE su_names_brasil (id_chave_name_do_brasil int not null auto_increment, nome_name_do_brasil varchar(100), minuscula_sem_acento varchar(100), maiuscula_sem_acento varchar(100), first_sem_acento varchar(100),minuscula_com_acento varchar(100), maiuscula_com_acento varchar(100), first_com_acento varchar(100), primary key(id_chave_name_do_brasil), unique(nome_name_do_brasil), unique(minuscula_sem_acento), unique(maiuscula_sem_acento), unique(first_sem_acento), unique(minuscula_com_acento), unique(maiuscula_com_acento), unique(first_com_acento));

CREATE TABLE su_estados (id_chave_estado int not null auto_increment, codigo_estado varchar(2), sigla_estado varchar(2), nome_estado varchar(100), id_pais int not null, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_estado), UNIQUE (codigo_estado),UNIQUE(sigla_estado), UNIQUE(nome_estado));

CREATE TABLE su_cidades (id_chave_cidade int not null auto_increment, id_estado int, sigla_estado varchar(2), nome_cidade varchar(300), cidade_sem_acentuacao varchar(300), codigo varchar(50), gentilico varchar(50), prefeito varchar(300), area_territorial varchar(200), populacao_estimada int, densidade_demografica varchar(200), escolarizacao varchar(200), idhm varchar(200), mortalidade_infantil varchar(200), receitas_realizadas varchar(200), despesas_empenhadas varchar(200), pib_per_capita varchar(200), primary key (id_chave_cidade));

CREATE TABLE su_nomes_cidades AS SELECT nome_cidade from su_cidades;

CREATE TABLE su_instituicoes (id_chave_instituicao int(11) not null auto_increment, nome_instituicao varchar(300) DEFAULT NULL, instituicao_sem_acentuacao varchar(300),  time_stamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(), primary key(id_chave_instituicao));

CREATE TABLE su_nomes_instituicoes AS SELECT nome_instituicao from su_instituicoes;

CREATE TABLE su_tipos_documentos (id_chave_tipo_de_documento int not null auto_increment, nome_tipo_de_documento varchar(200), primary key (id_chave_tipo_de_documento), unique(nome_tipo_de_documento));

CREATE TABLE su_paises (id_chave_pais int not null auto_increment, codigo_pais varchar(10), nome_pais varchar(150), sigla_pais varchar(5), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_pais), UNIQUE(nome_pais), UNIQUE(codigo_pais));

CREATE TABLE su_documents (id_chave_documento int not null auto_increment, sigla varchar(30),  id_tipo_de_documento int, id_curador int, nome_documento varchar(200), originalfilename varchar(200), titulo varchar(300), photo_filename_documento varchar(200), alt_foto_jpg varchar(200), descricao varchar(2000), relevancia varchar(2000), data_doc date, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY (id_chave_documento), unique(sigla), unique(photo_filename_documento));
--
-- Criação de Tabelas de controle da interface
--
CREATE TABLE su_gc (id_chave_database int not null auto_increment, nome_do_database varchar(200), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_database), UNIQUE(nome_do_database));

CREATE TABLE su_listas_tabelas (id_chave_tabela int not null auto_increment, nome_da_tabela varchar(200), id_database int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_tabela), UNIQUE(nome_da_tabela));

CREATE TABLE su_lista_campos (id_chave_campo int not null auto_increment, nome_do_campo varchar(200), id_tabela int, tipo_do_campo varchar(200), fk_table varchar(200), fk_field varchar(200), max_length int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_campo), UNIQUE(id_tabela,nome_do_campo));

CREATE TABLE su_desc_interfaces (id_chave_descricao_da_interface int not null auto_increment, id_interface int, nome_ident_do_elemento varchar(200), caption_do_campo_visivel varchar(200) , id_tabela_de_busca int, id_campo_de_busca int, id_tabela_fk int, id_campo_chave_fk int, id_campo_nome_fk int, id_tabela_dependencia int, id_campo_id_dependencia int, required TINYINT(1), id_regra_de_validacao int, id_tag int, id_parent int, ordem_no_parent int, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_descricao_da_interface), UNIQUE(id_interface, nome_ident_do_elemento)) comment='Tabela que determina como serao as janelas do programa. Esta tabela contem a lista de campos que sera mostrada na tabela de sign in.';

CREATE TABLE su_tabelas_para_usuario (id_chave_tabela_para_o_usuario int not null auto_increment, nome_tabela varchar(200), descricao_tabela varchar(2000), primary key (id_chave_tabela_para_o_usuario));

CREATE TABLE su_csss_tags (id_chave_css_tag int not null auto_increment, nome_da_tag varchar(200), id_estilo int, codigo_css varchar (2000), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_css_tag), UNIQUE(nome_da_tag));

CREATE TABLE su_csss_classes (id_chave_css_classe int not null auto_increment, nome_da_classe varchar(200), id_estilo int, codigo_CSS varchar (2000), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_css_classe), UNIQUE(nome_da_classe));

--
-- Criação de Tabelas de Ligação (cardinalidade de N para N)
--
CREATE TABLE su_tokens_acervo (id_chave_token_no_acervo int not null auto_increment, nome_token_no_acervo varchar(100), funcao varchar(100), ocorrencias int, primary key (id_chave_token_no_acervo), unique(nome_token_no_acervo));

CREATE TABLE su_tabelas_ligacao (id_chave_tabela_de_ligacao int not null auto_increment, nome_tabela_de_ligacao varchar(100), campo_externo1_tabela_de_ligacao varchar(100), campo_externo2_tabela_de_ligacao varchar(100), tabela_externa1 varchar(100), campo_id_tabela_externa1 varchar(100), campo_name_tabela_externa1 varchar(100), tabela_externa2 varchar(100), campo_id_tabela_externa2 varchar(100), campo_name_tabela_externa2 varchar(100) , primary key(id_chave_tabela_de_ligacao));

CREATE TABLE su_docs_tokens (id_chave_documento_token int not null auto_increment, id_documento int, id_token int, linha_da_ocorrencia int, primary key(id_chave_documento_token));

CREATE TABLE su_docs_signatarios (id_chave_documento_signatario int not null auto_increment, id_documento int, id_signatario int, primary key (id_chave_documento_signatario));

CREATE TABLE su_docs_registrados (id_chave_documento_registrado int not null auto_increment, id_documento int, id_registrado int, ocorrencias int, primary key (id_chave_documento_registrado));

CREATE TABLE su_docs_instituicoes (id_chave_documento_instituicao int not null auto_increment, id_documento int, id_instituicao int, ocorrencia_inst int, primary key (id_chave_documento_instituicao));

CREATE TABLE su_interfaces (id_chave_interface int not null auto_increment, nome_da_interface varchar(200), id_estilo int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_interface), UNIQUE(nome_da_interface));

CREATE TABLE su_elementos_classes (id_chave_elemento_classe int not null auto_increment, id_classe int, id_elemento_descrito int, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_elemento_classe), UNIQUE(id_classe, id_elemento_descrito));

CREATE TABLE su_registrados (id_chave_registrado int not null auto_increment, nome_registrado varchar(200),   name_of_war varchar(100), id_estado int, id_pais int, id_cidade int, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY (id_chave_registrado));

CREATE TABLE su_estilos (id_chave_estilo int not null auto_increment, nome_do_estilo varchar(200), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_estilo), UNIQUE(nome_do_estilo));

CREATE TABLE su_regras_validacao (id_chave_regra int not null auto_increment, nome_da_regra varchar(200), REGEX int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_regra), UNIQUE(nome_da_regra));

CREATE TABLE su_docs_cidades (id_chave_documentos_municipios int not null auto_increment, id_documento int, id_cidade int, ocorrencia int, primary key (id_chave_documentos_municipios));
--
-- Adicionando chaves primárias as tabelas
--
ALTER TABLE su_listas_tabelas ADD CONSTRAINT FK_lista_tabelas_databases FOREIGN KEY (id_database) REFERENCES su_gc(id_chave_database);
ALTER TABLE su_lista_campos ADD CONSTRAINT FK_lista_campos_tabelas FOREIGN KEY (id_tabela) REFERENCES su_listas_tabelas(id_chave_tabela);
ALTER TABLE su_csss_classes ADD CONSTRAINT FK_css_classe_estilo FOREIGN KEY (id_estilo) REFERENCES su_estilos(id_chave_estilo);
ALTER TABLE su_csss_tags ADD CONSTRAINT FK_css_tag_estilo FOREIGN KEY (id_estilo) REFERENCES su_estilos(id_chave_estilo);
ALTER TABLE su_interfaces ADD CONSTRAINT FK_interfaces_estilos FOREIGN KEY (id_estilo) REFERENCES su_estilos(id_chave_estilo);
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_interface_descricao FOREIGN KEY (id_interface) REFERENCES su_interfaces(id_chave_interface);
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_tabela_direta_descricao FOREIGN KEY (id_tabela_de_busca) REFERENCES su_listas_tabelas(id_chave_tabela); 
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_campo_direto_descricao FOREIGN KEY (id_campo_de_busca) REFERENCES su_lista_campos(id_chave_campo); 
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_tabela_fk_descricao FOREIGN KEY (id_tabela_fk) REFERENCES su_listas_tabelas(id_chave_tabela);
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_campo_fk_id_descricao FOREIGN KEY (id_campo_chave_fk) REFERENCES su_lista_campos(id_chave_campo); 
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_campo_fk_nome_descricao FOREIGN KEY (id_campo_nome_fk) REFERENCES su_lista_campos(id_chave_campo); 
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_tabela_dependencia_descricao FOREIGN KEY (id_tabela_dependencia) REFERENCES su_listas_tabelas(id_chave_tabela); 
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_campo_dependencia_descricao FOREIGN KEY (id_campo_id_dependencia) REFERENCES su_lista_campos(id_chave_campo); 
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_regra_descricao FOREIGN KEY (id_regra_de_validacao) REFERENCES su_regras_validacao(id_chave_regra);
ALTER TABLE su_desc_interfaces ADD CONSTRAINT FK_tags_descricao FOREIGN KEY (id_tag) REFERENCES su_csss_tags(id_chave_css_tag);
ALTER TABLE su_elementos_classes ADD CONSTRAINT FK_elementos_classes FOREIGN KEY (id_classe) REFERENCES su_csss_classes(id_chave_css_classe); 
ALTER TABLE su_elementos_classes ADD CONSTRAINT FK_elementos_descricao FOREIGN KEY (id_elemento_descrito) REFERENCES su_desc_interfaces(id_chave_descricao_da_interface);
ALTER TABLE su_cidades ADD CONSTRAINT FK_estado_cidade FOREIGN KEY (id_estado) REFERENCES su_estados(id_chave_estado);
ALTER TABLE su_cidades comment='Contém todas as cidades brasileiras, com dados demográficos originários do IBGE. Tem uma chave externa para o Estado, uma vez que o Brasil tem cidades homônimas, mas para estados diferentes.';
ALTER TABLE su_registrados ADD CONSTRAINT FK_estado_registrado FOREIGN KEY (id_estado) REFERENCES su_estados(id_chave_estado);
ALTER TABLE su_registrados ADD CONSTRAINT FK_cidade_registrado FOREIGN KEY (id_cidade) REFERENCES su_cidades(id_chave_cidade);
ALTER TABLE su_registrados ADD CONSTRAINT FK_pais_registrado FOREIGN KEY (id_pais) REFERENCES su_paises(id_chave_pais);
ALTER TABLE su_registrados comment='É a tabela que registra todos os stake-holders identificados até o momento. São pessoas que podem assumir diversos papéis e interesses: signatários de documentos, destinatários de documentos, autoridades, líderes comunitários, representantes de entidades variadas, curadores, etc';
ALTER TABLE su_documents add constraint fk_curador foreign key (id_curador) references su_registrados(id_chave_registrado);
ALTER TABLE su_documents add constraint fk_tipo_de_documento foreign key (id_tipo_de_documento) references su_tipos_documentos(id_chave_tipo_de_documento);
ALTER TABLE su_documents comment='Documentos guarda todos os documentos do acervo. Campos: photo_filename_documento aponta para path do documento referido pelo registro, id_curador indica quem fez a análise do documento (Registrados), id_tipo_documento aponta para su_tipos_documentos. É a tabela central da base da Superinterface.';
ALTER TABLE su_docs_tokens ADD CONSTRAINT FK_id_documento FOREIGN KEY (id_documento) REFERENCES su_documents(id_chave_documento);
ALTER TABLE su_docs_tokens ADD CONSTRAINT FK_id_token FOREIGN KEY (id_token) REFERENCES su_tokens_acervo(id_chave_token_no_acervo);
ALTER TABLE su_docs_tokens comment='Indica os tokens contidos num certo documento, descontados pontuação e a linha do arquivo em que esse token ocorreu. O arquivo a que se refere é um arquivo csv com uma única coluna, portanto a linha da ocorrência indica a ordem de ocorrência da palavra no text. Esta tabela permite reconstituir parcialmente o arquivo texto do documento original.';
ALTER TABLE su_docs_signatarios ADD CONSTRAINT FK_signatario_documento FOREIGN KEY (id_signatario) REFERENCES su_registrados(id_chave_registrado);
ALTER TABLE su_docs_signatarios ADD CONSTRAINT FK_documento_signatario FOREIGN KEY (id_documento) REFERENCES su_documents(id_chave_documento);
ALTER TABLE su_docs_signatarios comment='Estabelece uma cardinalidade N para N entre a tabela Documentos e a tabela su_registrados. Indica a lista de pessoas que assinou um determinado documento ou quantos documentos foram assinados por uma pessoaa.1';
ALTER TABLE su_docs_registrados ADD CONSTRAINT FK_registrado_documento FOREIGN KEY (id_registrado) REFERENCES su_registrados(id_chave_registrado);
ALTER TABLE su_docs_registrados ADD CONSTRAINT FK_documento_registrado FOREIGN KEY (id_documento) REFERENCES su_documents(id_chave_documento);
ALTER TABLE su_docs_registrados comment='É uma tabela que é similar à tabela su_docs_signatarios, mas não está restrita apenas a esse aspecto. A tabela su_docs_registrados é mais ampla e contém o nome das pessoas que fazem parte do Staff do projeto, por exemplo. A tabela contém também o nome de curadores, ou qualquer outra pessoa interessada. Não existe outro lugar para guardar nomes de pessoas. Esta tabela difere de su_docs_signatarios porque aqui temos os nomes que aparecem no documento, mas que nao sao necessariamente signatarios';
ALTER TABLE su_docs_instituicoes ADD CONSTRAINT FK_instituicao_documento FOREIGN KEY (id_instituicao) REFERENCES su_instituicoes(id_chave_instituicao);
ALTER TABLE su_docs_instituicoes ADD CONSTRAINT FK_documento_instituicao FOREIGN KEY (id_documento) REFERENCES su_documents(id_chave_documento);
ALTER TABLE su_docs_instituicoes comment='Indica as instituições que aparecem num dado documento, ou os documentos que contém uma certa instituição.';
ALTER TABLE su_docs_cidades ADD CONSTRAINT FK_cidade_documento FOREIGN KEY (id_cidade) REFERENCES su_cidades(id_chave_cidade);
ALTER TABLE su_docs_cidades ADD CONSTRAINT FK_documento_cidade FOREIGN KEY (id_documento) REFERENCES su_documents(id_chave_documento);
ALTER TABLE su_docs_cidades comment='Registro das relações N para N de documentos e municípios brasileiros..';
ALTER TABLE su_instituicoes comment='Contém o registro das instituições relevantes. Pode incluir governos, organizações sociais, empresas, secretarias, etc.';
ALTER TABLE su_tokens_acervo comment='Esta tabela permite conhecer todos os tokens (exceto pontuação, etc) do acervo, sem repetições.';
ALTER TABLE su_names_brasil comment='Contém uma coletânea de nomes próprios para permitir a identificação de nomes próprios compostos/completos nos documentos. É usada através da comparação com su_docs_tokens, verificando se há nomes próprios em sequência, caracterizando um nome própio completo (José é nome simples e José da Silva é nome composto/completo). Guarda os nomes em várias configurações de maiúsculas e minúsculas para acelerar a busca.';
ALTER TABLE su_tabelas_para_usuario comment='Contém a lista de tabelas que serão mostradas na entrada principal da plataforma Potlatch';
ALTER TABLE su_tabelas_ligacao comment='Indica todos os casos de tabelas com duas chaves externas que relações de cardinalidade N para N. Essa tabela é preenchida automaticamente toda vez que o Super_Interfaces é executado e é usada para criar as interfaces de inserção de relações N para N.';
ALTER TABLE su_tipos_documentos comment='Contém as categorias de documentos.';
ALTER TABLE su_estados comment='Todos os Estados brasileiros com chave externa para os países.';
ALTER TABLE su_paises comment='Registro de países.';
--
-- Populando tabela su_tipos_logradouros
--
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Avenida','Av.');
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Rua','Rua');
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Travessa','Tr.');
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Beco','Bc.');
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Alameda','Al.');
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Viela','Vl.');
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Praça','Pr.');
insert into su_tipos_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Fazenda','Fz.');
--
-- Populando tabela su_tabelas_para_usuario
--
insert into su_tabelas_para_usuario (nome_tabela, descricao_tabela) values ('su_documents','É a tabela onde serão inseridos novos documentos.');
insert into su_tabelas_para_usuario (nome_tabela, descricao_tabela) values ('su_instituicoes','É a tabela onde serão inseridas as instituições às quais os documentos farão referências.');
insert into su_tabelas_para_usuario (nome_tabela, descricao_tabela) values ('su_registrados','É a tabela onde serão inseridos os dados de indivíduos com algum papel a desempenhar no modelo de dados. Esse papel pode ser de staff do Wash, ou de signatário de um documento, por exemplo. Quando um novo registrado é inserido nesta tabela, ele aparece na tabela su_documents.');
--
-- Populando tabela su_tipos_documentos
--
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Tipo de documento indefinido');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Atas e registros de reuniões');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Relatório de Projetos');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Despachos, Ofícios, Memorandos e Portarias');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Planos de Trabalho, Planos de Ação, Planejamento, Propostas');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Convênios e suas minutas');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Contratos e suas minutas');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Divulgação Pública, Artigos, Boletins, Convites, Anúncios, Manifestos, Circulares, Comunicados, Discursos');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Planilha, anotações, registros soltos');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Emendas, Leis, Portarias, Decretos, Medidas Provisórias, Portarias, suas minutas e projetos');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Apresentações');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Diário Oficial');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Editais e suas minutas');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Cadastros, registros');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Requerimento, Solicitações, Petições, Questionamentos');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Cartilhas, Instruções, Manuais, Guias, Perguntas Orientadoras, Apostilas');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Denúncias, Representações');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Inquéritos, investigações');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Prestações de contas e auditorias');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Notas Técnicas, Relatórios, Pareceres, Soluções de Divergência');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Questionários, levantamentos');
INSERT INTO su_tipos_documentos (nome_tipo_de_documento) values ('Emails, Cartas');


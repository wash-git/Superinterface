-- Criação de Tabelas de dados sobre o acervo
--
CREATE TABLE su_usuarios (username varchar(10) NOT NULL, senha varchar(42) NOT NULL, nome varchar(80) NOT NULL, email varchar(80) NOT NULL, cidade varchar(40) NOT NULL, estado char(2) NOT NULL, privilegio TINYINT unsigned  NOT NULL, ativo bool NOT NULL, primary key (username));

CREATE TABLE tipos_de_logradouros (id_chave_tipo_de_logradouro int not null auto_increment, nome_tipo_de_logradouro varchar(100), abreviatura varchar(50), primary key(id_chave_tipo_de_logradouro), unique(nome_tipo_de_logradouro), unique(abreviatura));

CREATE TABLE names_do_brasil (id_chave_name_do_brasil int not null auto_increment, nome_name_do_brasil varchar(100), minuscula_sem_acento varchar(100), maiuscula_sem_acento varchar(100), first_sem_acento varchar(100),minuscula_com_acento varchar(100), maiuscula_com_acento varchar(100), first_com_acento varchar(100), primary key(id_chave_name_do_brasil), unique(nome_name_do_brasil), unique(minuscula_sem_acento), unique(maiuscula_sem_acento), unique(first_sem_acento), unique(minuscula_com_acento), unique(maiuscula_com_acento), unique(first_com_acento));

CREATE TABLE estados (id_chave_estado int not null auto_increment, nome_estado varchar(200), sigla_estado varchar(2), id_pais int not null,time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_estado), UNIQUE(nome_estado), UNIQUE(sigla_estado));

CREATE TABLE cidades (id_chave_cidade int not null auto_increment, id_estado int, sigla_estado varchar(2), nome_cidade varchar(300), cidade_sem_acentuacao varchar(300), codigo varchar(50), gentilico varchar(50), prefeito varchar(300), area_territorial varchar(200), populacao_estimada int, densidade_demografica varchar(200), escolarizacao varchar(200), idhm varchar(200), mortalidade_infantil varchar(200), receitas_realizadas varchar(200), despesas_empenhadas varchar(200), pib_per_capita varchar(200), primary key (id_chave_cidade));

CREATE TABLE nomes_de_cidades AS SELECT nome_cidade from cidades;

CREATE TABLE instituicoes (id_chave_instituicao int not null auto_increment, nome_instituicao varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, primary key(id_chave_instituicao));

CREATE TABLE tipos_de_documentos (id_chave_tipo_de_documento int not null auto_increment, nome_tipo_de_documento varchar(200), primary key (id_chave_tipo_de_documento), unique(nome_tipo_de_documento));

CREATE TABLE paises (id_chave_pais int not null auto_increment, nome_pais varchar(200), sigla_pais varchar(20), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_pais), UNIQUE(nome_pais), UNIQUE(sigla_pais));

CREATE TABLE documentos (id_chave_documento int not null auto_increment, sigla varchar(30),  id_tipo_de_documento int, id_curador int, nome_documento varchar(200), originalfilename varchar(200), titulo varchar(300), photo_filename_documento varchar(200), alt_foto_jpg varchar(200), descricao varchar(2000), relevancia varchar(2000), data_doc date, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY (id_chave_documento), unique(sigla), unique(photo_filename_documento));
--
-- Criação de Tabelas de controle da interface
--
CREATE TABLE gc (id_chave_database int not null auto_increment, nome_do_database varchar(200), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_database), UNIQUE(nome_do_database));

CREATE TABLE listas_de_tabelas (id_chave_tabela int not null auto_increment, nome_da_tabela varchar(200), id_database int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_tabela), UNIQUE(nome_da_tabela));

CREATE TABLE lista_de_campos (id_chave_campo int not null auto_increment, nome_do_campo varchar(200), id_tabela int, tipo_do_campo varchar(200), fk_table varchar(200), fk_field varchar(200), max_length int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_campo), UNIQUE(id_tabela,nome_do_campo));

CREATE TABLE descricoes_das_interfaces (id_chave_descricao_da_interface int not null auto_increment, id_interface int, nome_ident_do_elemento varchar(200), caption_do_campo_visivel varchar(200) , id_tabela_de_busca int, id_campo_de_busca int, id_tabela_fk int, id_campo_chave_fk int, id_campo_nome_fk int, id_tabela_dependencia int, id_campo_id_dependencia int, required TINYINT(1), id_regra_de_validacao int, id_tag int, id_parent int, ordem_no_parent int, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_descricao_da_interface), UNIQUE(id_interface, nome_ident_do_elemento)) comment='Tabela que determina como serao as janelas do programa. Esta tabela contem a lista de campos que sera mostrada na tabela de sign in.';

CREATE TABLE tabelas_para_o_usuario (id_chave_tabela_para_o_usuario int not null auto_increment, nome_tabela varchar(200), descricao_tabela varchar(2000), primary key (id_chave_tabela_para_o_usuario));

CREATE TABLE csss_tags (id_chave_css_tag int not null auto_increment, nome_da_tag varchar(200), id_estilo int, codigo_css varchar (2000), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_css_tag), UNIQUE(nome_da_tag));

CREATE TABLE csss_classes (id_chave_css_classe int not null auto_increment, nome_da_classe varchar(200), id_estilo int, codigo_CSS varchar (2000), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_css_classe), UNIQUE(nome_da_classe));

-- CREATE TABLE classificacoes_de_documentos (id_chave_classificacao_de_documento int not null auto_increment, nome_classificacao_de_documento varchar(200), PRIMARY KEY(id_chave_classificacao_de_documento), UNIQUE(nome_classificacao_de_documento));

--
-- Criação de Tabelas de Ligação (cardinalidade de N para N)
--
CREATE TABLE tokens_no_acervo (id_chave_token_no_acervo int not null auto_increment, nome_token_no_acervo varchar(100), funcao varchar(100), ocorrencias int, primary key (id_chave_token_no_acervo), unique(nome_token_no_acervo));

CREATE TABLE tabelas_de_ligacao (id_chave_tabela_de_ligacao int not null auto_increment, nome_tabela_de_ligacao varchar(100), campo_externo1_tabela_de_ligacao varchar(100), campo_externo2_tabela_de_ligacao varchar(100), tabela_externa1 varchar(100), campo_id_tabela_externa1 varchar(100), campo_name_tabela_externa1 varchar(100), tabela_externa2 varchar(100), campo_id_tabela_externa2 varchar(100), campo_name_tabela_externa2 varchar(100) , primary key(id_chave_tabela_de_ligacao));

CREATE TABLE documentos_tokens (id_chave_documento_token int not null auto_increment, id_documento int, id_token int, linha_da_ocorrencia int, primary key(id_chave_documento_token));

CREATE TABLE documentos_signatarios (id_chave_documento_signatario int not null auto_increment, id_documento int, id_signatario int, primary key (id_chave_documento_signatario));

CREATE TABLE documentos_registrados (id_chave_documento_registrado int not null auto_increment, id_documento int, id_registrado int, ocorrencias int, primary key (id_chave_documento_registrado));

CREATE TABLE documentos_instituicoes (id_chave_documento_instituicao int not null auto_increment, id_documento int, id_instituicao int, primary key (id_chave_documento_instituicao));

CREATE TABLE interfaces (id_chave_interface int not null auto_increment, nome_da_interface varchar(200), id_estilo int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_interface), UNIQUE(nome_da_interface));

CREATE TABLE elementos_classes (id_chave_elemento_classe int not null auto_increment, id_classe int, id_elemento_descrito int, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_elemento_classe), UNIQUE(id_classe, id_elemento_descrito));

CREATE TABLE registrados (id_chave_registrado int not null auto_increment, nome_registrado varchar(200),   name_of_war varchar(100), id_estado int, id_pais int, id_cidade int, time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY (id_chave_registrado));

CREATE TABLE estilos (id_chave_estilo int not null auto_increment, nome_do_estilo varchar(200), comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_estilo), UNIQUE(nome_do_estilo));

CREATE TABLE regras_de_validacao (id_chave_regra int not null auto_increment, nome_da_regra varchar(200), REGEX int, comentario varchar(1000), time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, usuario varchar(100), PRIMARY KEY(id_chave_regra), UNIQUE(nome_da_regra));

CREATE TABLE documentos_cidades (id_chave_documentos_municipios int not null auto_increment, id_documento int, id_cidade int, ocorrencia int, primary key (id_chave_documentos_municipios));
--
-- Adicionando chaves primárias as tabelas
--
ALTER TABLE listas_de_tabelas ADD CONSTRAINT FK_lista_tabelas_databases FOREIGN KEY (id_database) REFERENCES gc(id_chave_database);
ALTER TABLE lista_de_campos ADD CONSTRAINT FK_lista_campos_tabelas FOREIGN KEY (id_tabela) REFERENCES listas_de_tabelas(id_chave_tabela);
ALTER TABLE csss_classes ADD CONSTRAINT FK_css_classe_estilo FOREIGN KEY (id_estilo) REFERENCES estilos(id_chave_estilo);
ALTER TABLE csss_tags ADD CONSTRAINT FK_css_tag_estilo FOREIGN KEY (id_estilo) REFERENCES estilos(id_chave_estilo);
ALTER TABLE interfaces ADD CONSTRAINT FK_interfaces_estilos FOREIGN KEY (id_estilo) REFERENCES estilos(id_chave_estilo);
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_interface_descricao FOREIGN KEY (id_interface) REFERENCES interfaces(id_chave_interface);
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_tabela_direta_descricao FOREIGN KEY (id_tabela_de_busca) REFERENCES listas_de_tabelas(id_chave_tabela); 
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_campo_direto_descricao FOREIGN KEY (id_campo_de_busca) REFERENCES lista_de_campos(id_chave_campo); 
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_tabela_fk_descricao FOREIGN KEY (id_tabela_fk) REFERENCES listas_de_tabelas(id_chave_tabela);
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_campo_fk_id_descricao FOREIGN KEY (id_campo_chave_fk) REFERENCES lista_de_campos(id_chave_campo); 
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_campo_fk_nome_descricao FOREIGN KEY (id_campo_nome_fk) REFERENCES lista_de_campos(id_chave_campo); 
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_tabela_dependencia_descricao FOREIGN KEY (id_tabela_dependencia) REFERENCES listas_de_tabelas(id_chave_tabela); 
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_campo_dependencia_descricao FOREIGN KEY (id_campo_id_dependencia) REFERENCES lista_de_campos(id_chave_campo); 
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_regra_descricao FOREIGN KEY (id_regra_de_validacao) REFERENCES regras_de_validacao(id_chave_regra);
ALTER TABLE descricoes_das_interfaces ADD CONSTRAINT FK_tags_descricao FOREIGN KEY (id_tag) REFERENCES csss_tags(id_chave_css_tag);
ALTER TABLE elementos_classes ADD CONSTRAINT FK_elementos_classes FOREIGN KEY (id_classe) REFERENCES csss_classes(id_chave_css_classe); 
ALTER TABLE elementos_classes ADD CONSTRAINT FK_elementos_descricao FOREIGN KEY (id_elemento_descrito) REFERENCES descricoes_das_interfaces(id_chave_descricao_da_interface);
ALTER TABLE cidades ADD CONSTRAINT FK_estado_cidade FOREIGN KEY (id_estado) REFERENCES estados(id_chave_estado);
ALTER TABLE cidades comment='Contém todas as cidades brasileiras, com dados demográficos originários do IBGE. Tem uma chave externa para o Estado, uma vez que o Brasil tem cidades homônimas, mas para estados diferentes.';
ALTER TABLE registrados ADD CONSTRAINT FK_estado_registrado FOREIGN KEY (id_estado) REFERENCES estados(id_chave_estado);
ALTER TABLE registrados ADD CONSTRAINT FK_cidade_registrado FOREIGN KEY (id_cidade) REFERENCES cidades(id_chave_cidade);
ALTER TABLE registrados ADD CONSTRAINT FK_pais_registrado FOREIGN KEY (id_pais) REFERENCES paises(id_chave_pais);
ALTER TABLE registrados comment='É a tabela que registra todos os stake-holders da Lei Aldir Blanc identificados até o momento. São pessoas que podem assumir diversos papéis e têm diferentes interesses no âmbito da Lei Aldir Blanc e do Observatório: signatários de documentos, destinatários de documentos, autoridades, líderes comunitários, representantes de entidades variadas, curadores do observatório e staff do observatório, por exemplo.';
ALTER TABLE documentos add constraint fk_curador foreign key (id_curador) references registrados(id_chave_registrado);
ALTER TABLE documentos add constraint fk_tipo_de_documento foreign key (id_tipo_de_documento) references tipos_de_documentos(id_chave_tipo_de_documento);
ALTER TABLE documentos comment='Documentos guarda todos os documentos do acervo. Campos: photo_filename_documento aponta para path do documento referido pelo registro, id_curador indica quem fez a análise do documento (Registrados), id_tipo_documento aponta para Tipos_de_Documentos. É a tabela central da base da Superinterface.';
ALTER TABLE documentos_tokens ADD CONSTRAINT FK_id_documento FOREIGN KEY (id_documento) REFERENCES documentos(id_chave_documento);
ALTER TABLE documentos_tokens ADD CONSTRAINT FK_id_token FOREIGN KEY (id_token) REFERENCES tokens_no_acervo(id_chave_token_no_acervo);
ALTER TABLE documentos_tokens comment='Indica os tokens contidos num certo documento, descontados pontuação e a linha do arquivo em que esse token ocorreu. O arquivo a que se refere é um arquivo csv com uma única coluna, portanto a linha da ocorrência indica a ordem de ocorrência da palavra no text. Esta tabela permite reconstituir parcialmente o arquivo texto do documento original.';
ALTER TABLE documentos_signatarios ADD CONSTRAINT FK_signatario_documento FOREIGN KEY (id_signatario) REFERENCES registrados(id_chave_registrado);
ALTER TABLE documentos_signatarios ADD CONSTRAINT FK_documento_signatario FOREIGN KEY (id_documento) REFERENCES documentos(id_chave_documento);
ALTER TABLE documentos_signatarios comment='Estabelece uma cardinalidade N para N entre a tabela Documentos e a tabela Registrados. Indica a lista de pessoas que assinou um determinado documento ou quantos documentos foram assinados por uma pessoaa.1';
ALTER TABLE documentos_registrados ADD CONSTRAINT FK_registrado_documento FOREIGN KEY (id_registrado) REFERENCES registrados(id_chave_registrado);
ALTER TABLE documentos_registrados ADD CONSTRAINT FK_documento_registrado FOREIGN KEY (id_documento) REFERENCES documentos(id_chave_documento);
ALTER TABLE documentos_registrados comment='É uma tabela que é similar à tabela Documentos_Signatarios, mas não está restrita apenas a esse aspecto. A tabela Documentos_Registrados é mais ampla e contém o nome das pessoas que fazem parte do Staff do projeto, por exemplo. A tabela contém também o nome de curadores, ou qualquer outra pessoa com interesse na Lei Aldir Blanc. Não existe outro lugar para guardar nomes de pessoas. Esta tabela difere de documentos_signatarios porque aqui temos os nomes que aparecem no documento, mas que nao sao necessariamente signatarios';
ALTER TABLE documentos_instituicoes ADD CONSTRAINT FK_instituicao_documento FOREIGN KEY (id_instituicao) REFERENCES instituicoes(id_chave_instituicao);
ALTER TABLE documentos_instituicoes ADD CONSTRAINT FK_documento_instituicao FOREIGN KEY (id_documento) REFERENCES documentos(id_chave_documento);
ALTER TABLE documentos_instituicoes comment='Indica as instituições que aparecem num dado documento, ou os documentos que contém uma certa instituição.';
ALTER TABLE documentos_cidades ADD CONSTRAINT FK_cidade_documento FOREIGN KEY (id_cidade) REFERENCES cidades(id_chave_cidade);
ALTER TABLE documentos_cidades ADD CONSTRAINT FK_documento_cidade FOREIGN KEY (id_documento) REFERENCES documentos(id_chave_documento);
ALTER TABLE documentos_cidades comment='Registro das relações N para N de documentos e municípios brasileiros..';
ALTER TABLE instituicoes comment='Contém o registro das instituições com interesse na Lei Aldir Blanc. Pode incluir governos, organizações sociais, empresas, secretarias, etc.';
ALTER TABLE tokens_no_acervo comment='Esta tabela permite conhecer todos os tokens (exceto pontuação, etc) do acervo, sem repetições.';
ALTER TABLE names_do_brasil comment='Contém uma coletânea de nomes próprios para permitir a identificação de nomes próprios compostos/completos nos documentos. É usada através da comparação com Documentos_Tokens, verificando se há nomes próprios em sequência, caracterizando um nome própio completo (José é nome simples e José da Silva é nome composto/completo). Guarda os nomes em várias configurações de maiúsculas e minúsculas para acelerar a busca.';
ALTER TABLE tabelas_para_o_usuario comment='Contém a lista de tabelas que serão mostradas na entrada principal da plataforma Potlatch';
ALTER TABLE tabelas_de_ligacao comment='Indica todos os casos de tabelas com duas chaves externas que relações de cardinalidade N para N. Essa tabela é preenchida automaticamente toda vez que o Super_Interfaces é executado e é usada para criar as interfaces de inserção de relações N para N.';
ALTER TABLE tipos_de_documentos comment='Contém as categorias de documentos.';
ALTER TABLE estados comment='Todos os estados Brasileiros com chave externa para os países.';
ALTER TABLE paises comment='Registro de países.';
ALTER TABLE su_usuarios comment='Contém a identificação dos usuários para acesso aos ambientes restritos da Superinterface';
-- ALTER TABLE classificacoes_de_documentos comment='Uma forma mais ampla de classificar os documentos permitindo uma cardinalidade N para N, diferente de tipos_de_documentos que foi concebido para cardinalidade 1 para N.';
--
-- Populando tabela tipos_de_logradouros
--
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Avenida','Av.');
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Rua','Rua');
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Travessa','Tr.');
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Beco','Bc.');
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Alameda','Al.');
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Viela','Vl.');
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Praça','Pr.');
insert into tipos_de_logradouros (nome_tipo_de_logradouro, abreviatura) values ('Fazenda','Fz.');
--
-- Populando tabela tabelas_para_o_usuario
--
insert into tabelas_para_o_usuario (nome_tabela, descricao_tabela) values ('documentos','É a tabela onde serão inseridos novos documentos. Além disso, essa tabela permite realizar as 8 tarefas descritas no vídeo.');
insert into tabelas_para_o_usuario (nome_tabela, descricao_tabela) values ('instituicoes','É a tabela onde serão inseridas as instituições às quais os documentos farão referências.');
insert into tabelas_para_o_usuario (nome_tabela, descricao_tabela) values ('registrados','É a tabela onde serão inseridos os dados de indivíduos com algum papel a desempenhar no modelo de dados da LAB. Esse papel pode ser de staff do Wash, ou de signatário de um documento, por exemplo. Outros papéis ainda estão sendo desenvolvidos. Para as 8 tarefas descritas no vídeo, o importante é o papel de signatário. Quando um novo registrado é inserido nesta tabela, ele aparece na tabela documentos.');
--
-- Populando tabela tipos_de_documentos
--
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Tipo de documento indefinido');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Atas e registros de reuniões');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Relatório de Projetos');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Despachos, Ofícios, Memorandos e Portarias');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Planos de Trabalho, Planos de Ação, Planejamento, Propostas');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Convênios e suas minutas');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Contratos e suas minutas');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Divulgação Pública, Artigos, Boletins, Convites, Anúncios, Manifestos, Circulares, Comunicados, Discursos');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Planilha, anotações, registros soltos');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Emendas, Leis, Portarias, Decretos, Medidas Provisórias, Portarias, suas minutas e projetos');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Apresentações');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Diário Oficial');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Editais e suas minutas');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Cadastros, registros');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Requerimento, Solicitações, Petições, Questionamentos');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Cartilhas, Instruções, Manuais, Guias, Perguntas Orientadoras, Apostilas');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Denúncias, Representações');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Inquéritos, investigações');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Prestações de contas e auditorias');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Notas Técnicas, Relatórios, Pareceres, Soluções de Divergência');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Questionários, levantamentos');
INSERT INTO tipos_de_documentos (nome_tipo_de_documento) values ('Emails, Cartas');

INSERT INTO paises (nome_pais, sigla_pais, usuario) VALUES ('Brasil', 'BR', 'victor');
INSERT INTO paises (nome_pais, sigla_pais, usuario) VALUES ('Estados Unidos', 'EUA', 'victor');
INSERT INTO paises (nome_pais, sigla_pais, usuario) VALUES ('Grã-Bretanha', 'GBR', 'victor');
INSERT INTO paises (nome_pais, sigla_pais, usuario) VALUES ('França', 'FR', 'victor');
INSERT INTO paises (nome_pais, sigla_pais, usuario) VALUES ('Alemanha', 'GER', 'victor');
INSERT INTO paises (nome_pais, sigla_pais, usuario) VALUES ('Indefinido', '??', 'victor');
INSERT INTO paises (nome_pais, sigla_pais, usuario) VALUES ('Itália', 'ITA', 'victor');

INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Acre',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'AC', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Alagoas',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'AL', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Amapá',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'AP', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Amazonas',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'AM', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Bahia',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'BA', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Ceará',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'CE', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Distrito Federal',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'DF', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Espírito Santo',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'ES', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Goiás',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'GO', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Maranhão',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'MA', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Mato Grosso',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'MT', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Mato Grosso do Sul',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'MS', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Minas Gerais',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'MG', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Pará',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'PA', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Paraíba',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'PB', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Paraná',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'PR', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Pernambuco',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'PE', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Piauí',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'PI', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Rio de Janeiro',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'RJ', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Rio Grande do Norte',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'RN', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Rio Grande do Sul',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'RS', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Rondônia',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'RO', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Roraima',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'RR', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Santa Catarina',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'SC', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('São Paulo',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'SP', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Sergipe',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'SE', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Tocantins',(SELECT id_chave_pais from paises WHERE nome_pais like 'Brasil') ,'TO', 'victor');
INSERT INTO estados (nome_estado, id_pais, sigla_estado, usuario) VALUES ('Indefinido',(SELECT id_chave_pais from paises WHERE nome_pais like 'Indefinido') ,'??', 'victor');
INSERT INTO instituicoes (nome_instituicao) values ('Instituição Indefinida');
INSERT INTO registrados (nome_registrado, name_of_war, id_estado, id_pais, id_cidade) values ('signatário indefinido', 'indefinido', (select id_chave_estado from estados where nome_estado like 'Indefinido'), (select id_chave_pais from paises where nome_pais like 'Indefinido'),(select id_chave_cidade from cidades where nome_cidade like 'Indefinido'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Rafael Procópio','Rafael',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'GUARULHOS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Ricardo Palmieri','Ricardo',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'Santo Andre' and sigla_estado='SP'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Jacqueline Baumgartz','Jacke',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'SAO JOSE DOS CAMPOS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Celso','Celso',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'SAO JOSE DOS CAMPOS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Wagner Lima','Wagner',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'JACAREI'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Cleide Santos','Cleide',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'CAMPINAS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Gisele Fink','Gisele',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'BRASILIA'),(select id_chave_estado from estados where sigla_estado like 'DF'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Clotilde Diogo','Clotilde',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'CAMPINAS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Erick Mandu','Mandu',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'SAO JOSE DOS CAMPOS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Nadia','Nadia',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'RESENDE'),(select id_chave_estado from estados where sigla_estado like 'RJ'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Barbara','Barbara',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'CAMPINAS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Fabiana Kitagawa','Fabiane',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'LONDRINA'),(select id_chave_estado from estados where sigla_estado like 'PR'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Roberta','Roberta',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'CAMPINAS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Antônio','Antônio',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'BRASILIA'),(select id_chave_estado from estados where sigla_estado like 'DF'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Mirza','Mirza',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'CAMPINAS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Malu Alencar','Malu',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'CAMPINAS'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Mariana Moura','Mariana',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'São Paulo'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Ana Carolina de Deus','Carol',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'São Paulo'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));
INSERT INTO registrados (nome_registrado, name_of_war, id_cidade, id_estado, id_pais) values ('Saulo Monteiro','Saulo',(select id_chave_cidade from cidades where cidade_sem_acentuacao like 'São José dos Campos'),(select id_chave_estado from estados where sigla_estado like 'SP'),(select id_chave_pais from paises where nome_pais like 'BRASIL'));


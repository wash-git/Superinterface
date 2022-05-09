-- Update de Tabelas de dados sobre o acervo
-- ------------------------------------------
-- ------------------------------------------
--
-- Populando tabela
--
insert into su_tabelas_para_usuario (nome_tabela, descricao_tabela) values ('su_documents','É a tabela onde serão inseridos novos documentos.');
insert into su_tabelas_para_usuario (nome_tabela, descricao_tabela) values ('su_instituicoes','É a tabela onde serão inseridas as instituições às quais os documentos farão referências.');
insert into su_tabelas_para_usuario (nome_tabela, descricao_tabela) values ('su_registrados','É a tabela onde serão inseridos os dados de indivíduos com algum papel a desempenhar no modelo de dados. Esse papel pode ser de staff do Wash, ou de signatário de um documento, por exemplo. Quando um novo registrado é inserido nesta tabela, ele aparece na tabela su_documents.');
--
UPDATE su_cidades SET cidade_sem_acentuacao = UPPER(nome_cidade);
UPDATE su_cidades SET cidade_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cidade_sem_acentuacao,'Á','A'),'À','A'),'Â','A'),'Ã','A'),'Ä','A');
UPDATE su_cidades SET cidade_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cidade_sem_acentuacao,'Í','I'),'Ì','I'),'Î','I'),'Ï','I'),'Ĩ','I');
UPDATE su_cidades SET cidade_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cidade_sem_acentuacao,'É','E'),'È','E'),'Ê','E'),'Ë','E'),'Ê','E');
UPDATE su_cidades SET cidade_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cidade_sem_acentuacao,'Ó','O'),'Ò','O'),'Ô','O'),'Ö','O'),'Ô','O');
UPDATE su_cidades SET cidade_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cidade_sem_acentuacao,'Ú','U'),'Ù','U'),'Û','U'),'Ü','U'),'Û','U');
UPDATE su_cidades SET cidade_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cidade_sem_acentuacao,'Ç','C'),'Ñ','N'),'<',''),'>',''),'$','');

UPDATE su_cidades SET sigla_estado = (select sigla_estado from su_estados where codigo_estado = su_cidades.codigo_do_estado);
UPDATE su_cidades SET id_estado = (select id_chave_estado from su_estados where codigo_estado = su_cidades.codigo_do_estado);
--
INSERT INTO su_nomes_cidades(nome_cidade) SELECT nome_cidade FROM su_cidades;
INSERT INTO su_nomes_instituicoes(nome_instituicao) SELECT nome_instituicao FROM su_instituicoes;

UPDATE su_instituicoes SET instituicao_sem_acentuacao = UPPER(nome_instituicao);
UPDATE su_instituicoes SET instituicao_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(instituicao_sem_acentuacao,'Á','A'),'À','A'),'Â','A'),'Ã','A'),'Ä','A');
UPDATE su_instituicoes SET instituicao_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(instituicao_sem_acentuacao,'Í','I'),'Ì','I'),'Î','I'),'Ï','I'),'Ĩ','I');
UPDATE su_instituicoes SET instituicao_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(instituicao_sem_acentuacao,'É','E'),'È','E'),'Ê','E'),'Ë','E'),'Ê','E');
UPDATE su_instituicoes SET instituicao_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(instituicao_sem_acentuacao,'Ó','O'),'Ò','O'),'Ô','O'),'Ö','O'),'Ô','O');
UPDATE su_instituicoes SET instituicao_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(instituicao_sem_acentuacao,'Ú','U'),'Ù','U'),'Û','U'),'Ü','U'),'Û','U');
UPDATE su_instituicoes SET instituicao_sem_acentuacao = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(instituicao_sem_acentuacao,'Ç','C'),'Ñ','N'),'<',''),'>',''),'$','');

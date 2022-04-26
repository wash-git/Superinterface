-- criacao
-- -------------
CREATE TABLE su_jornalistas (id_chave_jor int not null auto_increment, nome_jor varchar(50), id_estado_jor int, primary key (id_chave_jor));
ALTER TABLE su_jornalistas ADD CONSTRAINT FK_regra_jor FOREIGN KEY (id_estado_jor) REFERENCES su_estados(id_chave_estado);
INSERT INTO su_jornalistas (nome_jor,id_estado_jor) values ('José de José',(select id_chave_estado from su_estados where codigo_estado=25));


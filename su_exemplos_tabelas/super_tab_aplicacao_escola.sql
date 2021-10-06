
create table turmas (id_chave_turma int not null auto_increment, nome_turma varchar(100), primary key (id_chave_turma), unique(nome_turma)) comment="Guarda todas as turmas da escola";

create table tipos_vinculos(id_chave_tipo_vinculo int not null auto_increment, nome_tipo_vinculo varchar(100), primary key (id_chave_tipo_vinculo)) comment="Guarda o tipo de vinculo: estudantes, professores, administracao, etc.";

create table registrados(id_chave_registrado int not null auto_increment, nome_registrado varchar(200), primary key (id_chave_registrado)) comment="Guarda as pessoas vinculadas a escola. Pode ser qualquer tipo de vinculo.";

create table turmas_registrados (id_chave_turma_registrado int not null auto_increment, nome_turma_registrado varchar(100), id_turma int, id_registrado int, id_tipo_vinculo int, primary key (id_chave_turma_registrado)) comment="Guarda os vinculos entre as turmas e os registrados, bem como o tipo de vinculo (se eh professor, aluno ou algum outro)";

create table presencas(id_chave_presenca int not null auto_increment, nome_presenca varchar(100), id_registrado int, id_evento int,  data_tempo datetime, time_stamp timestamp, primary key (id_chave_presenca)) comment="Guarda as presencas dos alunos, indicando os eventos relativos a cada presenca: saida, entrada, almoco, merenda, etc.";

create table eventos(id_chave_evento int not null auto_increment, nome_evento varchar(100), descricao varchar(1000), primary key (id_chave_evento), unique (nome_evento)) comment="Guarda eventos, tais como: entrada, saida, merenda_matinal, merenda_vespertina, almoco, Semana_Nacional_CT, etc.";

ALTER TABLE presencas ADD CONSTRAINT FK_registrado_presenca FOREIGN KEY (id_registrado) REFERENCES registrados(id_chave_registrado);
ALTER TABLE presencas ADD CONSTRAINT FK_evento_presenca FOREIGN KEY (id_evento) REFERENCES eventos(id_chave_evento);
ALTER TABLE turmas_registrados ADD CONSTRAINT FK_turma_registrado FOREIGN KEY (id_turma) REFERENCES turmas(id_chave_turma);
ALTER TABLE turmas_registrados ADD CONSTRAINT FK_registrado_turma FOREIGN KEY (id_registrado) REFERENCES registrados(id_chave_registrado);
ALTER TABLE turmas_registrados ADD CONSTRAINT FK_registrado_vinculo FOREIGN KEY (id_tipo_vinculo) REFERENCES tipos_vinculos(id_chave_tipo_vinculo);


insert into eventos(nome_evento) values ("Entrada");
insert into eventos(nome_evento) values ("Saida");
insert into eventos(nome_evento) values ("Merenda_Matinal");
insert into eventos(nome_evento) values ("Merenda_Verpertina");
insert into eventos(nome_evento) values ("Almoco");

insert into tipos_vinculos(nome_tipo_vinculo) values ("nao_aplica");
insert into tipos_vinculos(nome_tipo_vinculo) values ("estudante");
insert into tipos_vinculos(nome_tipo_vinculo) values ("diretor(a)");
insert into tipos_vinculos(nome_tipo_vinculo) values ("professor(a)");

insert into tipos_vinculos (nome_tipo_vinculo) values ("REGENTE MULTIPLICADOR TDCIS");
insert into tipos_vinculos (nome_tipo_vinculo) values ("REGENTE DE PROJETO PEDAGOGICO");
insert into tipos_vinculos (nome_tipo_vinculo) values ("REGENTE DE P5");
insert into tipos_vinculos (nome_tipo_vinculo) values ("REGENTE");


insert into turmas (nome_turma) values ("nao_aplica");
insert into turmas (nome_turma) values ("Primeiro Ano A");
insert into turmas (nome_turma) values ("Primeiro Ano B");

insert into turmas (nome_turma) values ("Segundo Ano A");
insert into turmas (nome_turma) values ("Segundo Ano B");

insert into turmas (nome_turma) values ("Terceiro Ano A");
insert into turmas (nome_turma) values ("Terceiro Ano B");
insert into turmas (nome_turma) values ("P5A");



insert into registrados (nome_registrado) values ("HANNA JULIE BOA NORA");
insert into registrados (nome_registrado) values ("GOODSTART TONY AMARAL MARQUES");
insert into registrados (nome_registrado) values ("HOMEM CARRO SCALLOP DOS SAINTS");
insert into registrados (nome_registrado) values ("ITSLISA OAK DE IAMSA");
insert into registrados (nome_registrado) values ("EBARUELLY DOS SAINTS PEAR");
insert into registrados (nome_registrado) values ("CRAVOCANELA SUMMERNESI TEN");
insert into registrados (nome_registrado) values ("ISADORA PERU DE ALMOD");
insert into registrados (nome_registrado) values ("JULIE DE OLIVES ALMOD");
insert into registrados (nome_registrado) values ("JULIAN ROGGERS GOODETTI");
insert into registrados (nome_registrado) values ("WASHINIA ANY COOPER PINK");
insert into registrados (nome_registrado) values ("LIVID BACKAGAIN OAK DOS SAINTS");
insert into registrados (nome_registrado) values ("BARUELA DE ALMOD GALANT");
insert into registrados (nome_registrado) values ("MARY ALIVE CLUMSY");
insert into registrados (nome_registrado) values ("MARY ALIVE VILLAGE DE GRAVEL");
insert into registrados (nome_registrado) values ("MICHAEL COOKLINHA E HISS");
insert into registrados (nome_registrado) values ("MICHAEL GRANDE AISK FERREIRA");
insert into registrados (nome_registrado) values ("MICHAEL PEAR DA HISS");
insert into registrados (nome_registrado) values ("OLIVID CLUMSY DE BUSHS");
insert into registrados (nome_registrado) values ("PETER HYADD MAISEIRA DA HISS");
insert into registrados (nome_registrado) values ("ROYAL AIR FORCE BEARDOSA LOPES");
insert into registrados (nome_registrado) values ("ROYAL AIR FORCE MENEZES DE MAISGOLD");
insert into registrados (nome_registrado) values ("BACKAGAIN DA PINK RIVER");
insert into registrados (nome_registrado) values ("BACKAGAIN DE CHRIST DE IAMZA ROGGERS");
insert into registrados (nome_registrado) values ("SARAHVANA CRICKET MINHA TIA");
insert into registrados (nome_registrado) values ("PETERA PEAR SHOAL");
insert into registrados (nome_registrado) values ("HANNA LEWIS RABBIT PINK");
insert into registrados (nome_registrado) values ("FRANKLIN DE IAMZA");
insert into registrados (nome_registrado) values ("ROYAL AIR FORCE APARECIDO BARRETO TRINDADE");
insert into registrados (nome_registrado) values ("GABRO JANUARY");
insert into registrados (nome_registrado) values ("JPEG MICHAEL ROGGERS DE IAMZA");
insert into registrados (nome_registrado) values ("EMILIA RIVER CREVER");
insert into registrados (nome_registrado) values ("MICHAEL GOALVEIN LAMB");
insert into registrados (nome_registrado) values ("AIRTUR OAK DE OLIVES");
insert into registrados (nome_registrado) values ("LEILOA DE IAMSA BERVEGLIERI MELLO");
insert into registrados (nome_registrado) values ("CHRISTIAN IRONAZ");
insert into registrados (nome_registrado) values ("ZAZIELLE DE IAMZA DEP");
insert into registrados (nome_registrado) values ("MARY CHRISTIAN DE SOUZA MARCUCCI");
insert into registrados (nome_registrado) values ("HISSANA SOUNDS DE PERU");

insert into registrados(nome_registrado) values ( "nao_aplica");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="nao_aplica"),(select id_chave_turma from turmas where nome_turma="nao_aplica"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="nao_aplica"));

insert into registrados(nome_registrado) values ( "Joana");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Joana"),(select id_chave_turma from turmas where nome_turma="Primeiro Ano A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados(nome_registrado) values ( "Tatiane");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Tatiane"),(select id_chave_turma from turmas where nome_turma="Primeiro Ano A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados(nome_registrado) values ( "Alfredo");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Alfredo"),(select id_chave_turma from turmas where nome_turma="Primeiro Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados(nome_registrado) values ( "Maria");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Maria"),(select id_chave_turma from turmas where nome_turma="Primeiro Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados(nome_registrado) values ( "Pedro");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Pedro"),(select id_chave_turma from turmas where nome_turma="Primeiro Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados (nome_registrado) values ( "Isabela");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Isabela"),(select id_chave_turma from turmas where nome_turma="Segundo Ano A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados (nome_registrado) values ( "Victoria");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Victoria"),(select id_chave_turma from turmas where nome_turma="Segundo Ano A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));



insert into registrados (nome_registrado) values ( "Jose");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Jose"),(select id_chave_turma from turmas where nome_turma="Segundo Ano A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados (nome_registrado) values ( "Mario");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Mario"),(select id_chave_turma from turmas where nome_turma="Segundo Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados (nome_registrado) values ( "Roberto");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Roberto"),(select id_chave_turma from turmas where nome_turma="Segundo Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados (nome_registrado) values ( "Paulo");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Paulo"),(select id_chave_turma from turmas where nome_turma="Segundo Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados (nome_registrado) values ( "Fabio");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Fabio"),(select id_chave_turma from turmas where nome_turma="Segundo Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));

insert into registrados (nome_registrado) values ( "Carolina");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Carolina"),(select id_chave_turma from turmas where nome_turma="Terceiro Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));


insert into registrados (nome_registrado) values ("Roberta");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Roberta"),(select id_chave_turma from turmas where nome_turma="Terceiro Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="professor(a)"));

insert into registrados (nome_registrado) values ("Paula");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Paula"),(select id_chave_turma from turmas where nome_turma="Primeiro Ano B"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="professor(a)"));

insert into registrados (nome_registrado) values ("Fabia");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Fabia"),(select id_chave_turma from turmas where nome_turma="Primeiro Ano A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="professor(a)"));

insert into registrados (nome_registrado) values ("Tania");
insert into turmas_registrados (id_registrado, id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="Tania"),(select id_chave_turma from turmas where nome_turma="Segundo Ano A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="professor(a)"));



insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="HANNA JULIE BOA NORA"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="GOODSTART TONY AMARAL MARQUES"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="HOMEM CARRO SCALLOP DOS SAINTS"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="ITSLISA OAK DE IAMSA"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="EBARUELLY DOS SAINTS PEAR"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="CRAVOCANELA SUMMERNESI TEN"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="ISADORA PERU DE ALMOD"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="JULIE DE OLIVES ALMOD"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="JULIAN ROGGERS GOODETTI"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="WASHINIA ANY COOPER PINK"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="LIVID BACKAGAIN OAK DOS SAINTS"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="BARUELA DE ALMOD GALANT"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="MARY ALIVE CLUMSY"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="MARY ALIVE VILLAGE DE GRAVEL"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="MICHAEL COOKLINHA E HISS"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="MICHAEL GRANDE AISK FERREIRA"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="MICHAEL PEAR DA HISS"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="OLIVID CLUMSY DE BUSHS"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="PETER HYADD MAISEIRA DA HISS"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="ROYAL AIR FORCE BEARDOSA LOPES"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="ROYAL AIR FORCE MENEZES DE MAISGOLD"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="BACKAGAIN DA PINK RIVER"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="BACKAGAIN DE CHRIST DE IAMZA ROGGERS"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="SARAHVANA CRICKET MINHA TIA"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="PETERA PEAR SHOAL"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="HANNA LEWIS RABBIT PINK"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="FRANKLIN DE IAMZA"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="ROYAL AIR FORCE APARECIDO BARRETO TRINDADE"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="GABRO JANUARY"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="JPEG MICHAEL ROGGERS DE IAMZA"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="EMILIA RIVER CREVER"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="MICHAEL GOALVEIN LAMB"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="AIRTUR OAK DE OLIVES"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="LEILOA DE IAMSA BERVEGLIERI MELLO"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="estudante"));


insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="CHRISTIAN IRONAZ"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="REGENTE MULTIPLICADOR TDCIS"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="ZAZIELLE DE IAMZA DEP"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="REGENTE DE PROJETO PEDAGOGICO"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="MARY CHRISTIAN DE SOUZA MARCUCCI"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="REGENTE DE P5"));
insert into turmas_registrados (id_registrado,id_turma, id_tipo_vinculo) values ((select id_chave_registrado from registrados where nome_registrado="HISSANA SOUNDS DE PERU"),(select id_chave_turma from turmas where nome_turma="P5A"),(select id_chave_tipo_vinculo from tipos_vinculos where nome_tipo_vinculo="REGENTE"));


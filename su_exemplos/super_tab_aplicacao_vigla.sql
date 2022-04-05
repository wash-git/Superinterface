
create table diretorios_imagens (id_chave_diretorio_imagem int not null auto_increment, nome_diretorio_imagem varchar(200), descricao varchar(1000), primary key (id_chave_diretorio_imagem), unique(nome_diretorio_imagem)) comment="Contém os nomes dos diretórios apontados pelas cãmeras, onde elas vão guardar as imagens. Esses diretórios são definidos pelo servidor e são diferentes dos diretorios de motion detectoin.";

create table tipos_imagens (id_chave_tipo_imagem int not null auto_increment, nome_tipo_imagem varchar(200), descricao varchar(1000), primary key (id_chave_tipo_imagem), unique (nome_tipo_imagem)) comment="Indica o tipo de imagem que esta armazenada, que pode ser foi_tratada, mask_obtida ou outra.";

create table tipos_capturas (id_chave_tipo_captura int not null auto_increment, nome_tipo_captura varchar(200), descricao varchar(1000), primary key (id_chave_tipo_captura), unique(nome_tipo_captura)) comment="Guarda o tipo de captura da câmera, que pode ser basicamente snapshot ou streaming. O streaming eh normalmente relacionado à captura por RTSP. O Sistema, no modo streaming, joga fora frames para tratar com um frequencia maior, tornando o processo menos custoso para o processador.";

create table resolucoes_de_armazenagem (id_chave_resolucao_de_armazenagem int not null auto_increment, nome_resolucao_de_armazenagem varchar(100), descricao varchar(1000), primary key(id_chave_resolucao_de_armazenagem), unique(nome_resolucao_de_armazenagem));

create table cameras 
       (id_chave_camera int not null auto_increment, 
	nome_camera varchar(200) comment "Nome da câmera.", 
	ip varchar(20) comment "ip da câmera", 
	basefilename varchar(500) comment "base do nome que será gravado no diretório, que será seguido de data e hora.", 
	localizacao varchar(300) comment "localização da câmera", 
	id_resolucao int comment "Resolução atribuída à câmera, que pode ser diferente da resolução máxima. (por exemplo, a DLink permite escolher a resolução)", 
	id_resolucao_de_tratamento int comment "É a resolução de tratamento das imagens, que pode ser menor do que a resolucao da camera para melhorar o desempenho. Serve para reduzir a resolucao de tratamento em cameras tipo FULL HD, porque o algoritmo HOG pode ficar impraticavel e o ganho em tratar com alta resolucao nao eh vantajoso.", 
	marca varchar(100) comment "Marca da câmera", 
	admin varchar(100) default "admin" comment "Nome do usuário de administração", 
	senha varchar(20) comment "senha do usuario de administracao", 
	codigo_stream varchar(1000) comment "Codigo URL para acessar streaming da camera por http", 
	codigo_jpeg varchar(100) comment "Codigo URL para acessar um snapshot da camera por http", 
	codigo_rtsp varchar(100) comment "Codigo URL para acessar o Streaming por protocolo RTSP", 
	id_tipo_captura int comment "chave que aponta para a tabela tipos_capturas, identificando se a captura eh por streaming_http, snapshot_http ou streaming rtsp", 
	winstride_x int comment "parametro da janela de HOG horizontal. Normalmente 4. Numeros muito pequenos deixam o sistema lento. Numeros muito grandes fazer a deteccao perder detalhes. Na versao 6_vigla_yolo para cima nao eh usado", 
	winstride_y int comment "parametro da janela de HOG horizontal. Normalmente 4. Numeros muito pequenos deixam o sistema lento. Numeros muito grandes fazer a deteccao perder detalhes.Na versao 6_vigla_yolo para cima nao eh usado", 
	periodo_amostragem int default 1 comment "periodo minimo de amostragem de imagens (em milisegundos)", 
	periodo_referencia int default 1 comment "Define o periodo minimo de armazenagem de imagens de referencia, que sao armazenadas independentemente de haver deteccao de humanos (em segundos)",
	id_tratamento_imagem int comment "Indica o tipo de tratamento de imagem usado antes de passar os algoritmos HOG e de deteccao de movimento", 
	id_armazenagem_imagem int comment "Indica o tratamento que serah aplicado no armazenamento das imagens",
	carimba_retangulos varchar(3) default "sim" comment "define se os retângulos de deteccao de humanos e movimentos serao carimbados na imagem de deteccao", 
	motion_detection_dir varchar(100) default "none" comment "Ainda nao implementado, serah o diretorio para guardar as imagens de deteccao obtidas a partir da camera por FTP. Nem todas as cameras tem recursos de FTP.", 
	id_diretorio_imagem int comment "Diretorio onde as imagens amostradas sao armazenadas, juntamente com as imagens armazenadas regularmente", 
	fracao_area_max float comment "Linha de corte para deteccao de movimento - por exemplo, se a camera muda de modo diurno para noturno, ha uma grande deteccao de movimento que eh um falso positivo. Eh preciso descartar isso.", 
	fracao_area_min float comment "Linha de corte para pequenos movimentos (folhas de arvores, por exemplo).",
	duracao_seq_move_detect float default 3 comment "Duracao maxima da sequencia (em segundos) disparada depois que um movimento por contour foi detectada",
	duracao_seq_humano_detect float default 5 comment "Duracao maxima da sequencia (segundos) disparada depois que o YOLO detectou presenca humana. Em geral este parametro eh maior do que duracao_seq_move_detect",
	intervalo_detecta_humanos float default 2 comment "Intervalo minimo em segundos entre tentativas de detectar humanos pelo YOLO. Visa reduzir a sobrecarga no processador.",
	id_tipo_sequencia int comment "Indica o tipo de armazenamento de vídeo: mp4 ou sequencia de jpgs?",
	id_resolucao_de_armazenagem int comment "Indica a resolucao de armazenamento da imagem. Pode ser a resolucao original (id_resolucao) ou a resolucao de tratamento (id_resolucao_de_tratamento)",	
	time_stamp timestamp(6), 
		primary key (id_chave_camera), 
		unique (nome_camera)) 
comment="Guarda informacoes sobre cada camera do sistema. Parametros: winstride eh do HOG, periodo_referencia eh o intervalo em segundos de coleta de imagens de referencia, codigos sao as urls de acesso aos servicos da camera. Ele sempre grava o tratamento. Se tiver armazenagem, grava dois arquivos. Carimba_retangulos pode ser sim ou nao. Periodo_amostragem guarda o periodo de amostragem de deteccao em milisegundos.";

create table tratamentos_imagem (id_chave_tratamento_imagem int not null auto_increment, nome_tratamento_imagem varchar(200), descricao varchar(1000), time_stamp timestamp(6), primary key (id_chave_tratamento_imagem), unique(nome_tratamento_imagem)) comment="Identifica o tipo de tratamento que será aplicado para as imagens.";
create table registrados (id_chave_registrado int not null auto_increment, nome_registrado varchar(200), senha varchar(50), telefone varchar(20), primary key (id_chave_registrado), unique (telefone)) comment="Pessoas registradas no sistema.";

create table atribuicoes (id_chave_atribuicao int not null auto_increment, nome_atribuicao varchar(100), primary key (id_chave_atribuicao), unique (nome_atribuicao)) comment="atribuicoes as pessaos registradas no sistema";

create table atribuicoes_registrados (id_chave_atribuicao_registrado int not null auto_increment, id_registrado int, id_atribuicao int, primary key (id_chave_atribuicao_registrado)) comment="Liga a tabela atribuicoes a tabela registrados";

create table tipos_sequencias (id_chave_tipo_sequencia int not null auto_increment, nome_tipo_sequencia varchar(100), time_stamp timestamp(6), primary key (id_chave_tipo_sequencia), unique (nome_tipo_sequencia)) comment = "Guarda os tipos de sequencias. Por exemplo: se a sequencia eh um mp4 ou se eh uma justaposicao de jpegs";

create table sequencias (id_chave_sequencia int not null auto_increment, nome_sequencia varchar(100), id_camera int, data_hora datetime comment "comeco da sequencia, quando foi ativada por um YOLO, HOG ou Contour", id_tipo_sequencia int comment "indica se a sequencia eh do tipo mp4, ou uma justaposicao de jpg", time_stamp timestamp(6), primary key (id_chave_sequencia), unique (nome_sequencia)) comment="Cria a liga entre as imagens, para formarem sequencias com um singificado. Imagens tem id_sequencia, que indica a que sequencia pertencem.";

create table imagens (id_chave_imagem int not null auto_increment, nome_imagem varchar(100), id_camera int, data_hora datetime, id_tipo_imagem int, photo_filename_imagem varchar(100), time_stamp timestamp(6), intervalo float, deletado int default 0, com_humanos int default 0, HOG_detect int default 0, mov_contour_detect int default 0, HOG_mov_match float default 0, razao_aspecto_mov float default 1, id_sequencia int, primary key (id_chave_imagem), unique(id_tipo_imagem, nome_imagem), unique(photo_filename_imagem)) comment="Contem todas as imagens registradas. Vincula-se as cameras pelo id_camera. Contem um link para as imagens.";

create table imagens_de_referencia (id_chave_imagem_de_referencia int not null auto_increment, nome_imagem_de_referencia varchar(100), id_camera int, data_hora datetime, photo_filename_imagem_de_referencia varchar(100), time_stamp timestamp(6), intervalo float, deletado int default 0, primary key (id_chave_imagem_de_referencia), unique(nome_imagem_de_referencia), unique(photo_filename_imagem_de_referencia)) comment="Contem as imagens de referencia obtidas quando o algoritmo de deteccao nao identifica um humano. Essa imagem eh armazenada para sofrer media e depois ser comparada com as que tem humanos. Vincula-se as cameras pelo id_camera. Contem um link para as imagens.";

create table retangulos (id_chave_retangulo int not null auto_increment, nome_retangulo varchar (100), xA int, yA int, xB int, yB int, peso float, id_imagem int, id_tipo_alerta int, id_retangulo_viciado int, primary key (id_chave_retangulo)) comment="Contem todos os retangulos identificadores de humanos, podendo haver mais de um retangulo por humano. Se nao aponta para um retangulo viciado, entao eh um alerta real. Se aponta eh um falso positivo. Retangulo obtido a partir do HOG.";

create table retangulos_fgbg (id_chave_retangulo_fgbg int not null auto_increment, nome_retangulo_fgbg varchar (100), xA int, yA int, xB int, yB int, id_imagem int, id_tipo_alerta int, primary key (id_chave_retangulo_fgbg)) comment="Contem todos os retangulos identificadores de humanos, obtidos por meio da tecnica de remocao de background, ou seja, tirando media de imagens e comparando com a imagem recem chegada. Note que nao eh usada a tecnica hog e o retangulo eh obtido a partir do CONTOUR obtido da imagem de threshold. Nao precisa identificar retangulos viciados. Taxa de falsos positivos eh baixa";

create table retangulos_viciados (id_chave_retangulo_viciado int not null auto_increment, nome_retangulo_viciado varchar(200), ocorrencias int, id_camera int, media_peso float, desvio_peso float, xAmin int, xAmax int, yAmin int, yAmax int, xBmin int, xBmax int, yBmin int, yBmax int, dxA varchar(30), dyA varchar(30), dxB varchar(30), dyB varchar(30), falso_positivo int default 0, primary key (id_chave_retangulo_viciado), unique(dxA, dyA, dxB, dyB), unique (nome_retangulo_viciado)) comment="Guarda as janelas de ocorrencia dos retangulos, indicando se aquela janela eh mais provavel para falsos positivos. O treinamento com imagens sem humanos permite determinar os falsos positivos. Zero em falso_positivo significa que nao eh falso positivo. 1 significa que eh falso positivo.";

create table tipos_alertas (id_chave_tipo_alerta int not null auto_increment, nome_tipo_alerta varchar(100), alias varchar(100), primary key (id_chave_tipo_alerta)) comment="Guarda o nome do tipo de alerta (gente, carro, etc). Alias eh a traducao para o portugues";

create table resolucoes (id_chave_resolucao int not null auto_increment, nome_resolucao varchar(100), largura int, altura int, descricao varchar(500), primary key(id_chave_resolucao)) comment="contem os tipos de resolucoes";

ALTER TABLE atribuicoes_registrados ADD CONSTRAINT FK_atribuicao_registrado FOREIGN KEY (id_atribuicao) REFERENCES atribuicoes(id_chave_atribuicao);
ALTER TABLE atribuicoes_registrados ADD CONSTRAINT FK_registrado_atribuicao FOREIGN KEY (id_registrado) REFERENCES registrados(id_chave_registrado);

ALTER TABLE sequencias ADD CONSTRAINT FK_camera_sequencia FOREIGN KEY (id_camera) REFERENCES cameras(id_chave_camera);
ALTER TABLE sequencias ADD CONSTRAINT FK_tipo_sequencia FOREIGN KEY (id_tipo_sequencia) REFERENCES tipos_sequencias(id_chave_tipo_sequencia);

ALTER TABLE imagens ADD CONSTRAINT FK_camera_imagem FOREIGN KEY (id_camera) REFERENCES cameras(id_chave_camera);
ALTER TABLE imagens ADD CONSTRAINT FK_tipo_imagem FOREIGN KEY (id_tipo_imagem) REFERENCES tipos_imagens(id_chave_tipo_imagem);
ALTER TABLE imagens ADD CONSTRAINT FK_imagem_sequencia FOREIGN KEY (id_sequencia) REFERENCES sequencias(id_chave_sequencia);

ALTER TABLE retangulos ADD CONSTRAINT FK_imagem_retangulo FOREIGN KEY (id_imagem) REFERENCES imagens(id_chave_imagem);
ALTER TABLE retangulos ADD CONSTRAINT FK_tipo_alerta_retangulo FOREIGN KEY (id_tipo_alerta) REFERENCES tipos_alertas(id_chave_tipo_alerta);
ALTER TABLE retangulos ADD CONSTRAINT FK_tipo_viciado_retangulo FOREIGN KEY (id_retangulo_viciado) REFERENCES retangulos_viciados(id_chave_retangulo_viciado);
ALTER TABLE retangulos_fgbg ADD CONSTRAINT FK_imagem_retangulo_fgbg FOREIGN KEY (id_imagem) REFERENCES imagens(id_chave_imagem);
ALTER TABLE retangulos_fgbg ADD CONSTRAINT FK_tipo_alerta_retangulo_fgbg FOREIGN KEY (id_tipo_alerta) REFERENCES tipos_alertas(id_chave_tipo_alerta);
ALTER TABLE retangulos_viciados ADD CONSTRAINT FK_camera_viciado FOREIGN KEY (id_camera) REFERENCES cameras(id_chave_camera);

ALTER TABLE cameras ADD CONSTRAINT FK_resolucao_camera FOREIGN KEY (id_resolucao) REFERENCES resolucoes(id_chave_resolucao);
ALTER TABLE cameras ADD CONSTRAINT FK_resolucao_tratamento_camera FOREIGN KEY (id_resolucao_de_tratamento) REFERENCES resolucoes(id_chave_resolucao);
ALTER TABLE cameras ADD CONSTRAINT FK_tratamento_camera FOREIGN KEY (id_tratamento_imagem) REFERENCES tratamentos_imagem(id_chave_tratamento_imagem);
ALTER TABLE cameras ADD CONSTRAINT FK_armazenagem_camera FOREIGN KEY (id_armazenagem_imagem) REFERENCES tratamentos_imagem(id_chave_tratamento_imagem);
ALTER TABLE cameras ADD CONSTRAINT FK_diretorio_camera FOREIGN KEY (id_diretorio_imagem) REFERENCES diretorios_imagens(id_chave_diretorio_imagem);
ALTER TABLE cameras ADD CONSTRAINT FK_tipo_captura FOREIGN KEY (id_tipo_captura) REFERENCES tipos_capturas(id_chave_tipo_captura);
ALTER TABLE cameras ADD CONSTRAINT FK_camera_tipo_sequencia FOREIGN KEY (id_tipo_sequencia) REFERENCES tipos_sequencias(id_chave_tipo_sequencia);
ALTER TABLE cameras ADD CONSTRAINT FK_camera_res_armazenagem FOREIGN KEY (id_resolucao_de_armazenagem) REFERENCES resolucoes_de_armazenagem(id_chave_resolucao_de_armazenagem);

insert into resolucoes_de_armazenagem (nome_resolucao_de_armazenagem, descricao) values ("resolucao_original", "Armazena a imagem da sequencia na resolucao original da camera indicada na base de dados (campo id_resolucao). Nao vale para o primeiro frame da sequencia.");
insert into resolucoes_de_armazenagem (nome_resolucao_de_armazenagem, descricao) values ("resolucao_de_tratamento", "Todos os frames da sequencia sao armazenados na resolucao de tratamento, indicada em id_resolucao_de_tratamento");


insert into tipos_sequencias (nome_tipo_sequencia) values ("Video MP4");
insert into tipos_sequencias (nome_tipo_sequencia) values ("Sequencia de JPEGs");

insert into tipos_imagens(nome_tipo_imagem, descricao) values ("mask", "Máscara obtida a partir do sistema de contorno. Serve para analisar se a câmera está conseguindo detectar o movimento.");
insert into tipos_imagens(nome_tipo_imagem, descricao) values ("para_tratamento", "Eh a imagem que serah tratada.");
insert into tipos_imagens(nome_tipo_imagem, descricao) values ("original", "Imagem original sem tratamento.");
insert into tipos_imagens(nome_tipo_imagem, descricao) values ("carimbada", "Com retangulos.");


insert into tipos_capturas(nome_tipo_captura, descricao) values ("streaming_http", "Streaming de video que precisará ser processado para reduzir a taxa de tratamento das imagens para não sobrecarregar o servidor. Obtido por meio do protocolo http.");
insert into tipos_capturas(nome_tipo_captura, descricao) values ("streaming_rtsp", "Streaming de video que precisará ser processado para reduzir a taxa de tratamento das imagens para não sobrecarregar o servidor. Obtido por meio de protocolo RTSP");
insert into tipos_capturas(nome_tipo_captura, descricao) values ("snapshot", "Obtem uma imagem de cada vez e não via streaming de video.");
insert into tipos_capturas(nome_tipo_captura, descricao) values ("dummy", "Apenas para nao deixar o campo com valor inválido.");


insert into resolucoes (nome_resolucao, largura, altura, descricao) values ("1920x1080",1920, 1080, "FULL HD");
insert into resolucoes (nome_resolucao, largura, altura, descricao) values ("640x480",640, 480, "VGA");
insert into resolucoes (nome_resolucao, largura, altura, descricao) values ("dummy",640, 480, "Dummy");
insert into resolucoes (nome_resolucao, largura, altura, descricao) values ("nao_aplicar", NULL, NULL, "não aplicar");

insert into tratamentos_imagem (nome_tratamento_imagem, descricao) values ("gray", "Aplica o filtro gray (pode ser usado para armazenagem  e para tratamento)");
insert into tratamentos_imagem (nome_tratamento_imagem, descricao) values ("color","Aplica o filtro color (pode ser usado  para armazenagem e para tratamento)" );
insert into tratamentos_imagem (nome_tratamento_imagem, descricao) values ("mantem_original","Não aplica filtro e mantém o original. Quando aplicado à armazenagem, grava o orginal. Quando aplicado ao tratamento, trata o original.");

insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base");
insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base2");
insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base3");
insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base6");
insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base7");
insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base8");
insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base11");
insert into diretorios_imagens (nome_diretorio_imagem, descricao) values ("imagens_na_base12", "teste de armazenagem com resolucao_original e teste de integracao de sequencias subsequentes");
insert into diretorios_imagens (nome_diretorio_imagem, descricao) values ("imagens_na_base9", "Diretorio para tentar o gerador de sequencias com seq no nome.");
insert into diretorios_imagens (nome_diretorio_imagem) values ("imagens_na_base_teste_giga");

insert into tratamentos_imagem (nome_tratamento_imagem, descricao) values ("nao_tem", "Quando aplicado a tratamento, tem o mesmo efeito que mantem_original. Quando aplicado a armazenagem, nao ha armazenamento.");

insert into cameras (
	nome_camera, 
	ip, 
	basefilename, 
	localizacao, 
	id_resolucao, id_resolucao_de_tratamento, 
	marca, 
	admin, 
	senha, 
	codigo_stream, 
	codigo_jpeg, 
	codigo_rtsp, 
	id_tipo_captura, 
	winstride_x, 
	winstride_y, 
	id_tratamento_imagem, 
	id_armazenagem_imagem, 
	fracao_area_max, 
	fracao_area_min, 
	id_diretorio_imagem,
	id_tipo_sequencia,
	id_resolucao_de_armazenagem) 
values (
	"china", 
	"192.168.0.15", 
	"china", 
	"PQP", 
	(select id_chave_resolucao from resolucoes where nome_resolucao like "1920X1080"), 
	(select id_chave_resolucao from resolucoes where nome_resolucao like "640x480"), 
	"cacagoo", 
	"", 
	"", 
	"none", 
	"none", 
	"//live/ch00_1", 
	(select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura="streaming_rtsp"), 
	4, 
	4, 
	(select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "gray"), 
	(select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 
	0.3, 
	0.01, 
	(select id_chave_diretorio_imagem from diretorios_imagens where nome_diretorio_imagem like "imagens_na_base6"),
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")
	);


insert into cameras (
	nome_camera, 
	ip, 
	basefilename, 
	localizacao, 
	id_resolucao, id_resolucao_de_tratamento, 
	marca, 
	admin, 
	senha, 
	codigo_stream, 
	codigo_jpeg, 
	codigo_rtsp, 
	id_tipo_captura, 
	winstride_x, 
	winstride_y, 
	id_tratamento_imagem, 
	id_armazenagem_imagem, 
	fracao_area_max, 
	fracao_area_min, 
	id_diretorio_imagem,
	id_tipo_sequencia,
	id_resolucao_de_armazenagem)
values (
	"giga", 
	"192.168.10.213", 
	"GIGA_GS_0369", 
	"PQP", 
	(select id_chave_resolucao from resolucoes where nome_resolucao like "1920X1080"), 
	(select id_chave_resolucao from resolucoes where nome_resolucao like "640x480"), 
	"GIGA", 
	"admin", 
	"Admin13", 
	"none", 
	"none", 
	"//live/ch00_1", 
	(select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura="streaming_rtsp"), 
	4, 
	4, 
	(select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "mantem_original"), 
	(select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 
	0.3, 
	0.01, 
	(select id_chave_diretorio_imagem from diretorios_imagens where nome_diretorio_imagem like "imagens_na_base9"),
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")

);

insert into cameras (
	nome_camera, 
	ip, 
	basefilename, 
	localizacao, 
	id_resolucao, id_resolucao_de_tratamento, 
	marca, 
	admin, 
	senha, 
	codigo_stream, 
	codigo_jpeg, 
	codigo_rtsp, 
	id_tipo_captura, 
	winstride_x, 
	winstride_y, 
	id_tratamento_imagem, 
	id_armazenagem_imagem, 
	fracao_area_max, 
	fracao_area_min, 
	id_diretorio_imagem,
	id_tipo_sequencia,
	id_resolucao_de_armazenagem 
) 
values (
	"giga2", 
	"192.168.10.245", 
	"GIGA_GS_0369_2", 
	"PQP", 
	(select id_chave_resolucao from resolucoes where nome_resolucao like "1920X1080"), 
	(select id_chave_resolucao from resolucoes where nome_resolucao like "640x480"), 
	"GIGA", 
	"admin", 
	"Admin13", 
	"none", 
	"none", 
	"//live/ch00_1", 
	(select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura="streaming_rtsp"), 
	4, 
	4, 
	(select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "mantem_original"), 
	(select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 
	0.3, 
	0.01, 
	(select id_chave_diretorio_imagem from diretorios_imagens where nome_diretorio_imagem like "imagens_na_base9"),
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")

);


insert into cameras (nome_camera, ip, basefilename, localizacao, id_resolucao, id_resolucao_de_tratamento, marca, admin, senha, codigo_stream, codigo_jpeg, codigo_rtsp, id_tipo_captura, winstride_x, winstride_y, id_tratamento_imagem, id_armazenagem_imagem, fracao_area_max, fracao_area_min, id_diretorio_imagem, id_tipo_sequencia,
	id_resolucao_de_armazenagem) values ("serra1", "192.168.15.112", "DCS_932L_", "PQP", (select id_chave_resolucao from resolucoes where nome_resolucao="640x480"), (select id_chave_resolucao from resolucoes where nome_resolucao="nao_aplicar"), "Dlink", "admin", "", "/VIDEO.CGI", "/image/jpeg.cgi", "//live/ch00_1", (select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura="snapshot"), 4, 4, (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "gray"), (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 0.3, 0.01, (select id_chave_diretorio_imagem from diretorios_imagens where nome_diretorio_imagem like "imagens_na_base3"),
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")

);

insert into cameras (nome_camera, ip, basefilename, localizacao, id_resolucao, id_resolucao_de_tratamento, marca, admin, senha, codigo_stream, codigo_jpeg, codigo_rtsp, id_tipo_captura, winstride_x, winstride_y, id_tratamento_imagem, id_armazenagem_imagem, fracao_area_max, fracao_area_min, id_diretorio_imagem, id_tipo_sequencia,
	id_resolucao_de_armazenagem) values ("serra2", "192.168.15.133", "DCS_932L_B0C55428BC59", "PQP", (select id_chave_resolucao from resolucoes where nome_resolucao="640x480"), (select id_chave_resolucao from resolucoes where nome_resolucao="nao_aplicar"), "Dlink", "admin", "", "/VIDEO.CGI", "/image/jpeg.cgi", "//live/ch00_1", (select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura="snapshot"), 4, 4, (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "gray"), (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 0.3, 0.01, (select id_chave_diretorio_imagem from diretorios_imagens where nome_diretorio_imagem like "imagens_na_base3"),
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")

);

insert into cameras (nome_camera, ip, basefilename, localizacao, id_resolucao, id_resolucao_de_tratamento, marca, admin, senha, codigo_stream, codigo_jpeg, codigo_rtsp, id_tipo_captura, winstride_x, winstride_y, id_tratamento_imagem, id_armazenagem_imagem, fracao_area_max, fracao_area_min, id_diretorio_imagem, id_tipo_sequencia,
	id_resolucao_de_armazenagem) values ("deusdete1", "192.168.0.22", "DCS_932L_B0C55411B0A1", "PQP", (select id_chave_resolucao from resolucoes where nome_resolucao="640x480"), (select id_chave_resolucao from resolucoes where nome_resolucao="nao_aplicar"), "Dlink", "admin", "", "/VIDEO.CGI", "/image/jpeg.cgi", "//live/ch00_1", (select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura="snapshot"), 4, 4, (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "gray"), (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 0.3, 0.01,(select id_chave_diretorio_imagem from diretorios_imagens where nome_diretorio_imagem like "imagens_na_base3"),
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")

 );

insert into cameras (nome_camera, ip, basefilename, localizacao, id_resolucao, id_resolucao_de_tratamento, marca, admin, senha, codigo_stream, codigo_jpeg, codigo_rtsp, id_tipo_captura, winstride_x, winstride_y, id_tratamento_imagem, id_armazenagem_imagem, fracao_area_max, fracao_area_min, id_diretorio_imagem, id_tipo_sequencia,
	id_resolucao_de_armazenagem) values ("deusdete2", "192.168.0.23", "DCS_932L_B0C55411B0A1", "PQP", (select id_chave_resolucao from resolucoes where nome_resolucao="640x480"), (select id_chave_resolucao from resolucoes where nome_resolucao="nao_aplicar"), "Dlink", "admin", "", "/VIDEO.CGI", "/image/jpeg.cgi", "//live/ch00_1", (select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura="snapshot"), 4, 4, (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "gray"), (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 0.3, 0.01,(select id_chave_diretorio_imagem from diretorios_imagens where nome_diretorio_imagem like "imagens_na_base3"),
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")

 );

insert into cameras (nome_camera, ip, basefilename, localizacao, id_resolucao, id_resolucao_de_tratamento, marca, admin, senha, codigo_stream, codigo_jpeg, codigo_rtsp, id_tipo_captura, winstride_x, winstride_y, id_tratamento_imagem, id_armazenagem_imagem, fracao_area_max, fracao_area_min, id_tipo_sequencia,
	id_resolucao_de_armazenagem) values ("dummy", "dummy_ip", "dummy_nome", "dummy_local", (select id_chave_resolucao from resolucoes where nome_resolucao="dummy"), (select id_chave_resolucao from resolucoes where nome_resolucao="dummy"), "dummy_cam", "usuario_dummy", "bartoloide", "dummy", "dummy", "dummy", (select id_chave_tipo_captura from tipos_capturas where nome_tipo_captura like "dummy"),0, 0, (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "gray"), (select id_chave_tratamento_imagem from tratamentos_imagem where nome_tratamento_imagem like "nao_tem"), 0.3, 0.01,
	(select id_chave_tipo_sequencia from tipos_sequencias where nome_tipo_sequencia like "Sequencia de JPEGs"),
	(select id_chave_resolucao_de_armazenagem from resolucoes_de_armazenagem where nome_resolucao_de_armazenagem like "resolucao_de_tratamento")

);

insert into retangulos_viciados (nome_retangulo_viciado, ocorrencias, id_camera, media_peso, desvio_peso, xAmin, xAmax, yAmin, yAmax, xBmin, xBmax, yBmin, yBmax, dxA, dyA, dxB, dyB) values ("sem_analise", 0, (select id_chave_camera from cameras where nome_camera like "dummy"), 0, 0, 0, 0 , 0, 0 , 0 , 0 , 0 , 0, 0,0,0,0 ); 
insert into retangulos_viciados (nome_retangulo_viciado, ocorrencias, id_camera, media_peso, desvio_peso, xAmin, xAmax, yAmin, yAmax, xBmin, xBmax, yBmin, yBmax, dxA, dyA, dxB, dyB) values ("alerta_valido", 0, (select id_chave_camera from cameras where nome_camera like "dummy"), 0, 0, 0, 0 , 0, 0 , 0 , 0 , 0 , 0, -1,-1,-1,-1 ); 
insert into registrados (nome_registrado, senha, telefone) values ("Victor Mammana","12345","19 9 8143 1010");
insert into atribuicoes (nome_atribuicao) values ("administrador");
insert into atribuicoes_registrados (id_registrado,id_atribuicao) values ((select id_chave_registrado from registrados where nome_registrado="Victor Mammana"),(select id_chave_atribuicao from atribuicoes where nome_atribuicao="administrador"));

insert into tipos_alertas (nome_tipo_alerta, alias) values ("Humano_movimento", "Humano_mov");
insert into tipos_alertas (nome_tipo_alerta, alias) values ("Humano_HOG", "HumanoHog");
insert into tipos_alertas (nome_tipo_alerta, alias) values ("Carro", "Carro");
insert into tipos_alertas (nome_tipo_alerta, alias) values ("Pet", "Animal de Estimacao");


insert into tipos_alertas (nome_tipo_alerta, alias) values ("person" ,"pessoa" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bicycle" ,"bicicleta" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("car" ,"carro" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("motorcycle" ,"motocicleta" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("airplane" ,"aviao" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bus" ,"onibus" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("train" ,"Comboio" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("truck" ,"caminhao" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("boat" ,"barco" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("traffic light" ,"semaforo" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("fire hydrant" ,"hidrante" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("stop sign" ,"sinal de pare" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("parking meter" ,"parquimetro" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bench" ,"banco de sentar" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bird" ,"passaro" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("cat" ,"gato" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("dog" ,"cao" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("horse" ,"cavalo" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("sheep" ,"ovelha" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("cow" ,"vaca" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("elephant" ,"elefante" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bear" ,"urso" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("zebra" ,"zebra" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("giraffe" ,"girafa" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("backpack" ,"mochila" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("umbrella" ,"guarda-chuva" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("handbag" ,"Bolsa" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("tie" ,"laco" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("suitcase" ,"mala" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("frisbee" ,"frisbee" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("skis" ,"esquis" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("snowboard" ,"snowboard" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("sports ball" ,"bola de esportes" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("kite" ,"pipa" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("baseball bat" ,"taco de beisebol" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("baseball glove" ,"luva de baseball" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("skateboard" ,"skate" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("surfboard" ,"prancha de surfe" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("tennis racket" ,"raquete de tênis" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bottle" ,"garrafa" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("wine glass" ,"copo de vinho" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("cup" ,"xicara" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("fork" ,"garfo" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("knife" ,"faca" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("spoon" ,"colher" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bowl" ,"tigela" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("banana" ,"banana" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("apple" ,"maca" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("sandwich" ,"sanduiche" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("orange" ,"laranja" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("broccoli" ,"brocolis" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("carrot" ,"cenoura" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("hot dog" ,"cachorroquente" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("pizza" ,"pizza" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("donut" ,"rosquinha" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("cake" ,"bolo" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("chair" ,"cadeira" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("couch" ,"sofa" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("potted plant" ,"vaso de planta" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("bed" ,"cama" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("dining table" ,"mesa de jantar" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("toilet" ,"banheiro" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("tv" ,"televisao" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("laptop" ,"computador portatil" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("mouse" ,"mouse" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("remote" ,"controlo remoto" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("keyboard" ,"teclado" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("cell phone" ,"celular" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("microwave" ,"microondas" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("oven" ,"forno" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("toaster" ,"torradeira" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("sink" ,"pia" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("refrigerator" ,"frigorifico" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("book" ,"livro" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("clock" ,"relogio" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("vase" ,"vaso" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("scissors" ,"tesoura" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("teddy bear" ,"urso teddy" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("hair drier" ,"secador de cabelo" );
insert into tipos_alertas (nome_tipo_alerta, alias) values ("toothbrush" ,"escova de dente" );


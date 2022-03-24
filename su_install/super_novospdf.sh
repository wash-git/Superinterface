#!/bin/bash
export TERM=xterm
su_origem=$1			# indicador se origem da chamada deste script foi via cron
#  evitar que uma segunda instância do script não seja executada até que a primeira esteja completa
#  utilizando o utilitário "flock" para gerenciar "lock files"
#su_scriptname=$USER$(basename $0)	# vamos usar o prórprio nome do script para servir como "file descriptor"
#su_scriptname="asdfghij"
#su_scriptname="$USER$(basename $0)"
exec 312>../su_admin/$(basename $0).lock || exit 1   # usar o prórprio nome do script para servir como "file descriptor"
flock -n 312 || exit 1	# o script será desbloqueado quando ele for encerrado.
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#                                                       CONFIGURAÇÕES                                                       |
#                                                                                                                           |
# --------------------------------------------------------------------------------------------------------------------------+
CPCONFIG="super_config.cnf"				# arquivo de configuração
CPROOT_UID=0							# root ID
declare -r CPPINSTALL="su_install"		# nome da pasta de instalação
# 										outras variáveis
declare -r su_mimeTxt="text/plain"
declare -r su_mimeRtf="text/rtf"
declare -r su_mimeDoc="application/msword"
declare -r su_mimeDocx="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
declare -r su_mimeOdt="application/vnd.oasis.opendocument.text"
declare -r su_mimePdf="application/pdf"

# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#														MENSAGENS DO SCRIPT													|
#                                                                                                                           |
# --------------------------------------------------------------------------------------------------------------------------+
#
#	Mensagens de erro
MErr01="Não é permitido executar este script como usuário root"
MErr02="Não foi possível substituir caracteres de controle dos nomes dos arquivos. Verifique se comando 'detox' está instalado"
MErr03="Erro! Arquivo com nome das cidades não foi encontrado"
MErr04="Erro! Arquivo com comandos SQL para popular tabela de 'su_cidades' não foi encontrado"
MErr05="Erro! Não foi possível preparar pasta temporária de imagens de arquivos PDF: pasta temporária não pode ser limpa"
MErr06="Erro! Não foi possível preparar pasta temporária de imagens de arquivos PDF: pasta temporária não pode ser criada"
MErr07="Erro! Não foi possível se conectar com o banco de dados"
MErr08="Erro! Não foi possível mover este arquivo da pasta de uploads para início de seu tratamento: "
MErr09="Erro! Pasta para upload de arquivos não criada" 
MErr10="Interrompendo a execução do script"
MErr11="Erro! Pasta de imagens de arquivos PDF não encontrada"
MErr12="Não foi possível deixar os nomes dos arquivos em minúsculo.  Transferindo arquivo(s) do lote para quarentena"
MErr13="Erro! Problemas na geração do script para criação de arquivos TXT. Transferindo arquivo(s) do lote para quarentena"
MErr14="Erro! Não foi possível gerar arquivo com as ocorrências dos nomes das cidades. Transferindo arquivo(s) do lote para quarentena"
MErr15="Erro! Não foi possível gerar arquivo de instruções SQL para popular tabela su_docs_cidades. Transferindo arquivo(s) do lote para quarentena"
MErr16="Erro! Problema na execução do script de geração de arquivos TXT. Transferindo arquivo(s) do lote para quarentena"
MErr17="Erro! Não foi possível inserir informações nas tabelas: su_documents, su_docs_signatarios, su_docs_instituicoes. Transferindo arquivos do lote para quarentena. É altamente recomendável verificar a consistência da base de dados devido esta interrupção de inserção de informações na base"
MErr18="Erro! Não foi possível criar pasta de quarentena para arquivos PDF"
MErr19="Erro! Pasta de logs não existia e também não foi possível criá-la"
MErr20="Erro! Arquivo de configuração desta aplicação não foi encontrado"
MErr21="Erro! Problemas na cópia de arquivos PDF da pasta de upload para a pasta emporária de tratamento destes arquivos"
MErr22="Erro! Problemas na criação do arquivo de comandos SQL para popular tabelas. Transferindo arquivo(s) do lote para quarentena"
MErr23="Erro! Arquivo de logs não existe e não foi possível recriá-lo"
MErr24="Erro! Não foi possível inserir informações na tabela su_docs_cidades. Transferindo arquivos do lote para a quarentena. É altamente recomendável verificar a consistência da base de dados devido esta interrupção de inserção de informações na base"
MErr25="Erro! É necessário instalar o aplicativo 'detox' (apt-get install detox)"
MErr26="Erro! Não foi possível compactar arquivo de logs"
Merr27="Erro! Script periódico de incorporação de arquivos PDF ao acervo da Superinterface só pode ser chamado a partir da pasta 'su_install'"
MErr28="Erro! Arquivo que guarda a numeração dos nomes dos arquivos PDF não foi encontrado. Transferindo arquivo(s) do lote para quarentena"
MErr29="Erro! Índice encontrado para renomear nome dos arquivos não é um valor numérico. Transferindo arquivo(s) do lote para quarentena"
MErr30="Erro! É necessário instalar o aplicativo 'unoconv' conforme manual de instalação"
MErr31="Erro! Pasta para upload de arquivos DOC, DOCX não criada" 
MErr32="Erro! Não foi possível gerar arquivo PDF a partir deste arquivo DOC: "
MErr33="Erro! Não foi possível gerar arquivo PDF a partir deste arquivo DOCX: "
MErr34="Erro! Não foi possível criar pasta para arquivos originais não PDF"
MErr35="Erro! Não foi possível gerar arquivo PDF a partir deste arquivo RTF: "
MErr36="Erro! Não foi possível gerar arquivo PDF a partir deste arquivo ODT: "
MErr37="Erro! Não foi possível gerar arquivo PDF. Parece haver algum problema com o mime-type deste arquivo DOCX: "
Merr38="Erro! Não foi possível gerar arquivo PDF. Parece haver algum problema com o mime-type deste arquivo DOC: "
MErr39="Erro! Não foi possível gerar arquivo PDF. Parece haver algum problema com o mime-type deste arquivo ODT: "
MErr40="Erro! Não foi possível gerar arquivo PDF. Parece haver algum problema com o mime-type deste arquivo RTF: "
MErr41="Erro! Parece haver algum problema com o mime-type deste arquivo PDF: "
Merr42="Erro! Não foi possível gerar arquivo PDF. Parece haver algum problema com o mime-type deste arquivo TXT: "
MErr43="Erro! Não foi possível gerar arquivo PDF a partir deste arquivo TXT: "
MErr44="Erro! Não foi possível renomear este arquivo e numerá-lo: "
MErr45="Erro! Não foi possível atualizar o arquivo que guarda a numeração dos nomes de arquivos. Transferindo arquivo(s) do lote para quarentena"
MErr46="Erro! Não foi possível gerar JPG da primeira página do PDF.  Transferindo arquivo(s) do lote para quarentena"
MErr47="Erro! Problemas na criação do arquivo TXT sem acento. Transferindo arquivo(s) do lote para quarentena"
MErr48="Erro! Problemas na preparação de arquivo TXT sem caracteres de controle. Transferindo arquivo(s) do lote para quarentena"
#
#	mensagens de informação
MInfo01="Bem vindo ao script de tratamento de novos arquivos PDF em: "
MInfo02="Quantidade de arquivos na pasta de quarentena= "
MInfo03="Sucesso. Criada pasta temporária para tratamento de arquivos PDF" 
MInfo04="Sucesso. Geração de arquivo com instruções SQL para popular diversas tabelas do acervo foi realizada corretamente"
MInfo05="Sucesso. Informações inseridas corretamente na tabela su_docs_cidades"
MInfo06="Aviso: pasta de logs não estava criada.  Criação foi realizada com sucesso"
MInfo07="Sucesso. Conexão com o banco de dados foi realizada corretamente"
MInfo08="Iniciando o tratamento de um lote de arquivos PDF"
MInfo09="Script terminado as"
MInfo10="Existe(m) arquivo(s) novos para ser(em) tratado(s)"
MInfo11="Renomeando os arquivos PDF e fazendo sua numeração"
MInfo12="Sucesso. Numerado os nomes dos arquivos PDF"
#MInfo13=""
MInfo14="Sucesso. Geração de arquivos TXT realizada corretamente"
MInfo15="Gerando arquivo com ocorrências de nomes de cidades. Pode demorar um pouco. Espere...."
MInfo16="Sucesso. Geração de arquivo de ocorrências de cidades foi realizada corretamente"
MInfo17="Sucesso. Geração de arquivo com instruções SQL para popular tabela su_docs_cidades foi realizada corretamente"
#MInfo18=""
MInfo19="Sucesso. Geração de arquivos JPG realizada corretamente"
MInfo20="Nenhum arquivo ODT para ser tratado neste momento"
MInfo21="Iniciando o tratamento de um lote de arquivos ODT"
MInfo22="Alcançado o número máximo de arquivos passíveis de tratamento nesta ativação do script"
MInfo23="Nenhum arquivo TXT para ser tratado neste momento"
MInfo24="Sistema configurado para renomear e numerar os arquivos. Atenção: isso fará parar a verificação de arquivos duplicados no acervo"
MInfo25="Sucesso. Informações inseridas corretamente nas diversas tabelas do acervo"
MInfo26="Quantidade de registros na tabela 'su_documents'= "
MInfo27="Quantidade de registros na tabela 'su_docs signatários'= "
MInfo28="Quantidade de registros na tabela 'su_docs instituições'= "
MInfo29="Quantidade de registros na tabela 'su_cidades'= "
MInfo30="Quantidade de registros na tabela 'su_docs_cidades'= "
MInfo31="Quantidade de tabelas existentes na base= "
MInfo32="Sucesso. Fim do tratamento dos novos arquivos PDFs!"
MInfo33="Arquivo já existia na pasta de quarentena. Suspendendo o tratamento deste arquivo: "
MInfo34="Movendo este arquivo para pasta de quarentena pois ele já existe no repositório: "
MInfo35="Detectado arquivo novo, a ser incluído no repositório:  "
MInfo36="Aviso: estranho! Pasta de quarentena não encontrada no ambiente.  Fizemos sua recriação com sucesso"
MInfo37="Aviso: estranho! A pasta de logs não existia no ambiente. Fizemos a sua recriação"
MInfo38="Término do tratamento para este lote de arquivos"
MInfo39="Aviso: estranho! O arquivo de logs não existia.  Fizamos sua recriação"
MInfo40="Alerta: notamos a falta do aplicativo cowsay. Mas ele não é obrigatório. Dica: assim que possível, instalar o cowsay  (apt-get install cowsay)"
MInfo41="Alerta: notamos a falta do aplicativo figlet. Mas ele não é obrigatório. Dica: assim que possível, instalar o figlet  (apt-get install figlet)"
MInfo42="Data:"
MInfo43="Iniciando o tratamento dos novos arquivos"
MInfo44=".....Testando acesso ao arquivo de logs"
MInfo45="Quantidade de arquivos restantes na pasta de uploads= "
MInfo46="Sucesso. Arquivo de logs compactado em: "
MInfo47="Movendo arquivo para pasta de quarentena pois ele apresentou problemas na sua estrutura:  "
MInfo48="Nenhum arquivo PDF para ser tratado neste momento"
MInfo49="Iniciando o tratamento de um lote de arquivos DOCX"
MInfo50="Arquivo PDF gerado com sucesso a partir do documento:  "
MInfo51="Nenhum arquivo DOCX para ser tratado neste momento"
MInfo52="Aviso: estranho! Pasta de arquivos originais não PDF não encontrada no ambiente.  Fizemos sua recriação com sucesso"
MInfo53="Quantidade total de arquivos esperando tratamento= "
MInfo54="Nenhum arquivo DOC para ser tratado neste momento"
MInfo55="Iniciando o tratamento de um lote de arquivos DOC"
MInfo56="Iniciar geração de arquivos complementares"
MInfo57="Nenhum arquivo RTF para ser tratado neste momento"
MInfo58="Iniciando o tratamento de um lote de arquivos RTF"
MInfo59="Iniciando o tratamento de um lote de arquivos TXT"
MInfo60="Cancelando o tratamento deste lote de arquivos"
#				  códigos das mensagens
FInfor=0        # saída normal: new line ao final, sem tratamento de cor
FInfo1=1        # saída normal: new line ao final, sem tratamento de cor e sem ..... (sem pontinhos ilustrativos)
FInfo2=2        # saída sem new line ao final, sem tratamento de cor
FSucss=3        # saída para indicação de sucesso: new line ao final da mensagem. na cor azul. No final, muda para cor branca
FSucs2=4        # saída para indicação de sucesso: new line antes e depois da mensagem, cor azul. No final, muda para cor branca
FInsuc=5        # saída para indicação de erro, na cor vermelha
FInsu1=6        # saída para indicação de erro, na cor vermelha (apenas no screen, não enviado para arquivo de log)
FInsu2=7		# saída para indicação de erro, na cor vermelha, sem new line ao final e sem ....
FInsu3=8
FInsu4=9		# saída para indicação de erro, na cor vermelha, com new line ao final e com ....
FCowsa=10        # saída para aplicativo cowsay
FFighl=11        # saída para aplicativo fighlet
FLinha=12		# saída de uma linha separadora para novo log
#
MCor01="\e[97m"         # cor default (branca), quando for imprimir mensagens na tela
MCor02="\e[33m"         # cor amarela, quando for imprimir mensagens na tela
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#								FUNÇÃO AUXILIAR DE CONTROLE DE MENSAGENS AO USUÁRIO											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fMens () {								# função para enviar mensagem, das seguintes formas:
	case $1 in
			$FInfor)							# com line feed ao final, cor default
				echo -e ".....$2" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FInfo1)
				echo -e "$2" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FInfo2)							# sem line feed, cor default
				echo -n ".....$2" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FSucs3)							# sem line feed, cor azul
				echo -ne "\e[34m.....$2\e[97m" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
            	;;
			$FSucss)							# com line feed ao final. cor azul
        		echo -e "\e[34m.....$2\e[97m" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
            	;;
			$FSucs2)							# com lines feed antes e depois, cor azul
				echo -e "\n\e[34m.....$2\e[97m" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
            	;;
			$FInsuc)							# com line feed depois, aviso de interrupção do script, cor vermelha
				echo -e  "\e[31m.....$2" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
            	echo -e ".....$MErr10\e[97m" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"	# mens. interrompendo script
            	;;
			$FInsu1)
				echo -e  "\n\e[31m.....$2"
				echo -e ".....$MErr10\e[97m"	# mens. interrompendo script
				;;
			$FInsu2)							# sem line feed ao final, cor vermelha
				echo -ne "\e[31m.....$2" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FInsu3)							# com line feed ao final, cor vermelha, ao final volta cor default
				echo -e "\e[31m$2\e[97m"  | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FInsu4)							# cor vermelha
				echo -e  "\e[31m.....$2\e[97m" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FCowsa)
				shuf -n 1 $2 | cowsay -p -W 50 | tee -aa "$CPLOG_DIR"/"$CPLOGSFILE"
#				shuf -n 1 $2 | cowsay -p -W 50 | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FLinha)
				printf '=%.0s' {1..100}
				printf '=%.0s' {1..100} >> $CPLOG_DIR/$CPLOGSFILE
				echo -e "\n\n" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			$FFighl)
				figlet -f standard -k -t -c -p -w 120  "
--------------
Superinterface
--------------" | tee -aa "$CPLOG_DIR"/"$CPLOGSFILE"
				;;
			*)
        		echo "\e[31m.....OOOooops!\e[97m" | tee -aa "$CPLOG_DIR"/"$CPLOGSFILE"
            	echo $1 | tee -aa "$CPLOG_DIR"/"$CPLOGSFILE"
            	exit
            	;;
	esac
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#											FUNÇÃO PARA VERIFICAÇÃO DO AMBIENTE												|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fInit () {
: '
	Consistências iniciais (principais):
	C1: se o usuário é root
	C2: se a pasta corrente é a de instalação
	C3: se o arquivo de configuração está disponível
	C4: se pasta e arquivo de logs estão preparados
	C5: verificar a existência de algum arquivo para tratamento na pasta de uploads
	--------	--------	--------  
	C6:  verificar se aplicativo unoconv está instalado
	C7:  verificar se aplicativo detox  está instalado
	C8:  verificar se aplicativo figlet está instalado
	C9:  verificar se aplicativo cowsay está instalado
	C10: verificar existência arquivo contendo nomes das cidades
	C11: verificar existência de arquivo com comandos SQL para inserção dados na tabela su_cidades
	C12: verificar existência da pasta de repositório de arquivos PDF do acervo arquivístico
	C13: verificar existência da pasta de arquivos não PDF já preparados
	C14: verificar existência de pasta de quarentena de arquivos do acervo arquivístico
	C15: verificar a conexão com o banco de dados
 	C16: verificar se deve renomear os arquivos (numerando-os)
	--------	--------	--------  
'
	#										C1: verificar se é usuário root
	if [ "$EUID" -eq $CPROOT_UID ];  then 
    	fMens "$FInsu1" "$MErr01"
        exit
	fi
    #										C2: verificar se pasta corrente é a de instalação
        if [ "${PWD##*/}" != "$CPPINSTALL" ]; then
                fMens "$FInsu1" "$MErr27"
                exit
        fi
	#										C3: verificar se arquivo de configuração está disponível
	if [ ! -f $CPCONFIG ]; then
		fMens "$FInsu1" "$MErr20"
		exit
	fi
	source	$CPCONFIG						# inserir arquivo de configuração
	chmod	$CPPERMCONFIG	$CPCONFIG		# estabelecer permissão para arquivo de configuração 	
	chmod	$CPPERMSHELL $0					# estabelecer permissão para este arquivo
	#										verificar se arquivo de logs está disponível
	if [ ! -d $CPLOG_DIR ]; then
		mkdir	$CPLOG_DIR
        if [ $? -ne 0 ]; then
                fMens "$FInsuc" "$MErr19"
                exit
        fi	
		fMens	"$FInfor" "$MInfo37"
	fi
	chmod	$CPPERMPADRAO $CPLOG_DIR		# estabelecer permissão para pasta de logs
	#										verificar existência de arquivo de logs
	if [ ! -f "$CPLOG_DIR/$CPLOGSFILE" ]; then
		echo  -e "\n$MInfo44" >> "$CPLOG_DIR"/"$CPLOGSFILE"	# C4: testando escrita no arquivo de logs 
		if [ $? -ne 0 ]; then
			fMens	"$FInsuc" "$MErr23"
			exit
		fi
		fMens	"$FInfor" "$MInfo39"
	fi
	chmod	$CPPERMARQUI $CPLOG_DIR"/"$CPLOGSFILE			# estabelecer permissão para arquivo de logs
	#	verifica existência de pasta de uploads de arquivos
	if [ ! -d $CPUPLOADS ]; then
		fMens "$FInsuc" "$MErr09"
		exit
	fi
	chmod $CPPERMPADRAO $CPUPLOADS			# estabelecer permissão para a pasta de uploads

	#										C5: verificar existência de arquivos para serem tratados
	if ls $CPUPLOADS/*.*  1> /dev/null 2>&1; then
		:
	else
		exit 0								# nada a ser tratado: sem arquivos novos
	fi
	#										linha separadora do log anterior
	fMens	"$FLinha"	""
	fMens	"$FInfor" "$MInfo10"			# mensagem que existem novos arquivos para serem tratados
	fMens	"$FInfo2" "$MInfo53"
	fMens	"$FInfo1" "$(ls $CPUPLOADS/* | wc -l)"
	#										C6: verificar se aplicativo unoconv está instalado
	#										(necessário para conversão arquivos -> .pdf)
	if [ -n "$(dpkg --get-selections | grep unoconv | sed '/deinstall/d')" ]; then
	:
	else
		fMens "$FInsuc" "$MErr30"
		exit
	fi
	#										C7: verificar se aplicativo detox está instalado
	if [ -n "$(dpkg --get-selections | grep detox | sed '/deinstall/d')" ]; then
	:
	else
		fMens "$FInsuc" "$MErr25"
		exit
	fi
	#										C8: verificar se aplicativo figlet está instalado
	if [ -n "$(dpkg --get-selections | grep figlet | sed '/deinstall/d')" ]; then
		fMens "$FInfo1" "$MCor02"			# saída na cor amarela 
		fMens "$FFighl"
	else
		fMens "$FInfor" "$MInfo41"      
	fi
	fMens "$FInfo1" "$MCor02"				# saída na cor amarela 
	fMens "$FInfo2" "$MInfo01"				# enviar mensagem de boas vindas
	fMens "$FInfo1" "$0"
	fMens "$FInfor" "$MInfo42:  $(date '+%d-%m-%Y as  %H:%M:%S') --- $MInfo43"
	fMens "$FInfo1" "$MCor01"
	#										C9: verificar se aplicativo cowsay está instalado
	if [ -n  "$(dpkg --get-selections | grep cowsay | sed '/deinstall/d')" ]; then
		fMens "$FCowsa"  "$CPNOMECOWSAY1"
	else
		fMens "$FInfor" "$MInfo40"
	fi
	chmod $CPPERMFIXOS      super_cowsay1.txt	# estabelecer permissão para o arquivo de mensagens cowsay	
	chmod $CPPERMFIXOS $CPPADMIN/$CPNOMECIDADES
	#										C10: verificar existência arquivo contendo nomes das cidades (em letras maiúsculas)
    if [ ! -f $CPPADMIN/$CPNOMECIDADES ]; then
		fMens "$FInsuc" "$MErr03"
        exit
	fi
    chmod $CPPERMFIXOS $CPPADMIN/$CPNOMECIDADES
    #										C11: verificar existência arquivo SQL para inserção dados na tabela 'su_cidades'
    if [ ! -f $CPINSERECIDADES ]; then
		fMens "$FInsuc" "$MErr04"
		exit
    fi
	chmod $CPPERMFIXOS $CPINSERECIDADES
	#										C12: verificar existência da pasta para arquivos PDF do acervo arquivístico
	if [ ! -d $CPIMAGEM ]; then
		fMens "$FInsuc" "$MErr11"
		exit
	fi
	#									preparar pasta de trabalho (arquivos temporários)
	rm -rf $CPTEMP 2>/dev/null
    if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr05"
        exit
	fi
    mkdir $CPTEMP
    if [ $? -ne 0 ]; then
    	fMens "$FInsuc" "$MErr06"
        exit
	else
    	fMens "$FSucss" "$MInfo03"
	fi
    chmod $CPPERMPADRAO $CPTEMP			# estabelecer permissão para pasta de trabalho

	#									C13: verificar existência de pasta de arquivos originais não PDF já preparados
	if [ ! -d $CPPRIMITIVO ]; then
		mkdir $CPPRIMITIVO
	    if [ $? -ne 0 ]; then
			fMens "$FInsuc" "$MErr34"
        	exit
		else
			fMens	"$FSucss"	"$MInfo52"
		fi
	fi
	chmod $CPPERMPADRAO $CPPRIMITIVO	# estabelecer permissão para pasta arquivos originais não PDF (já preparados)


	#									C14: verificar existência de pasta de quarentena de arquivos do acervo arquivístico
	if [ ! -d $CPQUARENTINE ]; then
		mkdir $CPQUARENTINE
	    if [ $? -ne 0 ]; then
			fMens "$FInsuc" "$MErr18"
        	exit
		else
			fMens	"$FSucss"	"$MInfo36"
		fi
	fi
	chmod $CPPERMPADRAO $CPQUARENTINE               # estabelecer permissão para pasta de quarentena
	#												C15: testar conexão com o banco de dados
    mysql -u $CPBASEUSER -b $CPBASE -p$CPBASEPASSW -e "quit" 2>/dev/null
	if [ $? -ne 0 ]; then
    	fMens "$FInsuc" "$MErr07"
		exit
    else
			fMens "$FSucss" "$MInfo07"
	fi
	#												# C16: verificar se deve renomear os arquivos (numerando-os)
	if [ $CPNUMERARPDF -ne 0 ]; then
		fMens	"$FInfor"	"$MInfo24"				# mensagem informativa que irá renomear os arquivos
	fi
	return
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							GERA INFORMAÇÕES DOS ARQUIVOS PARA POSTERIOR INSERÇÃO NA BASE DE DADOS							|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fGarq () {
	#									variaveis locais
	local -i su_quant
	local -i su_qpdf
	local -i su_cont
	local	su_arq
	local	su_fileClean
	local	su_nomebase
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPTEMP -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", @()&'!$" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_quant=$(ls -l $CPTEMP/*.[pP][dD][fF] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	su_quantTratados=$su_quantTratados+$su_quant		# atualiza quantidade arquivos já tratados nesta ativação do script
	#                               					verificar se há corrupção dos arquivos PDF
	for i in "$CPTEMP"/*.[pP][dD][fF]; do
		pdfinfo "$i" &>/dev/null
		if [ ! $? -eq 0 ]; then
			mv -f $i "$CPQUARENTINE"/.
			fMens   "$FInfor"       "$MInfo47 $(basename $i)"
		fi
	done
	#                               						verificar se ainda há arquivos PDF a serem tratados
	su_qpdf=$(ls -la $CPTEMP/*.[pP][dD][fF] 2>/dev/null | grep -e "^-" | wc -l) 2>/dev/null
	if [ $su_qpdf -eq 0 ]; then
		fMens	"$FInfor"	"$MInfo60"
		return
	fi
	#														modificar nomes dos arquivos PDF para minúsculo
	for i in "$CPTEMP"/*.[pP][dD][fF]; do
		detox -s lower-only $i
		if [ $? -ne 0 ]; then
			mv -f $i "$CPQUARENTINE"/. 2>/dev/null			# enviar o arquivo PDF para quarentena
			fMens "$FInsu2" "$MErr44"
			fMens "$FInsu3" "$(basename $i)"
		fi
	done
	#                               						verificar se ainda há arquivos PDF a serem tratados
	su_qpdf=$(ls -la $CPTEMP/*.[pP][dD][fF] 2>/dev/null | grep -e "^-" | wc -l) 2>/dev/null
	if [ $su_qpdf -eq 0 ]; then
		fMens	"$FInfor"	"$MInfo60"
		return
	fi
	#														verificar se deve renomear os arquivos (numerando-os)
	if [ $CPNUMERARPDF -ne 0 ]; then
	 	fMens   "$FInfor"	"$MInfo11"						# mensagem de renomear arquivos 
		if [ ! -f $CPPADMIN/$CPINDICEPDF ]; then			# testar existência de arquivo com próximo número para numerar
			mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
			fMens "$FInsu4" "$MErr28"						# arquivo com informação de numeração não encontrado 
			fMens "$FInfor" "$MInfo38"
			return
		fi
		su_cont=$(cat $CPPADMIN/$CPINDICEPDF)				# faz leitura do próximo número a ser renomeado o arquivo
		if (echo $su_cont | egrep '[^0-9]' &> /dev/null) then
			mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/. 2>/dev/mull	# enviar os arquivos PDF para quarentena
			fMens	"$FInsuc" "$MErr29"									# valor encontrado não é numérico
			fMens "$FInfor" "$MInfo38"
			return
		fi
		for i in $CPTEMP/*.[pP][dD][fF]
		do 
			su_arq=$(basename $i)								# nome do arquivo com extensão, mas sem caminho
			su_arq=${su_arq%.*}									# nome do arquivo sem extensão e sem caminho
			mv -i "$i" "$CPTEMP/super${su_cont}_${su_arq:0:$CPMAX}.pdf"
			if [ $? -ne 0 ]
			then
				mv -f $CPTEMP/*.[pP][dD][fF] "$CPQUARENTINE"/.	# enviar os arquivos PDF para quarentena
				fMens "$FInsu4" "$MErr12"
				fMens "$FInfor" "$MInfo38"
				return
			else
				let su_cont=$su_cont+1
				echo $su_cont > $CPPADMIN/$CPINDICEPDF			# atualiza valor do contador no arquivo
				if [ $? -ne 0 ]
				then
					mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
					fMens "$FInsu4" "$MErr45"
					fMens "$FInfor" "$MInfo38"
					return
				fi
			fi
		done
		fMens "$FSucss" "$MInfo12"	
	fi
	#													verificar se os arquivos já estão na pasta de quarentena
	for i in $CPTEMP/*.[pP][dD][fF]; do
		su_nomebase=$(basename $i)						# nome do arquivo com extensão, e sem caminho (path)
		if [ -f $CPQUARENTINE/$su_nomebase ]; then
			#											arquivo já está colocado em quarentena
			fMens	"$FInfor"	"$MInfo33 $su_nomebase"
			rm -f $i									# suspender o tratamento do arquivo.
		fi
	done
	#													verificar se ainda existem arquivos PDF a serem tratados
	if [ ! "$(ls -A $CPTEMP)" ]; then
			fMens	"$FInfor"	"$MInfo38"
			return
	fi
	#													verificar se os arquivos já estão no acervo (na base dados)
	for i in $CPTEMP/*.[pP][dD][fF]; do
		su_nomebase=$(basename $i)						# nome do arquivo com extensão, e sem caminho (path)
		# su_nomebaseSem="${su_nomebase%.*}"			# nome do arquivo sem extensão
		if [ -f $CPIMAGEM/$su_nomebase ]; then
			#											arquivo já existe no repositório
			fMens	"$FInfo2"	"$MInfo34"
			fMens	"$FInfo1"	"$su_nomebase"
			mv -f $i $CPQUARENTINE/.
		else
			fMens	"$FInfo2"	"$MInfo35"				# arquivo para ser tratado.  Não existe no repositório
			fMens	"$FInfo1"	"$su_nomebase"
		fi
	done
	#													verificar se sobrou algum arquivo pdf a ser tratado
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
    	fMens	"$FInfor" "$MInfo56"
	else
    	fMens	"$FInfor" "$MInfo38"
		return
	fi
	#													gerar arquivos TXT a partir de arquivos PDF
	ls $CPTEMP/*.[pP][dD][fF] | awk '{printf "pdftotext  -layout "$1; gsub(/\.pdf/,".txt",$1); print " "$1}' > $CPLOG_DIR/super_temp_gera_txt.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
		rm -f $CPLOG_DIR/super_temp_gera_txt.bash
		fMens "$FInsu4" "$MErr13"
		fMens "$FInfor" "$MInfo38"
		return
	fi
	chmod 740 $CPLOG_DIR/super_temp_gera_txt.bash 2>/dev/null
	bash $CPLOG_DIR/super_temp_gera_txt.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
		rm -f $CPLOG_DIR/super_temp_gera_txt.bash
		fMens "$FInsu4" "$MErr16"
		fMens "$FInfor" "$MInfo38"
		return
	fi
	rm -f $CPLOG_DIR/super_temp_gera_txt.bash
	#							gerar nomes dos arquivos TXT: sem acentuação, letras maiúsculas e sem caracteres controle
	for i in "$CPTEMP"/*.txt
	do
		sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' $i > $i"."$CPACENTO
		if [ $? -ne 0 ]; then
			mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
			rm -f $CPTEMP/*.*
			fMens "$FInsu4" "$MErr47"
			fMens "$FInfor" "$MInfo38"
			return
		fi
	done
	#
	for i in  "$CPTEMP"/*.$CPACENTO
	do
		tr  [:cntrl:] ' ' < $i > $i".contrl4"
		tr -d '\176-\377' < $i".contrl4" > $i"."$CPCONTRL
	done
	#
	for i in "$CPTEMP"/*.$CPCONTRL
	do
		tr [:lower:] [:upper:] < $i > $i"."$CPMAIUSCULA
	done
	rm -f "$CPTEMP"/*.$CPCONTRL "$CPTEMP"/*.contrl4 "$CPTEMP"/*.$CPACENTO 2> /dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo14"
	else
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		fMens "$FInsu4" "$MErr48"
		fMens "$FInfor" "$MInfo38"
		return
	fi
	#													gerar arquivos JPG a partir de arquivos PDF
	ls $CPTEMP/*.[pP][dD][fF] | awk '{printf "convert "$1"[0]"; gsub(/\.pdf/,"_pagina1.jpg",$1); print " "$1}' > $CPLOG_DIR/super_temp_gera_jpg.bash 2>/dev/null
	chmod 740 $CPLOG_DIR/super_temp_gera_jpg.bash 2>/dev/null
	bash $CPLOG_DIR/super_temp_gera_jpg.bash 2>/dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo19"
		rm -f $CPLOG_DIR/super_temp_gera_jpg.bash
	else
		fMens "$FInsu4" "$MErr46"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		rm -f $CPLOG_DIR/super_temp_gera_jpg.bash
		return
	fi
	#													gerar arquivo com ocorrências das cidades nos arquivos TXT
	fMens "$FInfor" "$MInfo15"
	cat $CPPADMIN/$CPNOMECIDADES | sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' | awk 'BEGIN{FS=","}{print "grep -Howi \""$1"\" '$CPTEMP'/*.txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA' | awk '\''BEGIN{FS=\":\"}{print $2\", \"$1}'\'' | sort | uniq -c | sed '\''s/\\, /\\,/g'\'' | sed '\''s/   /  /g'\''| sed '\''s/  / /g'\'' | sed '\''s/  //g'\'' | awk '\''{guarda=$1; $1=\"\"; print $0\",\"guarda;}'\''"}' > $CPLOG_DIR/super_temp_ocorrencias_cidades.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		fMens "$FInsu4" "$MErr14"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		rm -f $CPLOG_DIR/super_temp_ocorrencias_cidades.bash
		return
	fi
	bash $CPLOG_DIR/super_temp_ocorrencias_cidades.bash > $CPLOG_DIR/super_temp_tabela_ocorrencias_novospdf.txt 2> /dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo16"
		rm -f $CPLOG_DIR/super_temp_ocorrencias_cidades.bash
	else
		fMens "$FInsu4" "$MErr14"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		rm -f $CPLOG_DIR/super_temp_ocorrencias_cidades.bash $CPLOG_DIR/super_temp_tabela_ocorrencias_novospdf.txt 
		return
	fi
	#													gerar arquivo de instruções SQL para popular tabela su_docs_cidades
	cat $CPLOG_DIR/super_temp_tabela_ocorrencias_novospdf.txt | sed 's/txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA'/pdf/g' | awk 'BEGIN{FS=","}{gsub(/^ /,"",$1);print "insert into su_docs_cidades (id_cidade, id_documento, ocorrencia) values ((select id_chave_cidade from su_cidades where cidade_sem_acentuacao=\""$1"\" limit 1),(select id_chave_documento from su_documents where photo_filename_documento like \""$2"\" limit 1),"$3");"}' > $CPLOG_DIR/super_temp_popular_su_docs_cidades.sql
	if [ $? -ne 0 ]; then
		fMens "$FInsu4" "$MErr15"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		rm -f $CPLOG_DIR/super_temp_popular_su_docs_cidades.sql $CPLOG_DIR/super_temp_tabela_ocorrencias_novospdf.txt 
		return
	fi
	#													trocar indicação de pastas: de temporária para a pasta de imagens
	sed "s#$CPTEMP#$CPIMAGEM#g" -i $CPLOG_DIR/super_temp_popular_su_docs_cidades.sql
	if [ $? -eq 0 ]; then
			fMens "$FSucss" "$MInfo17"
	else
		fMens "$FInsu4" "$MErr15"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		rm -f $CPLOG_DIR/super_temp_popular_su_docs_cidades.sql $CPLOG_DIR/super_temp_tabela_ocorrencias_novospdf.txt 
		return
	fi
	rm -f $CPLOG_DIR/super_temp_tabela_ocorrencias_novospdf.txt
	#												preparar arquivo SQL visando popular as tabelas:
	find $CPTEMP/*.[pP][dD][fF] | grep -i pdf | sed $'s/\//\t\t /g' | awk '{guarda=$NF; printf "insert into su_documents (photo_filename_documento, alt_foto_jpg, nome_documento) values (\"'$CPIMAGEM'/"$NF"\",";gsub(/\.pdf/,"", $NF); printf "\"'$CPIMAGEM'/"$NF"_pagina1.jpg\",\"" ; gsub(/-/," ",$NF); gsub(/_/," ",$NF); print $NF"\");"; out=""; print "insert into su_docs_signatarios (id_signatario, id_documento) values ((select id_chave_registrado from su_registrados where nome_registrado like \"signatário indefinido\"),(select id_chave_documento from su_documents where photo_filename_documento=\"'$CPIMAGEM'/"guarda"\"));"; print "insert into su_docs_instituicoes (id_instituicao, id_documento) values ((select id_chave_instituicao from su_instituicoes where nome_instituicao like \"Instituição Indefinida\"),(select id_chave_documento from su_documents where photo_filename_documento=\"'$CPIMAGEM'/"guarda"\"));"}' > $CPLOG_DIR/super_temp_documentos_novospdf.sql
	if [ $? -eq 0 ]; then
			fMens "$FSucss" "$MInfo04"
	else
		fMens "$FInsu4" "$MErr22"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.			# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		rm -f $CPLOG_DIR/super_temp_*.sql 2>/dev/null
		return
	fi
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then		# ainda existem arquivos PDF?
		fInse										# insere as informações dos arquivos no acervo arquivístico
	fi
	return
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							              INSERIR INFORMAÇÕES NA BASE DE DADOS												|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
#
function fInse () {
	#													popular a base de dados
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPLOG_DIR/super_temp_documentos_novospdf.sql"
	if [ $? -eq 0 ]; then
		rm -f $CPLOG_DIR/super_temp_documentos_novospdf.sql
		fMens "$FSucss" "$MInfo25"
	else
		fMens "$FInsu4" "$MErr17"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
		rm -f $CPLOG_DIR/super_temp*.sql 
		return
	fi
	#													inserir dados das ocorrências de nomes de cidades presentes nos arquivos
	#													TXT na tabela su_docs_cidades
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE 2>/dev/null < $CPLOG_DIR/super_temp_popular_su_docs_cidades.sql
   	if [ $? -eq 0 ]; then
   		fMens "$FSucss" "$MInfo05"
		mv -f $CPTEMP/*.* $CPIMAGEM/.
   		rm -f $CPLOG_DIR/super_temp_popular_su_docs_cidades.sql 
   	else
   		fMens "$FInsu4" "$MErr24"
		mv -f $CPTEMP/*.[pP][dD][fF] $CPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPTEMP/*.*
   		rm -f $CPLOG_DIR/super_temp_popular_su_docs_cidades.sql 
   	fi
	return
}	# fim da rotina de inserção de dados nas tabelas do mysql
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR ARQUIVOS <PDF> PARA O ACERVO DE INFORMAÇÕES											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTrataPDF () {
	#									verificar existência de arquivos PDF para serem tratados
	if ls $CPUPLOADS/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo48"
		return							# nada a ser tratado: sem arquivos PDF novos
	fi
	local -i su_quant
	local -i j=0
	local su_nomebase
	local su_nomebaseSem
	local su_tipo
	local su_arq
	local su_inodesList
	local su_fileClean
	su_quant=$(ls -l $CPUPLOADS/*.[pP][dD][fF] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $CPQPDFLOTE ]; then
		su_quant=$CPQPDFLOTE			# limita quantidade de arquivos a transferir
	fi
	fMens	"$FInfor" "$MInfo08"		# mensagem informando do inicio tratamento arquivos PDF
	su_inodesList=$(ls -i $CPUPLOADS/*.[pP][dD][fF] | awk '{print $1}' | tr '\n' ' ')
	#									mover certa quantidade de  arquivos DOCX para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPTEMP \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPTEMP -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	#									loop para certificar-se do mime-type
	su_arq=$(ls -1 $CPTEMP/*.[pP][dD][fF] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)					# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimePdf ]
		then
			fMens   "$FInsu2"       "$MErr41"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#								verificar existência de arquivos PDF para serem tratados
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo48"
		return							# nada a ser tratado: sem arquivos PDF novos
	fi
	fGarq                            	# tratar arquivos visando colocar suas informações na base de dados do acervo
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR ARQUIVOS <DOCX> PARA O ACERVO DE INFORMAÇÕES											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTrataDOCX () {
	#									verificar existência de arquivos DOCX para serem tratados
	if ls $CPUPLOADS/*.[dD][oO][cC][xX]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo51"
		return							# nada a ser tratado: sem arquivos DOCX novos
	fi
	local -i su_quant
	local -i j=0
	local su_nomebase
	local su_nomebaseSem
	local su_tipo
	local su_arq
	local su_inodesList
	local su_fileClean
	su_quant=$(ls -l $CPUPLOADS/*.[dD][oO][cC][xX] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $CPQPDFLOTE ]; then
		su_quant=$CPQPDFLOTE			# limita quantidade de arquivos a transferir
	fi
	fMens	"$FInfor" "$MInfo49"		# mensagem informando do inicio tratamento arquivos DOCX
	su_inodesList=$(ls -i $CPUPLOADS/*.[dD][oO][cC][xX] | awk '{print $1}' | tr '\n' ' ')
	#
 	#									mover certa quantidade de  arquivos DOCX para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter seus nomes com caracteres de controle
	do
		find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPTEMP \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPTEMP -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPTEMP/*.[dD][oO][cC][xX] 2>/dev/null)
	#													loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeDocx ]
		then
			fMens	"$FInsu2"	"$MErr37"
			fMens	"$FInsu3"	"$su_nomebase"
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#									verificar ainda existência de arquivos DOCX para serem tratados
	if ls $CPTEMP/*.[dD][oO][cC][xX]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo51"
		return							# nada a ser tratado: sem arquivos DOCX novos
	fi
	#													loop para geração de PDFs
	su_arq=$(ls -1 $CPTEMP/*.[dD][oO][cC][xX] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPTEMP/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f  $CPTEMP/$su_nomebaseSem.pdf
			fMens 	"$FInsu2" "$MErr33"
			fMens	"$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv -f $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original DOCX para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo51"
		return							# nada a ser tratado: sem arquivos DOCX novos
	fi
	fGarq                            	# tratar arquivos visando colocar suas informações na base de dados do acervo
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR ARQUIVOS <DOC> PARA O ACERVO DE INFORMAÇÕES											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTrataDOC () {
	#									verificar existência de arquivos DOC para serem tratados
	if ls $CPUPLOADS/*.[dD][oO][cC]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo54"
		return							# nada a ser tratado: sem arquivos DOC novos
	fi
	#									variáveis locais
	local -i su_quant
	local -i j=0
	local su_nomebase
	local su_nomebaseSem
	local su_tipo
	local su_arq
	local su_inodesList
	local su_fileClean
	su_quant=$(ls -l $CPUPLOADS/*.[dD][oO][cC] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $CPQPDFLOTE ]; then
		su_quant=$CPQPDFLOTE			# limita quantidade de arquivos a transferir
	fi
	fMens	"$FInfor" "$MInfo55"		# mensagem informando do início tratamento arquivos DOC
	su_inodesList=$(ls -i $CPUPLOADS/*.[dD][oO][cC] | awk '{print $1}' | tr '\n' ' ')

    #									mover certa quantidade de  arquivos DOCX para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPTEMP \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPTEMP -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPTEMP/*.[dD][oO][cC] 2>/dev/null)
	#													loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeDoc ]
		then
			fMens   "$FInsu2"       "$MErr38"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#													verificar ainda existência de arquivos DOCX para serem tratados
	if ls $CPTEMP/*.[dD][oO][cC]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"       "$MInfo54"
		return											# nada a ser tratado: sem arquivos DOC novos
	fi
	#													loop para geração de PDFs		
	su_arq=$(ls -1 $CPTEMP/*.[dD][oO][cC] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPTEMP/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f $CPTEMP/$su_nomebaseSem.pdf
			fMens "$FInsu2" "$MErr32"
			fMens "$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv -f $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original DOC para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo54"
		return							# sem arquivos DOC a serem tratados
	fi
	fGarq                            	# tratar arquivos visando colocar suas informações na base de dados do acervo
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR ARQUIVOS <RTF> PARA O ACERVO DE INFORMAÇÕES											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTrataRTF () {
	#									verificar existência de arquivos RTF para serem tratados
	if ls $CPUPLOADS/*.[rR][tT][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo57"
		return							# nada a ser tratado: sem arquivos RTF novos
	fi
	#									variaveis locais
	local -i su_quant
	local -i j=0
	local su_nomebase
	local su_nomebaseSem
	local su_tipo
	local su_arq
	local su_inodesList
	local su_fileClean
	su_quant=$(ls -l $CPUPLOADS/*.[rR][tT][fF] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $CPQPDFLOTE ]; then
		su_quant=$CPQPDFLOTE			# limita quantidade de arquivos a transferir
	fi
	fMens	"$FInfor" "$MInfo58"		# mensagem informando do inicio tratamento arquivos RTF
	su_inodesList=$(ls -i $CPUPLOADS/*.[rR][tT][fF] | awk '{print $1}' | tr '\n' ' ')
	#									mover certa quantidade de  arquivos RTF para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPTEMP \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPTEMP -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPTEMP/*.[rR][tT][fF] 2>/dev/null)
	#									loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)		# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeRtf ]
		then
			fMens   "$FInsu2"       "$MErr40"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#									verificar ainda existência de arquivos RTF para serem tratados
	if ls $CPTEMP/*.[rR][tT][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"       "$MInfo57"
		return							# nada a ser tratado: sem arquivos RTF novos
	fi
	#									loop para geração de PDFs
	su_arq=$(ls -1 $CPTEMP/*.[rR][tT][fF] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPTEMP/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f  $CPTEMP/$su_nomebaseSem.pdf
			fMens "$FInsu2" "$MErr35"
			fMens   "$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original RTF para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo57"
		return							# nada a ser tratado: sem arquivos RTF novos
	fi
	fGarq                            	# tratar arquivos visando colocar suas informações na base de dados do acervo
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR ARQUIVOS <ODT> PARA O ACERVO DE INFORMAÇÕES											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTrataODT () {
	#									verificar existência de arquivos ODT para serem tratados
	if ls $CPUPLOADS/*.[oO][dD][tT]  1> /dev/null 2>&1; then
		:
	else
	fMens   "$FInfor"	"$MInfo20"
		return							# nada a ser tratado: sem arquivos ODT novos
	fi
	#									variaveis locais
	local -i su_quant
	local -i j=0
	local su_nomebase
	local su_nomebaseSem
	local su_tipo
	local su_arq
	local su_inodesList
	local su_fileClean
	su_quant=$(ls -l $CPUPLOADS/*.[oO][dD][tT] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $CPQPDFLOTE ]; then
		su_quant=$CPQPDFLOTE			# limita quantidade de arquivos a transferir
	fi
	fMens	"$FInfor" "$MInfo21"		# mensagem informando do inicio tratamento arquivos ODT
	su_inodesList=$(ls -i $CPUPLOADS/*.[oO][dD][tT] | awk '{print $1}' | tr '\n' ' ')
	#									mover certa quantidade de  arquivos ODT para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPTEMP \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPTEMP -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPTEMP/*.[oO][dD][tT] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)                                              # nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeOdt ]
		then
			fMens   "$FInsu2"       "$MErr39"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#									verificar ainda existência de arquivos ODT para serem tratados
	if ls $CPTEMP/*.[oO][dD][tT]  1> /dev/null 2>&1; then
			:
	else
		fMens   "$FInfor"       "$MInfo20"
		return                                                  # nada a ser tratado: sem arquivos ODT novos
	fi
	#
	#									loop para geração de PDF
	su_arq=$(ls -1 $CPTEMP/*.[oO][dD][tT] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPTEMP/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f  $CPTEMP/$su_nomebaseSem.pdf
			fMens 	"$FInsu2" "$MErr36"
			fMens   "$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original ODT para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo20"
		return							# nada a ser tratado: sem arquivos ODT novos
	fi
	fGarq                            	# tratar arquivos visando colocar suas informações na base de dados do acervo
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR ARQUIVOS <TXT> PARA O ACERVO DE INFORMAÇÕES											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTrataTXT () {
	#									verificar existência de arquivos TXT para serem tratados
	if ls $CPUPLOADS/*.[tT][xX][tT]  1> /dev/null 2>&1; then
		:
	else
	fMens   "$FInfor"	"$MInfo23"
		return							# nada a ser tratado: sem arquivos TXT novos
	fi
	#									variáveis locais
	local -i j=0
	local -i	su_quant
	local su_inodesList
	local su_arq
	local su_fileClean
	local su_nomebase
	local su_tipo
	local su_nomebase
	local su_nomebaseSem
	#
	su_quant=$(ls -l $CPUPLOADS/*.[tT][xX][tT] 2>/dev/null | grep  "^-"  -c)    # numero arquivos existentes
        if [ $su_quant -gt $CPQPDFLOTE ]; then
                su_quant=$CPQPDFLOTE		# limita quantidade de arquivos a transferir
        fi
	fMens   "$FInfor" "$MInfo59"            # mensagem informando do inicio tratamento arquivos TXT
	#
	su_inodesList=$(ls -i $CPUPLOADS/*.[tT][xX][tT] | awk '{print $1}' | tr '\n' ' ')
	#										mover certa quantidade de arquivos TXT para pasta de trabalho
	#										Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList					# transferir usando inode: arquivos podem ter seus nomes com caracteres de controle
	do
		find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPTEMP \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPUPLOADS -type f -inum $i -exec mv -f {} $CPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#										tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#										primeira limpeza ainda superficial, mas necessária para iniciar tratamento do arquivo
	find $CPTEMP -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPTEMP/*.[tT][xX][tT] 2>/dev/null)	# loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeTxt ]
		then
			fMens   "$FInsu2"       "$MErr42"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#													verificar ainda existência de arquivos TXT para serem tratados
	if ls $CPTEMP/*.[tT][xX][tT]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"       "$MInfo23"
		return											# nada a ser tratado: sem arquivos TXT novos
	fi
	#													loop para geração de PDFs
	su_arq=$(ls -1 $CPTEMP/*.[tT][xX][tT] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)									# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"							# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPTEMP/$su_nomebaseSem $i
		if [ $? -ne 0 ]; then
			mv -f  $i $CPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f $CPTEMP/$su_nomebaseSem.pdf
			fMens "$FInsu2" "$MErr43"
			fMens "$FInsu3" "$su_nomebase"
		else
			fMens   "$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv -f $i $CPPRIMITIVO/$su_nomebase			# move o arquivo original TXT para pasta de já tratados
		fi
	done
	#													verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"       "$MInfo23"
		return											# sem arquivos TXT a serem tratados
	fi
	fGarq											# tratar arquivos visando colocar suas informações na base de dados do acervo
}
#
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							              CONTROLE E CORPO PRINCIPAL DO SCRIPT												|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
#
#
declare -a su_Funcoes=(fTrataPDF fTrataDOCX fTrataDOC fTrataRTF fTrataODT fTrataTXT)		# array com nome das funções para tratamento dos tipos de arquivos
declare -i su_pontFuncoes=0
declare -i su_quantTratados=0
fInit							# testes do ambiente e preparações iniciais
while [ ${#su_Funcoes[*]} -gt $su_pontFuncoes ]; do
	${su_Funcoes["$su_pontFuncoes"]}
	if [ $su_quantTratados -ge $CPQPDFLOTE ]; then
		fMens	"$FInfor"	"$MInfo22"				# máximo de arquivos tratados nesta ativação do script foi alcançado
		break
	fi
	let su_pontFuncoes=$su_pontFuncoes+1;
done
#
	#												resumo
	fMens "$FInfo2" "$MInfo31"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$CPBASE'")"
	fMens "$FInfo2" "$MInfo26"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_documents")"
	fMens "$FInfo2" "$MInfo27"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_docs_signatarios") "
	fMens "$FInfo2" "$MInfo28"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_docs_instituicoes")"
	fMens "$FInfo2" "$MInfo29"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_cidades") "
	fMens "$FInfo2" "$MInfo30"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_docs_cidades") "
	fMens "$FInfo2" "$MInfo02"
	fMens "$FInfo1" "$(ls -la $CPQUARENTINE/ | grep -e "^-" | wc -l)"
	fMens "$FInfo2" "$MInfo45"
	fMens "$FInfo1" "$(ls -la $CPUPLOADS/ | grep -e "^-" | wc -l)"
#									verificar existência de arquivos PDF para serem tratados
#if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
#		fInse						# insere as informações dos arquivos nas tabelas do acervo arquivístico
#	else
#		fMens   "$FInfor"	"$MInfo48"  # nada a ser tratado: sem arquivos PDF novos
#fi
#
#													compactar arquivo de log, se necessário
if	[ $(ls -l $CPLOG_DIR/$CPLOGSFILE | awk '{ print $5}') -gt 900000 ];then
	tar -zcf $CPLOG_DIR/$CPLOGSFILEGZ  $CPLOG_DIR/$CPLOGSFILE  2> /dev/null
	if [ $? -eq 0 ];then
		rm -f $CPLOG_DIR/$CPLOGSFILE
		fMens	"$FSucss" "$MInfo46:  $(date '+%d-%m-%Y as  %H:%M:%S')"
		mv "$CPLOG_DIR/$CPLOGSFILEGZ" "$CPLOG_DIR/$(date +%F)$CPLOGSFILEGZ"
	else
		fMens	"$FInsuc" "$MErr26"
	fi
fi
#								fim do script com sucesso
fMens	"$FSucss"	"$MInfo32"
fMens	"$FInfor"	"$MInfo09:  $(date '+%d-%m-%Y as  %H:%M:%S')"
exit	0

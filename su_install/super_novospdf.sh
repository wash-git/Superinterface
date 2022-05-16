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
MErr04="Erro! Não foi encontrado o arquivo SHELL do usuário para preparação dos INSERTs na base de dados"
MErr05="Erro! Não foi possível preparar pasta de trabalho temporária: pasta não pode ser limpa"
MErr06="Erro! Não foi possível preparar pasta de trabalho temporária: pasta não pode ser criada"
MErr07="Erro! Não foi possível se conectar com o banco de dados"
MErr08="Erro! Não foi possível mover este arquivo da pasta de uploads para início de seu tratamento: "
MErr09="Erro! Pasta para upload de arquivos inexistente" 
MErr10="Interrompendo a execução do script"
MErr11="Erro! Pasta para guardar os arquivos do acervo não foi encontrada"
MErr12="Não foi possível deixar os nomes dos arquivos em minúsculo.  Transferindo arquivo(s) do lote para quarentena"
MErr13="Erro! Problemas na geração do script para criação de arquivos TXT. Transferindo arquivo(s) do lote para quarentena"
MErr14="Transferindo arquivos para quarentena. É altamente recomendável verificar a consistência da base de dados devido esta interrupção de inserção de informações na base"
MErr15="Erro! Problemas na inserção de informações na base de dados a partir do arquivo= "
MErr16="Erro! Problema na execução do script de geração de arquivos TXT. Transferindo arquivo(s) do lote para quarentena"
#MErr17=""
MErr18="Erro! Não foi possível criar pasta de quarentena"
MErr19="Erro! Pasta de logs não existe"
MErr20="Erro! Arquivo de configuração desta aplicação não foi encontrado"
MErr21="Erro! Problemas na cópia de arquivos da pasta de upload para a pasta emporária de tratamento destes arquivos"
#MErr22=""
MErr23="Erro! Arquivo de logs não existe e não foi possível recriá-lo"
#MErr24=""
MErr25="Erro! É necessário instalar o aplicativo 'detox' conforme manual de instalação"
MErr26="Erro! Não foi possível compactar arquivo de logs"
Merr27="Erro! Script periódico de incorporação de arquivos ao acervo da Superinterface só pode ser executado a partir da pasta 'su_install'"
MErr28="Erro! Arquivo que guarda a numeração dos nomes dos arquivos do acervo não foi encontrado. Transferindo arquivo(s) do lote para quarentena"
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
MErr49="Erro! É necessário instalar o aplicativo 'aha' conforme manual de instalação"
#MErr50=""
#MErr51=""
#MErr52=""
MErr53="Alerta! Não foi possível gerar o TXT para este arquivo, logo não indexando seu conteúdo. Ainda assim, seu PDF e JPG serão colocados no acervo: "
MErr54="Erro! Pasta de arquivos javascript não foi encontrada"
#MErr55=""
MErr56="Erro! Script SHELL do usuário, para preparação dos INSERTs da aplicação, retornou com código de erro= "
#
#	mensagens de informação
MInfo01="Bem vindo ao script de tratamento de novos arquivos do acervo em: "
MInfo02="Quantidade de arquivos na pasta de quarentena= "
MInfo03="Sucesso. Criada pasta temporária para tratamento de arquivos" 
#MInfo04=""
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
#MInfo15=""
#MInfo16=""
#MInfo17=""
#MInfo18=""
MInfo19="Sucesso. Geração de arquivos JPG realizada corretamente"
MInfo20="Nenhum arquivo ODT para ser tratado neste momento"
MInfo21="Iniciando o tratamento de um lote de arquivos ODT"
MInfo22="Alcançado o número máximo de arquivos passíveis de tratamento nesta ativação do script"
MInfo23="Nenhum arquivo TXT para ser tratado neste momento"
MInfo24="Sistema configurado para renomear e numerar os arquivos. Atenção: isso fará parar a verificação de arquivos duplicados no acervo"
#MInfo25=""
MInfo26="Quantidade de registros na tabela "
MInfo27="Aviso: script SHELL do usuário, para preparação dos INSERTs na base de dados, foi encontrado. Executando, mas pode demorar um pouco..."
MInfo28="Sucesso! Script SHELL do usuário, de preparação dos INSERTs da aplicação, foi executado corretamente"
#MInfo29=""
#MInfo30=""
MInfo31="Quantidade de tabelas existentes na base= "
MInfo32="Sucesso. Fim do tratamento dos novos arquivos submetidos ao acervo!"
MInfo33="Arquivo já existia na pasta de quarentena. Suspendendo o tratamento deste arquivo: "
MInfo34="Movendo este arquivo para pasta de quarentena pois ele já existe no repositório: "
MInfo35="Detectado arquivo novo, a ser incluído no repositório:  "
MInfo36="Aviso: estranho! Pasta de quarentena não encontrada no ambiente.  Fizemos sua recriação com sucesso"
#MInfo37=""
MInfo38="Término do tratamento para este lote de arquivos"
MInfo39="Aviso: estranho! O arquivo de logs não existia.  Fizemos sua recriação"
MInfo40="Aviso: notamos a falta do aplicativo cowsay. Mas ele não é obrigatório. Dica: assim que possível, instalar o cowsay conforme manual de instalação"
MInfo41="Aviso: notamos a falta do aplicativo figlet. Mas ele não é obrigatório. Dica: assim que possível, instalar o figlet conforme manual de instalação"
MInfo42="Data:"
MInfo43="Iniciando o tratamento dos novos arquivos"
MInfo44=".....Arquivo de log não encontrado. Testando acesso ao arquivo de logs para recriá-lo"
MInfo45="Quantidade de arquivos restantes a serem tratados (da pasta de uploads)= "
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
#MInfo61=""
#MInfo62=""
#MInfo63=""
#MInfo64=""
#MInfo65=""
#MInfo66=""
#MInfo67=""
MInfo68="PID do processo 'unoconv (soffice)' em uso= "
MInfo69="Processo 'unoconv (soffice)' não encontrado, e será iniciado agora"
#				  códigos das mensagens
FInfor=0        # saída normal: new line ao final, sem tratamento de cor
FInfo1=1        # saída normal: new line ao final, sem tratamento de cor e sem ..... (sem pontinhos ilustrativos)
FInfo2=2        # saída sem new line ao final, sem tratamento de cor
FInfo3=3		# saída sem new line ao final, sem tratamento de cor, espaços em branco no início (     )
FSucss=4        # saída de sucesso: new line ao final da mensagem. na cor azul. No final, muda para cor branca
FSucs2=5        # saída de sucesso: new line antes e depois da mensagem, cor azul. No final, muda para cor branca
FInsuc=6        # saída de erro, na cor vermelha, com mensagem de interrupção do script
FInsu1=7        # saída de erro, na cor vermelha (apenas no screen, não enviado para arquivo de log)
FInsu2=8		# saída de erro, na cor vermelha, sem new line ao final e sem ....
FInsu3=9		# saída de erro, na cor vermelha, com new line ao final
FInsu4=10		# saída de erro, na cor vermelha, com new line ao final e com ....
FCowsa=11        # saída para aplicativo cowsay
FFighl=12        # saída para aplicativo fighlet
FLinha=13		# saída de uma linha separadora para novo log
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
				echo -e ".....$2" | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FInfo1)
				echo -e "$2" | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FInfo2)							# sem line feed, cor default
				echo -n ".....$2" | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FInfo3)
                echo -n "     $2" | tee -a "$CPPLOG"/"$CPALOG"
                ;;
			$FSucs3)							# sem line feed, cor azul
				echo -ne "\e[34m.....$2\e[97m" | tee -a "$CPPLOG"/"$CPALOG"
            	;;
			$FSucss)							# com line feed ao final. cor azul
        		echo -e "\e[34m.....$2\e[97m" | tee -a "$CPPLOG"/"$CPALOG"
            	;;
			$FSucs2)							# com lines feed antes e depois, cor azul
				echo -e "\n\e[34m.....$2\e[97m" | tee -a "$CPPLOG"/"$CPALOG"
            	;;
			$FInsuc)							# com line feed depois, aviso de interrupção do script, cor vermelha
				echo -e  "\e[31m.....$2" | tee -a "$CPPLOG"/"$CPALOG"
            	echo -e ".....$MErr10\e[97m" | tee -a "$CPPLOG"/"$CPALOG"	# mens. interrompendo script
            	;;
			$FInsu1)							# na cor vermelha (apenas no screen, não enviado para arquivo de log)
				echo -e  "\n\e[31m.....$2"
				echo -e ".....$MErr10\e[97m"	# mens. interrompendo script
				;;
			$FInsu2)							# sem line feed ao final, cor vermelha
				echo -ne "\e[31m.....$2" | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FInsu3)							# com line feed ao final, cor vermelha, ao final volta cor default
				echo -e "\e[31m$2\e[97m"  | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FInsu4)							# na cor vermelha, com new line ao final e com ....
				echo -e  "\e[31m.....$2\e[97m" | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FCowsa)
				shuf -n 1 $2 | cowsay -p -W 50 | tee -aa "$CPPLOG"/"$CPALOG"
#				shuf -n 1 $2 | cowsay -p -W 50 | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FLinha)
				printf '=%.0s' {1..100}
				printf '=%.0s' {1..100} >> $CPPLOG/$CPALOG
				echo -e "\n\n" | tee -a "$CPPLOG"/"$CPALOG"
				;;
			$FFighl)
				figlet -f standard -k -t -c -p -w 120  "
--------------
Superinterface
--------------" | tee -aa "$CPPLOG"/"$CPALOG"
				;;
			*)
        		echo "\e[31m.....OOOooops!\e[97m" | tee -aa "$CPPLOG"/"$CPALOG"
            	echo $1 | tee -aa "$CPPLOG"/"$CPALOG"
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
	C2: se o arquivo de configuração está disponível
	C3: se a pasta corrente é a de instalação
	C4: se pasta e arquivo de logs estão preparados
	C5: se pasta de uploads está disponível
	C6: verificar existência de arquivos para tratamento esperando na pasta de uploads
	--------	--------	--------  
	C7:  verificar se aplicativo unoconv está instalado
	C8:  verificar se aplicativo aha     está instalado
	C9:  verificar se aplicativo detox   está instalado
	C10:  verificar se aplicativo figlet  está instalado
	C11: verificar se aplicativo cowsay  está instalado
	C12: verificar existência arquivo contendo nomes das cidades
	C13: verificar existência de arquivo com comandos SQL para inserção dados na tabela su_cidades
	C14: verificar pasta para arquivos do acervo
	C15: verificar pasta de arquivos javascript
	C16: verificar pasta de trabalho
	C17: verificar existência da pasta de arquivos não PDF já preparados
	C18: verificar existência de pasta de quarentena
	C19: verificar a conexão com o banco de dados
	--------	--------	--------  
'
	#										C1: verificar se é usuário root
	if [ "$EUID" -eq $CPROOT_UID ];  then 
    	fMens "$FInsu1" "$MErr01"
        exit
	fi
	#										C2: verificar se arquivo de configuração está disponível
	if [ ! -f $CPCONFIG ]; then
		fMens "$FInsu1" "$MErr20"
		exit
	fi
	source	$CPCONFIG						# inserir arquivo de configuração
	chmod	$CPPERM500 $0					# estabelecer permissão para este arquivo
    #										C3: verificar se pasta corrente é a de instalação
	if [ "${PWD##*/}" != "$(basename $CPPINSTALL)" ]; then
		fMens "$FInsu1" "$MErr27"
        exit
    fi
	#										C4: verificar se pasta de logs está disponível
	if [ ! -d $CPPLOG ]; then
		fMens "$FInsuc" "$MErr19"
 		exit
 	fi	
	#										verificar existência de arquivo de logs
	if [ ! -f "$CPPLOG/$CPALOG" ]; then
		echo  -e "\n$MInfo44" >> "$CPPLOG"/"$CPALOG"	# testando escrita no arquivo de logs 
		if [ $? -ne 0 ]; then
			fMens	"$FInsuc" "$MErr23"
			exit
		fi
		fMens	"$FInsu4" "$MInfo39"
	fi
	#										C5: verifica existência de pasta de uploads de arquivos
	if [ ! -d $CPPUPLOADS ]; then
		fMens "$FInsuc" "$MErr09"
		exit
	fi
	#										C6: verificar existência de arquivos para serem tratados
	if ls $CPPUPLOADS/*.*  1> /dev/null 2>&1; then
		:
	else
		exit 0								# nada a ser tratado: sem arquivos novos
	fi
	#										linha separadora do log anterior
	fMens	"$FLinha"	""
	fMens	"$FInfor" "$MInfo10"			# mensagem que existem novos arquivos para serem tratados
	fMens	"$FInfo2" "$MInfo53"
	fMens	"$FInfo1" "$(ls $CPPUPLOADS/* | wc -l)"
	#										C7: verificar se aplicativo unoconv está instalado
	#										(necessário para conversão arquivos -> .pdf)
	if [ -n "$(dpkg --get-selections | grep unoconv | sed '/deinstall/d')" ]; then
	:
	else
		fMens "$FInsuc" "$MErr30"
		exit
	fi
	#										C8: verificar se aplicativo aha está instalado
	#										(necessário para geração html de arquivo de logs)
	if [ -n "$(dpkg --get-selections | grep aha | sed '/deinstall/d')" ]; then
	:
	else
		fMens "$FInsuc" "$MErr49"
		exit
	fi
	#										C9: verificar se aplicativo detox está instalado
	if [ -n "$(dpkg --get-selections | grep detox | sed '/deinstall/d')" ]; then
	:
	else
		fMens "$FInsuc" "$MErr25"
		exit
	fi
	#										C10: verificar se aplicativo figlet está instalado
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
	#										C11: verificar se aplicativo cowsay está instalado
	if [ -n  "$(dpkg --get-selections | grep cowsay | sed '/deinstall/d')" ]; then
		fMens "$FCowsa"  "$CPNOMECOWSAY1"
	else
		fMens "$FInfor" "$MInfo40"
	fi
	#										C14: verificar existência da pasta para arquivos do acervo
	if [ ! -d $CPPIMAGEM ]; then
		fMens "$FInsuc" "$MErr11"
		exit
	fi
	#										C15: verificar existência da pasta de arquivos javascript
	if [ ! -d $CPPIMAGEM ]; then
		fMens "$FInsuc" "$MErr54"
		exit
	fi
	#										C16: verificar pasta de trabalho (arquivos temporários)
	rm -rf $CPPWORK 2>/dev/null
    if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr05"
        exit
	fi
    mkdir $CPPWORK
    if [ $? -ne 0 ]; then
    	fMens "$FInsuc" "$MErr06"
        exit
	else
    	fMens "$FSucss" "$MInfo03"
	fi
	#										C17: verificar existência de pasta de arquivos originais não PDF
	if [ ! -d $CPPRIMITIVO ]; then
		mkdir $CPPRIMITIVO
	    if [ $? -ne 0 ]; then
			fMens "$FInsuc" "$MErr34"
        	exit
		else
			fMens	"$FInsu4"	"$MInfo52"
		fi
	fi
	#										C18: verificar existência de pasta de quarentena
	if [ ! -d $CPPQUARENTINE ]; then
		mkdir $CPPQUARENTINE
	    if [ $? -ne 0 ]; then
			fMens "$FInsuc" "$MErr18"
        	exit
		else
			fMens	"$FInsu4"	"$MInfo36"
		fi
	fi
	#										C19: testar conexão com o banco de dados
    mysql -u $CPBASEUSER -b $CPBASE -p$CPBASEPASSW -e "quit" 2>/dev/null
	if [ $? -ne 0 ]; then
    	fMens "$FInsuc" "$MErr07"
		exit
    else
			fMens "$FSucss" "$MInfo07"
	fi
	#											verificar se deve renomear os arquivos (numerando-os)
	if [ $CPNUMERARPDF -ne 0 ]; then
		fMens	"$FInfor"	"$MInfo24"			# mensagem informativa que irá renomear os arquivos
	fi
	#											Definir permissões para pastas e arquivos
    chmod $CPPERM750 $CPPINSTALL            # definir permissão pasta de instalação da Superinterface
    chmod $CPPERM750 $CPPPHP                # definir permissão pasta arquivos PHP da admin da Superinterface
    chmod $CPPERM750 $CPPJS                 # definir permissão pasta de arquivos javascript
    chmod $CPPERM750 $CPPLOG                # definir permissão pasta de logs
    chmod $CPPERM750 $CPPCSS                # definir permissão pasta de css
    chmod $CPPERM750 $CPPDOCS               # definir permissão pasta da documentação da Superinterface
    chmod $CPPERM750 $CPPEXEMPLOS           # definir permissão pasta exemplos SQL externos
    chmod $CPPERM750 $CPPICONS              # definir permissão pasta de icons
    chmod $CPPERM750 $CPPIMAGEM             # definir permissão pasta do acervo de arquivos
    chmod $CPPERM750 $CPPAUTOPHP            # definir permissão pasta de arquivos PHP a serem gerados
    chmod $CPPERM750 $CPPADMIN              # definir permissão pasta administrativa da Superinterface
    chmod $CPPERM750 $CPPQUARENTINE         # definir permissão pasta de quarentena
    chmod $CPPERM750 $CPPWORK               # definir permissão pasta de trabalho
    chmod $CPPERM750 $CPPRIMITIVO           # definir permissão pasta de arquivos não PDF já preparados
    chmod $CPPERM750 $CPPUPLOADS            # definir permissão pasta de uploads de arquivos destinados ao acervo
	# ... ... ...
	chmod	$CPPERM600 $CPCONFIG				# estabelecer permissão para arquivo configuração
	chmod	$CPPERM640 $CPPLOG"/"$CPALOG		# estabelecer permissão para arquivo logs
	chmod 	$CPPERM440 $CPNOMECOWSAY1			# estabelecer permissão para arquivo mensagens cowsay	
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
	find $CPPWORK -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", @()&'!$" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_quant=$(ls -l $CPPWORK/*.[pP][dD][fF] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	su_quantTratados=$su_quantTratados+$su_quant		# atualiza quantidade arquivos já tratados nesta ativação do script
	#                               					verificar se há corrupção dos arquivos PDF
	for i in "$CPPWORK"/*.[pP][dD][fF]; do
		pdfinfo "$i" &>/dev/null
		if [ ! $? -eq 0 ]; then
			mv -f $i "$CPPQUARENTINE"/.
			fMens   "$FInfor"       "$MInfo47 $(basename $i)"
		fi
	done
	#                               						verificar se ainda há arquivos PDF a serem tratados
	su_qpdf=$(ls -la $CPPWORK/*.[pP][dD][fF] 2>/dev/null | grep -e "^-" | wc -l) 2>/dev/null
	if [ $su_qpdf -eq 0 ]; then
		fMens	"$FInfor"	"$MInfo60"
		return
	fi
	#														modificar nomes dos arquivos PDF para minúsculo
	for i in "$CPPWORK"/*.[pP][dD][fF]; do
		detox -s lower-only $i
		if [ $? -ne 0 ]; then
			mv -f $i "$CPPQUARENTINE"/. 2>/dev/null			# enviar o arquivo PDF para quarentena
			fMens "$FInsu2" "$MErr44"
			fMens "$FInsu3" "$(basename $i)"
		fi
	done
	#                               						verificar se ainda há arquivos PDF a serem tratados
	su_qpdf=$(ls -la $CPPWORK/*.[pP][dD][fF] 2>/dev/null | grep -e "^-" | wc -l) 2>/dev/null
	if [ $su_qpdf -eq 0 ]; then
		fMens	"$FInfor"	"$MInfo60"
		return
	fi
	#														verificar se deve renomear os arquivos (numerando-os)
	if [ $CPNUMERARPDF -ne 0 ]; then
	 	fMens   "$FInfor"	"$MInfo11"						# mensagem de renomear arquivos 
		if [ ! -f $CPPADMIN/$CPINDICEPDF ]; then			# testar existência de arquivo com próximo número para numerar
			mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
			fMens "$FInsu4" "$MErr28"						# arquivo com informação de numeração não encontrado 
			fMens "$FInfor" "$MInfo38"
			return
		fi
		su_cont=$(cat $CPPADMIN/$CPINDICEPDF)				# faz leitura do próximo número a ser renomeado o arquivo
		if (echo $su_cont | egrep '[^0-9]' &> /dev/null) then
			mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/. 2>/dev/mull	# enviar os arquivos PDF para quarentena
			fMens	"$FInsuc" "$MErr29"									# valor encontrado não é numérico
			fMens "$FInfor" "$MInfo38"
			return
		fi
		for i in $CPPWORK/*.[pP][dD][fF]
		do 
			su_arq=$(basename $i)								# nome do arquivo com extensão, mas sem caminho
			su_arq=${su_arq%.*}									# nome do arquivo sem extensão e sem caminho
			mv -i "$i" "$CPPWORK/super${su_cont}_${su_arq:0:$CPMAX}.pdf"
			if [ $? -ne 0 ]
			then
				mv -f $CPPWORK/*.[pP][dD][fF] "$CPPQUARENTINE"/.	# enviar os arquivos PDF para quarentena
				fMens "$FInsu4" "$MErr12"
				fMens "$FInfor" "$MInfo38"
				return
			else
				let su_cont=$su_cont+1
				echo $su_cont > $CPPADMIN/$CPINDICEPDF			# atualiza valor do contador no arquivo
				if [ $? -ne 0 ]
				then
					mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
					fMens "$FInsu4" "$MErr45"
					fMens "$FInfor" "$MInfo38"
					return
				fi
			fi
		done
		fMens "$FSucss" "$MInfo12"	
	fi
	#													verificar se os arquivos já estão na pasta de quarentena
	for i in $CPPWORK/*.[pP][dD][fF]; do
		su_nomebase=$(basename $i)						# nome do arquivo com extensão, e sem caminho (path)
		if [ -f $CPPQUARENTINE/$su_nomebase ]; then
			#											arquivo já está colocado em quarentena
			fMens	"$FInfor"	"$MInfo33 $su_nomebase"
			rm -f $i									# suspender o tratamento do arquivo.
		fi
	done
	#													verificar se ainda existem arquivos PDF a serem tratados
	if [ ! "$(ls -A $CPPWORK)" ]; then
			fMens	"$FInfor"	"$MInfo38"
			return
	fi
	#													verificar se os arquivos já estão no acervo (na base dados)
	for i in $CPPWORK/*.[pP][dD][fF]; do
		su_nomebase=$(basename $i)						# nome do arquivo com extensão, e sem caminho (path)
		# su_nomebaseSem="${su_nomebase%.*}"			# nome do arquivo sem extensão
		if [ -f $CPPIMAGEM/$su_nomebase ]; then
			#											arquivo já existe no repositório
			fMens	"$FInfo2"	"$MInfo34"
			fMens	"$FInfo1"	"$su_nomebase"
			mv -f $i $CPPQUARENTINE/.
		else
			fMens	"$FInfo2"	"$MInfo35"				# arquivo para ser tratado.  Não existe no repositório
			fMens	"$FInfo1"	"$su_nomebase"
		fi
	done
	#													verificar se sobrou algum arquivo pdf a ser tratado
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then
    	fMens	"$FInfor" "$MInfo56"
	else
    	fMens	"$FInfor" "$MInfo38"
		return
	fi
	#													gerar arquivos TXT a partir de arquivos PDF
	ls $CPPWORK/*.[pP][dD][fF] | awk '{printf "pdftotext  -layout "$1; gsub(/\.pdf/,".txt",$1); print " "$1}' > $CPPLOG/super_temp_gera_txt.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
		rm -f $CPPLOG/super_temp_gera_txt.bash
		fMens "$FInsu4" "$MErr13"
		fMens "$FInfor" "$MInfo38"
		return
	fi
	chmod 740 $CPPLOG/super_temp_gera_txt.bash 2>/dev/null
	bash $CPPLOG/super_temp_gera_txt.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
		rm -f $CPPLOG/super_temp_gera_txt.bash
		fMens "$FInsu4" "$MErr16"
		fMens "$FInfor" "$MInfo38"
		return
	fi
	rm -f $CPPLOG/super_temp_gera_txt.bash
	#							gerar nomes dos arquivos TXT: sem acentuação, letras maiúsculas e sem caracteres controle
	for i in "$CPPWORK"/*.txt
	do
		sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' $i > $i"."$CPACENTO
		if [ $? -ne 0 ]; then
			mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
			rm -f $CPPWORK/*.*
			fMens "$FInsu4" "$MErr47"
			fMens "$FInfor" "$MInfo38"
			return
		fi
	done
	#
	for i in  "$CPPWORK"/*.$CPACENTO
	do
		tr  [:cntrl:] ' ' < $i > $i".contrl4"
		tr -d '\176-\377' < $i".contrl4" > $i"."$CPCONTRL
	done
	#
	for i in "$CPPWORK"/*.$CPCONTRL
	do
		tr [:lower:] [:upper:] < $i > $i"."$CPMAIUSCULA
	done
	rm -f "$CPPWORK"/*.$CPCONTRL "$CPPWORK"/*.contrl4 "$CPPWORK"/*.$CPACENTO 2> /dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo14"
	else
		mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/. 2>/dev/null	# enviar os arquivos PDF para quarentena
		rm -f $CPPWORK/*.*
		fMens "$FInsu4" "$MErr48"
		fMens "$FInfor" "$MInfo38"
		return
	fi
	#													gerar arquivos JPG a partir de arquivos PDF
	ls $CPPWORK/*.[pP][dD][fF] | awk '{printf "convert "$1"[0]"; gsub(/\.pdf/,"_pagina1.jpg",$1); print " "$1}' > $CPPLOG/super_temp_gera_jpg.bash 2>/dev/null
	chmod 740 $CPPLOG/super_temp_gera_jpg.bash 2>/dev/null
	bash $CPPLOG/super_temp_gera_jpg.bash 2>/dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo19"
		rm -f $CPPLOG/super_temp_gera_jpg.bash
	else
		fMens "$FInsu4" "$MErr46"
		mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		rm -f $CPPWORK/*.*
		rm -f $CPPLOG/super_temp_gera_jpg.bash
		return
	fi
	#													Será chamado um arquivo SHELL para fazer a preparação dos INSERTs
	#													na base de dados das informações dos arquivos submetidos ao acervo.
	if [ ! -f $CPPINFO/$CPINSERTACERVO ]; then
		fMens "$FInsuc" "$MErr04"
		exit
	else
		fMens "$FInfor" "$MInfo27"
		retval=0
#	. $(dirname "$0")/super_tabelas_insert_acervo.sh
	. $CPPINFO/$CPINSERTACERVO
	fi
	if [ $retval -eq 0 ];then
		fMens	"$FSucss"	"$MInfo28"
	else
		mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.			# enviar os arquivos PDF para quarentena
		rm -f $CPPWORK/*.*
		rm -f $CPPLOG/*.bash $CPPLOG/*.sql $CPPLOG/*.txt
		fMens	"$FInsu2"	"$MErr56"
		fMens	"$FInsu3"	"$retval"
		fMens	"$FInsu4"	"$MErr10"
		exit
	fi
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then		# ainda existem arquivos PDF?
		fInse										# insere as informações dos arquivos no acervo arquivístico
	fi
}	# fim da função fGarq
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							              INSERIR INFORMAÇÕES DE OCORRÊNCIAS NA BASE DE DADOS												|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
#
function fInse () {
	#													popular a base de dados com as ocorrências encontradas no interior 
	#													dos arquivos submetidos ao acervo
	for i in "$CPPLOG"/*.sql; do
		mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$i"
		if [ $? -ne 0 ];then
			fMens	"$FInsu2"	"$MErr15"
			fMens	"$FInsu3"	"$i"
			fMens "$FInsu4" "$MErr14"
			mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
			rm -f $CPPWORK/*.*
			rm -f $CPPLOG/*.sql 
			return
		fi
	done
	#												verifica se foi possível extrair o conteúdo do arquivo para txt
	for i in "$CPPWORK"/*.txt
	do
		if [ $(wc -c $i | cut -d " " -f1) -lt 10 ]; then
			fMens	"$FInsu2" "$MErr53"
			fMens	"$FInsu3" "$(basename $i)"
		fi
	done
	fMens "$FSucss" "$MInfo05"
	mv -f $CPPWORK/*.* $CPPIMAGEM/.
	rm -f $CPPLOG/*.sql
	return
	# fim da rotina de inserção das ocorrências nas tabelas da base de dados
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR ARQUIVOS <PDF> PARA O ACERVO DE INFORMAÇÕES											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTrataPDF () {
	#									verificar existência de arquivos PDF para serem tratados
	if ls $CPPUPLOADS/*.[pP][dD][fF]  1> /dev/null 2>&1; then
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
	su_quant=$(ls -l $CPPUPLOADS/*.[pP][dD][fF] 2>/dev/null | grep  "^-"  -c)	# numero arquivos PDF existentes
	if [ $su_quant -gt $((CPQPDFLOTE-su_quantTratados)) ]; then
			su_quant=$((CPQPDFLOTE-su_quantTratados))							# limita quantidade de arquivos a transferir
    fi
	fMens	"$FInfor" "$MInfo08"		# mensagem informando do inicio tratamento arquivos PDF
	su_inodesList=$(ls -i $CPPUPLOADS/*.[pP][dD][fF] | awk '{print $1}' | tr '\n' ' ')
	#									mover certa quantidade de  arquivos PDF para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPWORK \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPPWORK -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	#									loop para certificar-se do mime-type
	su_arq=$(ls -1 $CPPWORK/*.[pP][dD][fF] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)					# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimePdf ]
		then
			fMens   "$FInsu2"       "$MErr41"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#								verificar existência de arquivos PDF para serem tratados
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then
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
	if ls $CPPUPLOADS/*.[dD][oO][cC][xX]  1> /dev/null 2>&1; then
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
	su_quant=$(ls -l $CPPUPLOADS/*.[dD][oO][cC][xX] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $((CPQPDFLOTE-su_quantTratados)) ]; then
		su_quant=$((CPQPDFLOTE-su_quantTratados))								# limita quantidade de arquivos a transferir
    fi
	fMens	"$FInfor" "$MInfo49"		# mensagem informando do inicio tratamento arquivos DOCX
	su_inodesList=$(ls -i $CPPUPLOADS/*.[dD][oO][cC][xX] | awk '{print $1}' | tr '\n' ' ')
	#
 	#									mover certa quantidade de  arquivos DOCX para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter seus nomes com caracteres de controle
	do
		find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPWORK \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPPWORK -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPPWORK/*.[dD][oO][cC][xX] 2>/dev/null)
	#													loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeDocx ]
		then
			fMens	"$FInsu2"	"$MErr37"
			fMens	"$FInsu3"	"$su_nomebase"
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#									verificar ainda existência de arquivos DOCX para serem tratados
	if ls $CPPWORK/*.[dD][oO][cC][xX]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"	"$MInfo51"
		return							# nada a ser tratado: sem arquivos DOCX novos
	fi
	#													loop para geração de PDFs
	su_arq=$(ls -1 $CPPWORK/*.[dD][oO][cC][xX] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPPWORK/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f  $CPPWORK/$su_nomebaseSem.pdf
			fMens 	"$FInsu2" "$MErr33"
			fMens	"$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv -f $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original DOCX para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then
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
	if ls $CPPUPLOADS/*.[dD][oO][cC]  1> /dev/null 2>&1; then
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
	su_quant=$(ls -l $CPPUPLOADS/*.[dD][oO][cC] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $((CPQPDFLOTE-su_quantTratados)) ]; then
			su_quant=$((CPQPDFLOTE-su_quantTratados))							# limita quantidade de arquivos a transferir
    fi
	fMens	"$FInfor" "$MInfo55"		# mensagem informando do início tratamento arquivos DOC
	su_inodesList=$(ls -i $CPPUPLOADS/*.[dD][oO][cC] | awk '{print $1}' | tr '\n' ' ')

    #									mover certa quantidade de  arquivos DOCX para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPWORK \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPPWORK -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPPWORK/*.[dD][oO][cC] 2>/dev/null)
	#													loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeDoc ]
		then
			fMens   "$FInsu2"       "$MErr38"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#													verificar ainda existência de arquivos DOCX para serem tratados
	if ls $CPPWORK/*.[dD][oO][cC]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"       "$MInfo54"
		return											# nada a ser tratado: sem arquivos DOC novos
	fi
	#													loop para geração de PDFs		
	su_arq=$(ls -1 $CPPWORK/*.[dD][oO][cC] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPPWORK/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f $CPPWORK/$su_nomebaseSem.pdf
			fMens "$FInsu2" "$MErr32"
			fMens "$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv -f $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original DOC para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then
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
	if ls $CPPUPLOADS/*.[rR][tT][fF]  1> /dev/null 2>&1; then
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
	su_quant=$(ls -l $CPPUPLOADS/*.[rR][tT][fF] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $((CPQPDFLOTE-su_quantTratados)) ]; then
			su_quant=$((CPQPDFLOTE-su_quantTratados))							# limita quantidade de arquivos a transferir
    fi
	fMens	"$FInfor" "$MInfo58"		# mensagem informando do inicio tratamento arquivos RTF
	su_inodesList=$(ls -i $CPPUPLOADS/*.[rR][tT][fF] | awk '{print $1}' | tr '\n' ' ')
	#									mover certa quantidade de  arquivos RTF para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPWORK \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPPWORK -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPPWORK/*.[rR][tT][fF] 2>/dev/null)
	#									loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)		# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeRtf ]
		then
			fMens   "$FInsu2"       "$MErr40"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#									verificar ainda existência de arquivos RTF para serem tratados
	if ls $CPPWORK/*.[rR][tT][fF]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"       "$MInfo57"
		return							# nada a ser tratado: sem arquivos RTF novos
	fi
	#									loop para geração de PDFs
	su_arq=$(ls -1 $CPPWORK/*.[rR][tT][fF] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPPWORK/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f  $CPPWORK/$su_nomebaseSem.pdf
			fMens "$FInsu2" "$MErr35"
			fMens   "$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original RTF para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then
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
	if ls $CPPUPLOADS/*.[oO][dD][tT]  1> /dev/null 2>&1; then
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
	su_quant=$(ls -l $CPPUPLOADS/*.[oO][dD][tT] 2>/dev/null | grep  "^-"  -c)	# numero arquivos existentes
	if [ $su_quant -gt $((CPQPDFLOTE-su_quantTratados)) ]; then
			su_quant=$((CPQPDFLOTE-su_quantTratados))							# limita quantidade de arquivos a transferir
    fi
	fMens	"$FInfor" "$MInfo21"		# mensagem informando do inicio tratamento arquivos ODT
	su_inodesList=$(ls -i $CPPUPLOADS/*.[oO][dD][tT] | awk '{print $1}' | tr '\n' ' ')
	#									mover certa quantidade de  arquivos ODT para pasta de trabalho
	#									Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList				# transferir usando inode: arquivos podem ter nomes com caracteres de controle
	do
		find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPWORK \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPPWORK -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPPWORK/*.[oO][dD][tT] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)                                              # nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeOdt ]
		then
			fMens   "$FInsu2"       "$MErr39"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#									verificar ainda existência de arquivos ODT para serem tratados
	if ls $CPPWORK/*.[oO][dD][tT]  1> /dev/null 2>&1; then
			:
	else
		fMens   "$FInfor"       "$MInfo20"
		return                                                  # nada a ser tratado: sem arquivos ODT novos
	fi
	#
	#									loop para geração de PDF
	su_arq=$(ls -1 $CPPWORK/*.[oO][dD][tT] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"				# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPPWORK/$su_nomebaseSem $i  
		if [ $? -ne 0 ]; then
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f  $CPPWORK/$su_nomebaseSem.pdf
			fMens 	"$FInsu2" "$MErr36"
			fMens   "$FInsu3" "$su_nomebase"
		else
			fMens	"$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv $i $CPPRIMITIVO/$su_nomebase				# move o arquivo original ODT para pasta de já tratados
		fi 
	done
	#									verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then
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
	if ls $CPPUPLOADS/*.[tT][xX][tT]  1> /dev/null 2>&1; then
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
	su_quant=$(ls -l $CPPUPLOADS/*.[tT][xX][tT] 2>/dev/null | grep  "^-"  -c) 	# numero arquivos existentes
	if [ $su_quant -gt $((CPQPDFLOTE-su_quantTratados)) ]; then
			su_quant=$((CPQPDFLOTE-su_quantTratados))							# limita quantidade de arquivos a transferir
        fi
	fMens   "$FInfor" "$MInfo59"            # mensagem informando do inicio tratamento arquivos TXT
	#
	su_inodesList=$(ls -i $CPPUPLOADS/*.[tT][xX][tT] | awk '{print $1}' | tr '\n' ' ')
	#										mover certa quantidade de arquivos TXT para pasta de trabalho
	#										Os demais, ficarão para a próxima ativação deste script via cron
	for i in $su_inodesList					# transferir usando inode: arquivos podem ter seus nomes com caracteres de controle
	do
		find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPWORK \;  # mover um arquivo
		if [ $? -ne 0 ]; then
			su_arq=$(find $CPPUPLOADS -xdev -inum $i)
			fMens "$FInsu2" "$MErr08"
			fMens "$FInsu3" "$su_arq"
			find $CPPUPLOADS -type f -inum $i -exec mv -f {} $CPPQUARENTINE \;  # mover para quarentena
		fi
		j=$j+1
		if [ $j -eq $su_quant ]; then
			break
		fi
	done
	#										tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#										primeira limpeza ainda superficial, mas necessária para iniciar tratamento do arquivo
	find $CPPWORK -type f -print | while read su_arq;
	do su_fileClean=$( echo ${su_arq} | tr ", *#$@%()&'!" "-" );
		mv "$su_arq" "$su_fileClean" 2>/dev/null;
	done
	su_arq=$(ls -1 $CPPWORK/*.[tT][xX][tT] 2>/dev/null)	# loop para certificar-se do mime-type
	for i in $su_arq; do
		su_nomebase=$(basename $i)						# nome do arquivo, sem caminho
		su_tipo=$(file --mime-type -b $i)
		if [ $su_tipo != $su_mimeTxt ]
		then
			fMens   "$FInsu2"       "$MErr42"
			fMens   "$FInsu3"       "$su_nomebase"
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
		fi
	done
	#													verificar ainda existência de arquivos TXT para serem tratados
	if ls $CPPWORK/*.[tT][xX][tT]  1> /dev/null 2>&1; then
		:
	else
		fMens   "$FInfor"       "$MInfo23"
		return											# nada a ser tratado: sem arquivos TXT novos
	fi
	#													loop para geração de PDFs
	su_arq=$(ls -1 $CPPWORK/*.[tT][xX][tT] 2>/dev/null)
	for i in $su_arq; do
		su_nomebase=$(basename $i)									# nome do arquivo, sem caminho
		su_nomebaseSem="${su_nomebase%.*}"							# nome do arquivo, sem caminho e sem exensão
		unoconv -f pdf -d document -o $CPPWORK/$su_nomebaseSem $i
		if [ $? -ne 0 ]; then
			mv -f  $i $CPPQUARENTINE/$su_nomebase 2>/dev/null
			rm -f $CPPWORK/$su_nomebaseSem.pdf
			fMens "$FInsu2" "$MErr43"
			fMens "$FInsu3" "$su_nomebase"
		else
			fMens   "$FInfo2" "$MInfo50"
			fMens   "$FInfo1" "$(basename $i)"
			mv -f $i $CPPRIMITIVO/$su_nomebase			# move o arquivo original TXT para pasta de já tratados
		fi
	done
	#													verificar existência de arquivos PDF gerados para serem tratados
	if ls $CPPWORK/*.[pP][dD][fF]  1> /dev/null 2>&1; then
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
declare -a su_globi=""
fInit							# testes do ambiente e preparações iniciais
while [ ${#su_Funcoes[*]} -gt $su_pontFuncoes ]; do
	${su_Funcoes["$su_pontFuncoes"]}
	if [ $su_quantTratados -ge $CPQPDFLOTE ]; then
		fMens	"$FInfor"	"$MInfo22"				# máximo de arquivos tratados nesta ativação do script foi alcançado
		break
	fi
	let su_pontFuncoes=$su_pontFuncoes+1;
done
#													retirar, por segurança,  possíveis arquivos estranhos da pasta upload
for i in "${CPEXTAMPLAS[@]}";do su_globi=$su_globi:$CPPUPLOADS/*$i;done
GLOBIGNORE=$su_globi
mv -f $CPPUPLOADS/* $CPPQUARENTINE/. 2>/dev/null
unset GLOBIGNORE
#
#												resumo
fMens "$FInfo2" "$MInfo31"
fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$CPBASE'")"
if	[ $CPRELATORIOTABELAS ]; then
{
	exec 8< super_relatoriotabelas.csv  # associa lista_arquivos ao descritor 8
	while read arq <&8; do   # Lê uma linha de cada vez do descritor 3.
		arq=$(echo "$arq" | sed 's/\"//g')	# retira as aspas que rodeia os conteúdos de cada célula do arquivo csv
		fMens "$FInfo3" "$MInfo26 $arq= "
		fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM $arq") "
	done
	exec 8<&-  # libera descritor 8
}
else {
	TABLES=$(mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'show tables' | awk '{ print $1}' | grep -v '^Tables' );
	for arq in $TABLES
	do
		fMens "$FInfo3" "$MInfo26 $arq= "
		fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM $arq") "
	done
}
fi
fMens "$FInfo2" "$MInfo02"
fMens "$FInfo1" "$(ls -la $CPPQUARENTINE/ | grep -e "^-" | wc -l)"
fMens "$FInfo2" "$MInfo45"
fMens "$FInfo1" "$(ls -la $CPPUPLOADS/ | grep -e "^-" | wc -l)"
#
#								mensagem de fim do script com sucesso
fMens	"$FInfo2"	"$MInfo68"
#fMens	"$FInfo1"	"$(ps -A |grep soffice |cut -d " " -f 1,2)"
fMens	"$FInfo1"	"$(pgrep soffice)"
fMens	"$FSucss"	"$MInfo32"
fMens	"$FInfor"	"$MInfo09:  $(date '+%d-%m-%Y as  %H:%M:%S')"
#						Gerar arquivo de logs em html necessário a interface administrativa
rm -f $CPPLOG/$CPALOGHTML
cat $CPPLOG/super_logshell.log | aha -b > $CPPLOG/$CPALOGHTML
chmod $CPPERM640	$CPPLOG/$CPALOGHTML
#
#						compactar arquivo de log, se necessário
if	[ $(ls -l $CPPLOG/$CPALOG | awk '{ print $5}') -gt $CPMAXLOG ];then
	tar -zcf $CPPLOG/$CPLOGSFILEGZ  $CPPLOG/$CPALOG  2> /dev/null
	if [ $? -eq 0 ];then
		rm -f $CPPLOG/$CPALOG
		fMens	"$FSucss" "$MInfo46:  $(date '+%d-%m-%Y as  %H:%M:%S')"
		mv "$CPPLOG/$CPLOGSFILEGZ" "$CPPLOG/$(date '+%Y-%m-%d-%H-%M')$CPLOGSFILEGZ"
	else
		fMens	"$FInsuc" "$MErr26"
	fi
fi
exit	0

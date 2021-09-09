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
CPPINSTALL="su_install"					# nome da pasta de instalação
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
MErr04="Erro! Arquivo com comandos SQL para popular tabela de 'cidades' não foi encontrado"
MErr05="Erro! Não foi possível preparar pasta temporária de imagens de arquivos PDF: pasta temporária não pode ser limpa"
MErr06="Erro! Não foi possível preparar pasta temporária de imagens de arquivos PDF: pasta temporária não pode ser criada"
MErr07="Erro! Não foi possível se conectar com o banco de dados"
MErr08="Erro! Não foi possível mover os arquivos PDF a partir de sua pasta de uploads para a pasta de arquivos temporário"
MErr09="Erro! Pasta para upload de arquivos PDF não criada" 
MErr10="Interrompendo a execução do script"
MErr11="Erro! Pasta de imagens de arquivos PDF não encontrada"
MErr12="Não foi possível deixar os nomes dos arquivos em minúsculo"
MErr13="Erro! Problemas na geração dos arquivos TXT"
MErr14="Erro! Não foi possível gerar arquivo com as ocorrências dos nomes das cidades presentes nos arquivos TXT. Arquivos PDF deixados na pasta de quarentena"
MErr15="Erro! Não foi possível gerar arquivo de instruções SQL para popular tabela documentos_cidades. Arquivos PDF deixados na pasta de quarentena"
MErr16="Erro! Problemas na geração dos arquivos JPG"
MErr17="Erro! Não foi possível inserir informações nas tabelas: documentos, documentos_signatarios, documentos_instituicoes. Arquivos PDF deixados na pasta de quarentena"
MErr18="Erro! Não foi possível criar pasta de quarentena para arquivos PDF"
MErr19="Erro! Pasta de logs não existia e também não foi possível criá-la"
MErr20="Erro! Arquivo de configuração desta aplicação não foi encontrado"
MErr21="Erro! Problemas na cópia de arquivos PDF da pasta de upload para a pasta emporária de tratamento destes arquivos"
MErr22="Erro! Problemas na criação do script de comandos SQL para inserção de informações na base de dados. Arquivos PDF deixados na pasta de quarentena"
MErr23="Erro! Arquivo de logs não existe e não foi possível recriá-lo"
MErr24="Erro! Não foi possível inserir informações na tabela documentos_cidades"
MErr25="Erro! É necessário instalar o aplicativo 'detox' (apt-get install detox)"
MErr26="Erro! Não foi possível compactar arquivo de logs"
Merr27="Erro! Script periódico de incorporação de arquivos PDF ao acervo da Superinterface só pode ser chamado a partir da pasta 'su_install'"
MErr28="Erro! Arquivo com índice de numeração dos nomes dos arquivos PDF não foi encontrado"
MErr29="Erro! Índice encontrado para renomear nome dos arquivos não é um valor numérico"
#
#	mensagens de informação
MInfo01="Bem vindo ao script de tratamento de novos arquivos PDF em: "
MInfo02="Quantidade de arquivos na pasta de quarentena= "
MInfo03="Sucesso. Criada pasta temporária para tratamento de arquivos PDF" 
MInfo04="Sucesso. Geração de arquivo com instruções SQL realizada corretamente"
MInfo05="Sucesso. Informações inseridas corretamente na tabela documentos_cidades"
MInfo06="Aviso: pasta de logs não estava criada.  Criação foi realizada com sucesso"
MInfo07="Sucesso. Conexão com o banco de dados foi realizada corretamente"
MInfo08="Sucesso. Copiado os arquivos PDF para pasta temporária de tratamento de arquivos"
MInfo09="Script terminado as"
MInfo10="Existe(m) arquivo(s) PDF para ser(em) tratado(s)"
MInfo11="Renomeando os arquivos PDF e fazendo sua numeração"
MInfo12="Sucesso. Normalizado os nomes dos arquivos PDF"
MInfo13="Gerando arquivos TXT.  Pode demorar um pouco dependendo da quantidade de arquivos PDF existentes. Espere...."
MInfo14="Sucesso. Geração de arquivos TXT foi realizada corretamente"
MInfo15="Gerando arquivo com ocorrências de nomes de cidades presentes nos arquivos TXT. Pode demorar um pouco. Espere...."
MInfo16="Sucesso. Geração de arquivo de ocorrências de cidades foi realizada corretamente"
MInfo17="Sucesso. Geração de arquivo com instruções SQL para popular tabela documentos_cidades foi realizada corretamente"
MInfo18="Gerando arquivos JPG.  Pode demorar um pouco dependendo da quantidade de arquivos PDF existentes. Espere...."
MInfo19="Sucesso. Geração de arquivos JPG foi realizada corretamente"
MInfo20="Quantidade de arquivos PDF a serem tratados= "
MInfo21="Quantidade de arquivos TXT gerados= "
MInfo22="Quantidade de arquivos JPG gerados= "
MInfo23="Quantidade de arquivos com conteúdos sem caracteres controle e em caixa alta= "
MInfo24="Quantidade de entradas (linhas) no arquivo de ocorrências de cidades= "
MInfo25="Sucesso. Informações inseridas corretamente nas tabelas do banco de dados: documentos, documentos_signatarios e documentos_instituicoes"
MInfo26="Quantidade de registros na tabela 'documentos'= "
MInfo27="Quantidade de registros na tabela 'documentos signatários'= "
MInfo28="Quantidade de registros na tabela 'documentos instituições'= "
MInfo29="Quantidade de registros na tabela 'cidades'= "
MInfo30="Quantidade de registros na tabela 'documentos_cidades'= "
MInfo31="Quantidade de tabelas existentes na base= "
MInfo32="Sucesso. Fim do tratamento dos novos arquivos PDFs!"
MInfo33="Arquivo já existia na pasta de quarentena. Suspendendo o tratamento deste arquivo:  "
MInfo34="Movendo arquivo para pasta de quarentena pois ele já existe no repositório:  "
MInfo35="Detectado arquivo novo, ainda não incluído no repositório:  "
MInfo36="Aviso: estranho! Pasta de quarentena não encontrada no ambiente.  Fizemos sua recriação com sucesso"
MInfo37="Aviso: estranho! A pasta de logs não existia no ambiente. Fizemos a sua recriação"
MInfo38="Nada a ser tratado. Cancelando o script"
MInfo39="Aviso: estranho! O arquivo de logs não existia.  Fizamos sua recriação"
MInfo40="Alerta: notamos a falta do aplicativo cowsay. Mas ele não é obrigatório. Dica: assim que possível, instalar o cowsay  (apt-get install cowsay)"
MInfo41="Alerta: notamos a falta do aplicativo figlet. Mas ele não é obrigatório. Dica: assim que possível, instalar o figlet  (apt-get install figlet)"
MInfo42="Data:"
MInfo43="Iniciando o tratamento dos novos arquivos PDF"
MInfo44=".....Testando acesso ao arquivo de logs"
MInfo45="Quantidade de arquivos na pasta de uploads= "
MInfo46="Sucesso. Arquivo de logs compactado em: "
MInfo47="Movendo arquivo para pasta de quarentena pois ele apresentou problemas na sua estrutura:  "
MInfo48="Nenhum arquivo PDF para ser tratado neste momento"
#				  códigos das mensagens
FInfor=0        # saída normal: new line ao final, sem tratamento de cor
FInfo1=1        # saída normal: new line ao final, sem tratamento de cor e sem ..... (sem pontinhos ilustrativos)
FInfo2=2        # saída sem new line ao final, sem tratamento de cor
FSucss=3        # saída para indicação de sucesso: new line ao final da mensagem. na cor azul. No final, muda para cor branca
FSucs2=4        # saída para indicação de sucesso: new line antes e depois da mensagem, cor azul. No final, muda para cor branca
FInsuc=5        # saída para indicação de erro, na cor vermelha
FInsu1=6        # saída para indicação de erro, na cor vermelha (apenas no screen, não enviado para arquivo de log)
FCowsa=7        # saída para aplicativo cowsay
FFighl=8        # saída para aplicativo fighlet
FLinha=9		# saída de uma linha separadora para novo log
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
			$FInsuc)							# com lines feed antes e depois, aviso de interrupção do script, cor vermelha
				echo -e  "\n\e[31m.....$2" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
            	echo -e ".....$MErr10\e[97m" | tee -a "$CPLOG_DIR"/"$CPLOGSFILE"
            	;;
			$FInsu1)
				echo -e  "\n\e[31m.....$2"
				echo -e ".....$MErr10\e[97m"
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
#							FUNÇÃO PARA VERIFICAÇÃO DO AMBIENTE E PREPARAÇÃO DOS ARQUIVOS PDF, TXT E JPG					|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fInit () {
	#										verificar se é usuário root
	if [ "$EUID" -eq $CPROOT_UID ];  then 
    	fMens "$FInsu1" "$MErr01"
        exit
	fi
    #										verificar se pasta corrente é a de instalação
        if [ "${PWD##*/}" != "$CPPINSTALL" ]; then
                fMens "$FInsu1" "$MErr27"
                exit
        fi
	#										verificar se arquivo de configuração está disponível
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
		echo  -e "\n$MInfo44" >> "$CPLOG_DIR"/"$CPLOGSFILE"	# testando escrita no arquivo de logs 
		if [ $? -ne 0 ]; then
			fMens	"$FInsuc" "$MErr23"
			exit
		fi
		fMens	"$FInfor" "$MInfo39"
	fi
	chmod	$CPPERMARQUI $CPLOG_DIR"/"$CPLOGSFILE	# estabelecer permissão para arquivo de logs
	#	verifica existência de pasta de uploads de arquivos PDF
	if [ ! -d $CPUPLOADS ]; then
		fMens "$FInsuc" "$MErr09"
		exit
	fi
	chmod $CPPERMPADRAO $CPUPLOADS			# estabelecer permissão para a pasta de uploads
	#										verificar existência de arquivos PDF para serem tratados
	if ls $CPUPLOADS/*.[pP][dD][fF]  1> /dev/null 2>&1; then
		:
	else
		exit 0								# nada a ser tratado: sem arquivos PDF novos
	fi
	#										linha separadora do log anterior
	fMens	"$FLinha"	""
	fMens	"$FInfor" "$MInfo10"			# mensagem que existem novos arquivos PDF a serem tratados
	#										verificar se aplicativo detox está instalado
	if [ -n "$(dpkg --get-selections | grep detox | sed '/deinstall/d')" ]; then
	:
	else
		fMens "$FInsuc" "$MErr25"
		exit
	fi
	#												verificar se aplicativo figlet está instalado
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
	#										verificar se aplicativo cowsay está instalado
	if [ -n  "$(dpkg --get-selections | grep cowsay | sed '/deinstall/d')" ]; then
		fMens "$FCowsa"  "$CPNOMECOWSAY1"
	else
		fMens "$FInfor" "$MInfo40"
	fi
	chmod $CPPERMFIXOS      super_cowsay1.txt	# estabelecer permissão para o arquivo de mensagens cowsay	
	chmod $CPPERMFIXOS $CPPADMIN/$CPNOMECIDADES
	#											verificar existência arquivo contendo nomes das cidades (em letras maiúsculas)
    if [ ! -f $CPPADMIN/$CPNOMECIDADES ]; then
		fMens "$FInsuc" "$MErr03"
        exit
	fi
    chmod $CPPERMFIXOS $CPPADMIN/$CPNOMECIDADES
    #										verificar existência de arquivo com comandos SQL para inserção dados na tabela 'cidades'
    if [ ! -f $CPINSERECIDADES ]; then
		fMens "$FInsuc" "$MErr04"
		exit
    fi
	chmod $CPPERMFIXOS $CPINSERECIDADES
	#										verificar existência de pasta de imagens de arquivos PDF
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
   	#									verificar existência de pasta de quarentena de arquivos PDF
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
	#												testar conexão com o banco de dados
    mysql -u $CPBASEUSER -b $CPBASE -p$CPBASEPASSW -e "quit" 2>/dev/null
	if [ $? -ne 0 ]; then
    	fMens "$FInsuc" "$MErr07"
		exit
    else
			fMens "$FSucss" "$MInfo07"
	fi
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							PREPARAR AS ROTINAS PARA INSERÇÃO DE INFORMAÇÕES NA BASE DE DADOS								|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fParq () {
	#									tirar apostrofo (e outros caracteres especiais) presentes no nome dos arquivos
	#									primeira limpeza ainda superficial, mas necessária para iniciar tratamento dos PDF
	find $CPUPLOADS -type f -print | while read file;
	do file_clean=$( echo ${file} | tr ", ()&'!" "-" );
		mv "$file" "$file_clean";
	done
    #									mover certa quantidade de  arquivos PDF para pasta de trabalho conforme configuração
	#									os demais, ficarão para a próxima ativação deste script via cron
	su_arq=$(ls -1 $CPUPLOADS/*.[pP][dD][fF] | head -$CPQPDFLOTE)
	for i in $su_arq; do
		mv $CPUPLOADS/$i $CPTEMP/. 2>/dev/null
		if [ $? -ne 0 ]; then
			mv -f  $CPTEMP/* $CPQUARENTINE/. 2>/dev/null  
			fMens "$FInsuc" "$MErr08"
			exit 1
		else
			fMens	"$FSucss" "$MInfo08"

		fi      
	done
	#                               verificar se há corrupção dos arquivos PDF
	for i in "$CPTEMP"/*.[pP][dD][fF]; do
		pdfinfo "$i" &>/dev/null
		if [ ! $? -eq 0 ]; then
			mv -f $i "$CPQUARENTINE"/.
			fMens   "$FInfor"       "$MInfo47 $(basename $i)"
		fi
	done
	#                               verificar se ainda há arquivos PDF a serem tratados
	su_qpdf=$(ls -la $CPTEMP/*.[pP][dD][fF] 2>/dev/null | grep -e "^-" | wc -l) 2>/dev/null
	if [ $su_qpdf -eq 0 ]; then
		fMens   "$FInfor"       "$MInfo48"
		fMens	"$FInfor"	"$MInfo38"	# nada a tratar
		exit
	fi
	#									retirar caracteres especiais dos nomes dos arquivos PDF
	detox $CPTEMP/*.[Pp][Dd][Ff]
	if [ $? -ne 0 ]; then
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		fMens "$FInsuc" "$MErr02"
		exit
	fi
	#									modificar nomes dos arquivos PDF para minúsculo
	detox -s lower-only $CPTEMP/*.[Pp][Dd][Ff]
	if [ $? -ne 0 ]; then
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		fMens "$FInsuc" "$MErr12"
		exit
	fi
	#									renomear, se configurado assim, arquivos PDF? (reduzindo tamanho do nome e numera-los)
	if [ $CPNUMERARPDF -ne 0 ]; then
	    #   renomear
		fMens   "$FInfor"	"$MInfo11"
		if [ ! -f $CPPADMIN/$CPINDICEPDF ]; then
			mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
			fMens "$FInsuc" "$MErr28"		# arquivo não encontrado 
			exit
		fi
	su_cont=$(cat $CPPADMIN/$CPINDICEPDF)
	if (echo $su_cont | egrep '[^0-9]' &> /dev/null) then
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		fMens	"$FInsuc" "$MErr29"			# valor encontrado não é numérico
		exit
	fi
	for i in $CPTEMP/*.pdf;do ttt=$(basename $i); ttt=${ttt%.*}; mv -i "$i" "$CPTEMP/super${su_cont}_${ttt:0:$CPMAX}.pdf"; let su_cont++; done
		if [ $? -eq 0 ]; then
			fMens "$FSucss" "$MInfo12"
			echo $su_cont > $CPPADMIN/$CPINDICEPDF		# atualiza valor do contador no arquivo
		else
			mv -f $CPTEMP/*.pdf "$CPQUARENTINE"/.		# deixar os arquivos PDF na quarentena para posterior análise
			fMens "$FInsuc" "$MErr12"
			exit
		fi
	fi
	#									verificar se os arquivos já estão na pasta de quarentena
	for i in $CPTEMP/*.pdf; do
		su_base=$(basename $i)			# nome do arquivo com extensão, e sem caminho (path)
		if [ -f $CPQUARENTINE/$su_base ]; then
			#							arquivo já está colocado em quarentena
			fMens	"$FInfor"	"$MInfo33 $su_base"
			rm -f $i					# suspender o tratamento do arquivo.  Conservar ele na pasta de quarentena
		fi
	done
	#									verificar se ainda existem arquivos PDF para serem tratados
	if [ ! "$(ls -A $CPTEMP)" ]; then
			fMens	"$FInfor"	"$MInfo38"
			exit
	fi
	#									verificar se os arquivos já estão no acervo (referenciados na base de dados)
	for i in $CPTEMP/*.pdf; do
		su_base=$(basename $i)			# nome do arquivo com extensão, e sem caminho (path)
		su_info="${su_base%.*}"			# nome do arquivo sem extensão
		if [ -f $CPIMAGEM/$su_base ]; then
			#							arquivo já existe no repositório
			fMens	"$FInfo2"	"$MInfo34"
			fMens	"$FInfo1"	"$su_base"
			mv -f $i $CPQUARENTINE/.
			rm -f $CPTEMP/$su_info*.txt
			rm -f $CPTEMP/$su_info*.maiuscula
			rm -f $CPTEMP/$su_info*.jpg
		else
			fMens	"$FInfo2"	"$MInfo35"	# arquivo para ser tratado.  Não existe no repositório
			fMens	"$FInfo1"	"$su_base"
		fi
	done
	#										verificar se sobrou algum arquivo pdf a ser tratado
	if ls $CPTEMP/*.[pP][dD][fF]  1> /dev/null 2>&1; then
    	fMens	"$FInfor" "$MInfo10"
	else
    	fMens	"$FSucss" "$MInfo38"
		exit
	fi
	#										gerar arquivos TXT a partir de arquivos PDF
	fMens "$FInfor" "$MInfo13"
	ls $CPTEMP/*.pdf | awk '{printf "pdftotext  -layout "$1; gsub(/\.pdf/,".txt",$1); print " "$1}' > super_gera_novospdf_txt.bash 2>/dev/null
	chmod 744 super_gera_novospdf_txt.bash 2>/dev/null
	bash super_gera_novospdf_txt.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr13"
		rm -f super_gera_novospdf_txt.bash
		exit
	fi
	rm -f super_gera_novospdf_txt.bash
	#										gerar arquivos TXT com nomes sem acentuação, em letras maiúsculas e sem caracteres controle
	for i in "$CPTEMP"/*.txt
	do
		sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' $i > $i"."$CPACENTO
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
	rm "$CPTEMP"/*.$CPCONTRL "$CPTEMP"/*.contrl4 "$CPTEMP"/*.$CPACENTO 2> /dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo14"
	else
		fMens "$FInsuc" "$MErr13"
		exit
	fi
	#										gerar arquivos JPG a partir de arquivos PDF
	fMens   "$FInfor" "$MInfo18"
	ls $CPTEMP/*.pdf | awk '{printf "convert "$1"[0]"; gsub(/\.pdf/,"_pagina1.jpg",$1); print " "$1}' > super_gera_jpg_novospdf.bash 2>/dev/null
	chmod 744 super_gera_jpg_novospdf.bash 2>/dev/null
	bash super_gera_jpg_novospdf.bash 2>/dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo19"
		rm -f super_gera_jpg_novospdf.bash
	else
		fMens "$FInsuc" "$MErr16"
		rm -f super_gera_jpg_novospdf.bash
		exit
	fi
	#												gerar arquivo com ocorrências das cidades nos arquivos TXT
	fMens "$FInfor" "$MInfo15"
	cat $CPPADMIN/$CPNOMECIDADES | sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' | awk 'BEGIN{FS=","}{print "grep -Howi \""$1"\" '$CPTEMP'/*.txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA' | awk '\''BEGIN{FS=\":\"}{print $2\", \"$1}'\'' | sort | uniq -c | sed '\''s/\\, /\\,/g'\'' | sed '\''s/   /  /g'\''| sed '\''s/  / /g'\'' | sed '\''s/  //g'\'' | awk '\''{guarda=$1; $1=\"\"; print $0\",\"guarda;}'\''"}' > $CPPADMIN/super_temp_executa_conta_ocorrencias_novospdf.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		fMens "$FInsuc" "$MErr14"
		exit
	fi
	bash $CPPADMIN/super_temp_executa_conta_ocorrencias_novospdf.bash > $CPPADMIN/super_temp_tabela_ocorrencias_novospdf.txt 2> /dev/null
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo16"
		rm $CPPADMIN/super_temp_executa_conta_ocorrencias_novospdf.bash
	else
		rm -f $CPPADMIN/super_temp_executa_conta_ocorrencias_novospdf.bash $CPPADMIN/super_temp_tabela_ocorrencias_novospdf.txt 
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		fMens "$FInsuc" "$MErr14"
		exit
	fi
	#												gerar arquivo de instruções SQL para popular tabela documentos_cidades
	cat $CPPADMIN/super_temp_tabela_ocorrencias_novospdf.txt | sed 's/txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA'/pdf/g' | awk 'BEGIN{FS=","}{gsub(/^ /,"",$1);print "insert into documentos_cidades (id_cidade, id_documento, ocorrencia) values ((select id_chave_cidade from cidades where cidade_sem_acentuacao=\""$1"\" limit 1),(select id_chave_documento from documentos where photo_filename_documento like \""$2"\" limit 1),"$3");"}' > $CPPADMIN/super_temp_executa_sql_das_ocorrencias_novospdf.sql
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr15"
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		rm -f $CPPADMIN/super_temp_executa_sql_das_ocorrencias_novospdf.sql $CPPADMIN/super_temp_tabela_ocorrencias_novospdf.txt 
		exit
	fi
	#												trocar indicação de pastas: de temporária para a pasta definitiva de imagens
	sed "s#$CPTEMP#$CPIMAGEM#g" -i $CPPADMIN/super_temp_executa_sql_das_ocorrencias_novospdf.sql
	if [ $? -eq 0 ]; then
			fMens "$FSucss" "$MInfo17"
	else
		fMens "$FInsuc" "$MErr15"
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		rm -f $CPPADMIN/super_temp_executa_sql_das_ocorrencias_novospdf.sql $CPPADMIN/super_temp_tabela_ocorrencias_novospdf.txt 
		exit
	fi
	#												Resumo dos resultados até aqui
	fMens "$FInfo2" "$MInfo20"
	fMens "$FInfo1" "$(ls -la $CPTEMP/*.pdf | grep -e "^-" | wc -l)"
	fMens "$FInfo2" "$MInfo21"
	fMens "$FInfo1" "$(ls -la $CPTEMP/*.txt | grep -e "^-" | wc -l)"
	fMens "$FInfo2" "$MInfo22"
	fMens "$FInfo1" "$(ls -la $CPTEMP/*.jpg | grep -e "^-" | wc -l)"
	fMens "$FInfo2" "$MInfo23"
	fMens "$FInfo1" "$(ls -la $CPTEMP/*.$CPMAIUSCULA | grep -e "^-" | wc -l)"
	fMens "$FInfo2" "$MInfo02"
	fMens "$FInfo1" "$(ls -la $CPQUARENTINE/ | grep -e "^-" | wc -l)"
	fMens "$FInfo2" "$MInfo24"
	fMens "$FInfo1" "$(wc -l < $CPPADMIN/super_temp_tabela_ocorrencias_novospdf.txt)"
	rm -f $CPPADMIN/super_temp_tabela_ocorrencias_novospdf.txt
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#																															|
#							              INSERIR INFORMAÇÕES NA BASE DE DADOS												|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
#
function fInse () {
	#												inserir dados nas tabelas:
	find $CPTEMP/*.pdf | grep -i pdf | sed $'s/\//\t\t /g' | awk '{guarda=$NF; printf "insert into documentos (photo_filename_documento, alt_foto_jpg, nome_documento) values (\"../su_imagens/"$NF"\",";gsub(/\.pdf/,"", $NF); printf "\"../su_imagens/"$NF"_pagina1.jpg\",\"" ; gsub(/-/," ",$NF); gsub(/_/," ",$NF); print $NF"\");"; out=""; print "insert into documentos_signatarios (id_signatario, id_documento) values ((select id_chave_registrado from registrados where nome_registrado like \"signatário indefinido\"),(select id_chave_documento from documentos where photo_filename_documento=\"../su_imagens/"guarda"\"));"; print "insert into documentos_instituicoes (id_instituicao, id_documento) values ((select id_chave_instituicao from instituicoes where nome_instituicao like \"Instituição Indefinida\"),(select id_chave_documento from documentos where photo_filename_documento=\"../su_imagens/"guarda"\"));"}' > $CPPADMIN/temp_super_documentos_novospdf.sql 	
	if [ $? -eq 0 ]; then
			fMens "$FSucss" "$MInfo04"
	else
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		fMens "$FInsuc" "$MErr22"
		exit
	fi
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPPADMIN/temp_super_documentos_novospdf.sql"
	if [ $? -eq 0 ]; then
		mv -f $CPTEMP/*.* $CPIMAGEM/.
		rm -f $CPPADMIN/temp_super_documentos_novospdf.sql
		fMens "$FSucss" "$MInfo25"
	else
		mv -f $CPTEMP/*.pdf $CPQUARENTINE/.			# deixar os arquivos PDF na quarentena para posterior análise
		rm -f $CPTEMP/*.*
		rm -f $CPPADMIN/temp_super_documentos_novospdf.sql 
		fMens "$FInsuc" "$MErr17"
		exit
	fi
	#												inserir dados das ocorrências de nomes de cidades presentes nos arquivos
	#												TXT na tabela documentos_cidades
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE 2>/dev/null < $CPPADMIN/super_temp_executa_sql_das_ocorrencias_novospdf.sql
   	if [ $? -eq 0 ]; then
   		fMens "$FSucss" "$MInfo05"
   		rm -f $CPPADMIN/super_temp_executa_sql_das_ocorrencias_novospdf.sql 
   	else
   		fMens "$FInsuc" "$MErr24"
   		rm -f $CPPADMIN/super_temp_executa_sql_das_ocorrencias_novospdf.sql 
   		exit
   	fi
	#												resumo
	fMens "$FInfo2" "$MInfo31"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$CPBASE'")"
	fMens "$FInfo2" "$MInfo26"
	#su_info=$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos")
	#echo $su_info
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos")"
	fMens "$FInfo2" "$MInfo27"
	#su_info=$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos_signatarios")
	#echo $su_info
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos_signatarios") "
	fMens "$FInfo2" "$MInfo28"
	#su_info=$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos_instituicoes")
	#echo $su_info
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos_instituicoes")"
	fMens "$FInfo2" "$MInfo29"
	#su_info=$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM cidades")
	#echo $su_info
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM cidades") "
	fMens "$FInfo2" "$MInfo30"
	#su_info=$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos_cidades")
	#echo $su_info
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM documentos_cidades") "
	fMens "$FInfo2" "$MInfo02"
	fMens "$FInfo1" "$(ls -la $CPQUARENTINE/ | grep -e "^-" | wc -l)"
	fMens "$FInfo2" "$MInfo45"
	fMens "$FInfo1" "$(ls -la $CPUPLOADS/ | grep -e "^-" | wc -l)"
}	# fim da rotina de inserção de dados nas tabelas do mysql
#
fInit							# testes do ambiente e preparações iniciais
fParq							# preparar os arquivos PDF
fInse							# insere dados nas tabelas do mysql
#								compactar arquivo de log, se necessário
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

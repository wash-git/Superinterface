#!/bin/bash
#
# --------------------------------------------------------------------------------------------------------------------------+
# 																															|
#			                    						CONFIGURAÇÕES														|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
CPCONFIG="super_config.cnf"	# arquivo de configuração
CPROOT_UID=0				# root ID
CPPINSTALL="su_install"		# nome da pasta de instalação
# --------------------------------------------------------------------------------------------------------------------------+
# 																															|
#			                  						  MENSAGENS DO SCRIPT													|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
MErr01="Erro! Não foi possível preparar pasta para servir de acervo dos arquivos PDF"
MErr02="Interrompendo a execução do script"
MErr03="Erro! Não foi possível criar pasta de imagens de arquivos PDF"
MErr04="Erro! É necessário instalar o aplicativo 'aha' conforme manual de instalação"
MErr05="Erro! Não é permitido executar este script como usuário root"
MErr06="Erro! Não foi possível gerar arquivo auxiliar de nomes de cidades do Brasil"
MErr07="Erro! Não foi possível criar arquivo para guardar índice de numeração dos nomes dos arquivos PDF"
MErr08="Erro! Não foi possível se conectar com o banco de dados"
MErr09="Erro! Base de dados não existe. Faça primeiro a criação do banco de dados e de seu usuário de acesso"
MErr10="Erro! Houve problemas no script de geração automática de código PHP" 
MErr11="Erro! Não foi possível criar usuário/senha do administrador" 
MErr12="Erro! Não foi possível limpar as tabelas do banco de dados"
MErr13="Erro! Não foi possível criar tabelas no banco de dados"
MErr14="Erro! Não foi possível inserir comentário na tabela de usuários"
MErr15="Erro! Não foi possível apagar alguns arquivos antigos"
MErr16="Erro! Não foi possível se conectar com a base de dados legada"
MErr17="Erro! Arquivo SHELL do usuário retornou com código de erro= "
MErr18="Erro! Não foi possível preparar pasta de arquivos originais não PDF: a pasta não pode ser criada"
MErr19="Erro! Não foi possível preparar pasta de trabalho: a pasta não pode ser criada"
MErr20="Erro! Pasta Administrativa não foi encontrada"
MErr21="Erro! Aplicativo 'unoconv' instalado mas não respondendo. Pare o processo do 'unoconv' (via comando 'kill') para que o mesmo possa ser reiniciado"
MErr22="Erro! Não foi possível configurar corretamente os privilégios dos usuários"
MErr23="Erro! Não foi encontrado o arquivo de configuração"
MErr24="Erro! Não foi possível criar tabela de usuários"
MErr25="Erro! Não foi encontrado o arquivo com comandos SQL para criação das tabelas da Superinterface"
MErr26="Erro! Não foi possível preparar as pastas necessárias à aplicação Superinterface"
MErr27="Erro! Não foi possível preparar pasta de logs: a pasta não pode ser criada"
MErr28="Erro! É necessário ter instalado o aplicativo 'unoconv', conforme manual de instalação"
MErr29="Erro! Não foi possível preparar pasta de quarentena: a pasta não pode ser criada"
MErr30="Erro! Não foi possível preparar pasta de upload para novos arquivos"
MErr31="Erro! Não foi possível criar pasta de uploads para novos arquivos"
MErr32="Erro! É necessário ter instalado o aplicativo 'detox' (apt-get install detox)"
MErr33="Erro! Não foi possível gerar o arquivo de configuração para as rotinas PHP"
MErr34="Erro! Não foi encontrado arquivo com a lista de tabelas para constar no relatório resumo"
MErr35="Erro! Não foi possível criar pasta para arquivos PHP que viriam a ser automaticamente gerados"
MErr36="Erro! Para instalar a Superinterface é obrigatório estar na pasta 'su_install'"
MErr37="Erro! Não foi possível criar pasta de arquivos temporários"
MErr38="Erro! Não foi possível transferir informações deste arquivo SQL para base de dados: " 
MErr39="Erro! Não foi possível gerar arquivo auxiliar de nomes de instituições"
MErr40="Erro! Não foi possível transferir informações deste arquivo CSV para base de dados: "
MErr41="Erro! Pasta de arquivos javascript não foi encontrada"
#
MInfo01="Preparar as pastas"
MInfo02="Sucesso! Criada pasta do acervo de arquivos PDF da Superinterface"
MInfo03="Sucesso! Pasta administrativa preparada"
MInfo04="Geração automática de código PHP:"
MInfo05="Aproveite e dê uma olhadinha nos códigos PHP gerados automaticamente na pasta: "
MInfo06="Sucesso! Criada pasta de uploads para novos arquivos"
MInfo07="Resumo da Instalação, iniciando pelos parâmetros do ambiente:"
MInfo08="Iniciando a instalação"
MInfo09="Sucesso! Conexão com o banco de dados foi realizada corretamente"
MInfo10="Aproveite e dê uma olhadinha no log da instalação da Superinterface que está no arquivo: "
MInfo11="Aproveite e dê uma olhadinha nas estruturas das tabelas criadas através da opção 'Tabelas' da interface administrativa"
MInfo12="Sucesso! Criado usuário/senha da interface de administração da Superinterface"
MInfo13="Fazer inserção de dados nas tabelas a partir de arquivos CSV e arquivos SQL fornecidos"
MInfo14="Sucesso! Arquivo opcional SHELL do usuário executado corretamente"
MInfo15="Aviso: nenhum arquivo SQL fornecido pelo usuário foi encontrado"
MInfo16="Sucesso! Possíveis tabelas remanescentes no banco de dados foram eliminadas"
MInfo17="Sucesso! Tabelas do banco de dados (re)criadas corretamente"
MInfo18="Quantidade de tabelas geradas= "
MInfo19="Preparar tabelas do banco de dados"
MInfo20="Aviso: não foi encontrado arquivo opcional SHELL para tratamento de dados"
MInfo21="Aviso: arquivo opcional SHELL do usuário para tratamento de dados foi encontrado. Executando...."
MInfo22="super_install.sh"
MInfo23="Sucesso! Criada pasta de arquivos originais não PDF"
MInfo24="Sucesso! Criada pasta de quarentena"
MInfo25="Sucesso! Criada pasta de tratamento de arquivos submetidos ao acervo (work)"
#MInfo26=""
#MInfo27=""
#MInfo28=""
#MInfo29=""
#MInfo30=""
#MInfo31=""
#MInfo32=""
#MInfo33=""
#MInfo34=""
#MInfo35=""
#MInfo36=""
#MInfo37=""
#MInfo38=""
#MInfo39=""
#MInfo40=""
MInfo41="Bem vind@ ao script de instalação da Superinterface em:   "
MInfo42="PID do processo 'unoconv (soffice)' em uso= "
MInfo43="Parabéns!!!   A instalação da Superinterface foi um sucesso!"
MInfo44="Sucesso! Criada pasta de arquivos de logs"
MInfo45="Data:"
MInfo46="Script terminado em"
MInfo47="Alerta: notamos a falta do aplicativo cowsay. Ele não é obrigatório. Dica: assim que possível, instalar o cowsay  (apt-get install cowsay)"
MInfo48="Alerta: notamos a falta do aplicativo figlet. Ele não é obrigatório. Dica: assim que possível, instalar o figlet  (apt-get install figlet)"
MInfo49="Sucesso! Criada pasta para arquivos temporários"
MInfo50="Aviso: nenhum arquivo PDF será tratado nesta instalação. A incorporação de arquivos ao acervo da Superinterface ocorrerá quando o script ativado via cron for executado"
MInfo51="Sucesso! Criada pasta para guardar os arquivos PHP gerados automaticamente nesta instalação"
MInfo52="Sucesso! Arquivo SQL transferido para base de dados: "
MInfo53="Quantidade de registros na tabela "
MInfo54="Sucesso! Arquivo CSV transferido para base de dados: "
#
FInfor=0	# saída normal: new line ao final, sem tratamento de cor, pontinhos no início (.....)
FInfo1=1	# saída normal: new line ao final, sem tratamento de cor e sem pontinhos no início
FInfo2=2	# saída sem new line ao final, sem tratamento de cor
FInfo3=3	# saída normal: new line ao final, sem tratamento de cor, espaços em branco no inicio (     )
FInfo4=4	# saída sem new line ao final, sem tratamento de cor, espaços em branco no início (     )
FSucss=5	# saída para indicação de sucesso: new line ao final da mensagem. na cor azul. No final, muda para cor branca
FSucs2=6	# saída para indicação de sucesso: new line antes e depois da mensagem, cor azul. No final, muda para cor branca
FSucs3=7	# saída para indicação de sucesso: sem new line ao final, cor azul.
FSucs4=8	# saída para indicação de sucesso: sem pontinhos no início, cor azul, e new line ao final.
FInsuc=9	# saída para indicação de erro, na cor vermelha
FInsu1=10	# saída para indicação de erro, na cor vermelha (apenas no screen, não enviado para arquivo de log)
FInsu2=11	# saída para indicação de erro, sem line feed ao final, cor vermelha
FInsu3=12	# saída para indicação de erro, com line feed ao final, cor vermelha, ao final volta cor default
FCowsa=13	# saída para aplicativo cowsay
FFighl=14	# saída para aplicativo fighlet
#
MCor01="\e[97m"		# cor default (branca), quando for enviar mensagens
MCor02="\e[33m"		# cor amarela, quando for enviar mensagens
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   				   	          FUNÇÃO PARA ENVIO DE MENSAGENS AO USUÁRIO											|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fMens () {
	case $1 in
		$FInfor)
			echo -e ".....$2" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInfo1)
			echo -e "$2" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInfo2)
			echo -n ".....$2" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInfo3)
			echo -e "     $2" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInfo4)
			echo -n "     $2" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FSucss)
			echo -e "\e[34m.....$2\e[97m" | tee -aa "$CPPLOG"/"$CPALOG"
			;;
		$FSucs2)
			echo -e "\n\e[34m.....$2\e[97m" | tee -aa "$CPPLOG"/"$CPALOG"
			;;
		$FSucs3)								# sem line feed ao final, cor azul
			echo -ne "\e[34m.....$2" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FSucs4)								# com line feed ao final, cor azul, ao final volta cor default
			echo -e "\e[34m$2\e[97m"	| tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInsuc)
			echo -e  "\n\e[31m.....$2"	| tee -a "$CPPLOG"/"$CPALOG"
			echo -e ".....$MErr02\e[97m" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInsu1)
			echo -e  "\n\e[31m.....$2"
			echo -e ".....$MErr02\e[97m"
			;;
		$FInsu2)								# sem line feed ao final, cor vermelha
			echo -ne "\e[31m.....$2" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInsu3)                            	# com line feed ao final, cor vermelha, ao final volta cor default
			echo -e "\e[31m$2\e[97m"  | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FCowsa)
			shuf -n 1 $2 | cowsay -p -W 50 | tee -aa "$CPPLOG"/"$CPALOG"
			;;
		$FFighl)
			figlet -f standard -k -t -c -p -w 120  "
--------------
Superinterface
--------------" | tee -aa "$CPPLOG"/"$CPALOG"
			;;
		*)
			echo "\e[31m.....OOOooops!\e[97m" | tee -a "$CPPLOG"/"$CPALOG"
			echo $1 | tee -a "$CPPLOG"/"$CPALOG"
			exit
			;;
	esac
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   			FUNÇÃO PARA VERIFICAÇÃO DO AMBIENTE E PREPARAÇÃO DOS ARQUIVOS PDF, TXT E JPG						|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fInit () {
: '
		Consistências iniciais (principais):
		C01: verificar se o usuário é root
		C02: verificar se a pasta corrente é a de instalação
		C03: verificar existência de arquivo de configuração
		C04: limpar pasta de administração
		C05: limpar pasta de logs, de acervo, de uploads e outras
		C06: verificar criação de pasta de logs
		C07: verificar se aplicativo unoconv está instalado
		C08: verificar se aplicativo detox   está instalado
		C09: verificar se aplicativo figlet  está instalado
		C10: verificar se aplicativo cowsay está instalado
		C11: verificar se aplicativo aha    está instalado
		C12: verificar criação de arquivo de configuração para o PHP
		C13: verificar existência arquivo com comandos SQL criação de tabelas
		C14: verificar existência de arquivo com indicação das tabelas a constarem no relatório resumo
		C15: verificar criação de pasta do acervo (imagens de arquivos PDF)
		C16: verificar criação de pasta para uploads de arquivos
		C17: verificar criação de pasta de trabalho
		C18: verificar criação de pasta para arquivos originais não PDF
		C19: verificar criação de pasta de quarentena
		C20: verificar criação de pasta arquivos PHP gerados automaticamente
		C21: verificar criação de pasta arquivos temporários
		C22: verificar existência de pasta administrativa da Superinterface
		C23: verificar existência de pasta de arquivos javascript
		C24: verificar criação arquivo índice numeração de nomes arquivos PDF
		C25: definir permissões de acesso a pastas e arquivos
		C26: verificar a conexão com o banco de dados
		C27: verificar se base de dados está limpa e apagar possíveis tabelas existentes
		C28: verificar criação das tabelas da Superinterface
		C29: verificar a criação de usuário administrador
        --------        --------        --------  
'
#
	clear
	#											TTT C01: verificar se é usuário root
	if [ "$EUID" -eq $CPROOT_UID ];  then 
		fMens "$FInsu1" "$MErr05"
		exit
	fi
	#											TTT C02: verificar se pasta corrente é a de instalação
	if [ "${PWD##*/}" != "$CPPINSTALL" ]; then
		fMens "$FInsu1" "$MErr36"
		exit
	fi
	#											TTT C03: verificar se arquivo de configuração está disponível
	if [ ! -f $CPCONFIG ]; then
		fMens "$FInsu1" "$MErr23"
		exit
	fi
	#											limpeza do ambiente de instalação
	#find ../ -type d -not -name su* -not -name .. -exec rm -r {} \
	source  $CPCONFIG							# inserir arquivo de configuração
	#											TTT C04: limpar pasta de administração
	#											apagar possíveis arquivos anteriores para gerar novas versões:
	# 											configuração do PHP,bloqueio do script ativado pelo cron
	rm	-f	{$CPPADMIN/$CPPHPFILE,$CPPADMIN/$CPNOMENOVOS".lock"}
	if [ $? -ne 0 ]; then
 		fMens "$FInsu1" "$MErr15"
 		exit
	fi
	#											TTT C05: limpar pasta de logs, do acervo, de uploads,				
	# 											de rascunho, quarentena, primitivo, autoPHP
	rm -rf {$CPPLOG,$CPPIMAGEM,$CPPUPLOADS,$CPPWORK,$CPPQUARENTINE,$CPPRIMITIVO,$CPPAUTOPHP}  2>/dev/null
	if [ $? -ne 0 ]; then
 		fMens "$FInsu1" "$MErr26"
 		exit
	fi
	#											TTT C06: verificar criação de pasta de logs
	mkdir $CPPLOG					
	if [ $? -ne 0 ]; then
 		fMens "$FInsu1" "$MErr27"
 		exit
	fi
	fMens "$FSucss" "$MInfo44"					# sucesso na criação de pasta de logs
	#											veriricar criação de arquivo de logs
	echo "--- Arquivo de LOG criado ---" > $CPPLOG/$CPALOG
	#											TTT C07: verificar se aplicativo unoconv está instalado
	#                                       	(necessário para conversão .docx -> .pdf)
	if [ -n "$(dpkg --get-selections | grep unoconv | sed '/deinstall/d')" ]; then
		pidsoffice="$(pgrep soffice)" 
		if [ $? -ne 0 ];then
			fMens "$FInsuc" "$MErr21"
			exit
		fi
	else
		fMens "$FInsuc" "$MErr28"
		exit
	fi
	#         
	#											TTT C08: verificar se aplicativo detox está instalado
	if [ -n "$(dpkg --get-selections | grep detox | sed '/deinstall/d')" ]; then
		:
	else
		fMens "$FInsuc" "$MErr32"
		exit
	fi
	#											TTT C09: verificar se aplicativo figlet está instalado
	if [ -n "$(dpkg --get-selections | grep figlet | sed '/deinstall/d')" ]; then
		fMens "$FInfo1" "$MCor02"				# saída na cor amarela 
		fMens "$FFighl"
	else
		fMens "$FInfor" "$MInfo48"	
	fi
	fMens "$FInfo1" "$MCor02"					# saída na cor amarela 
	fMens "$FInfo2"	"$MInfo41"					# enviar mensagem de boas vindas
	fMens "$FInfo1"	"$MInfo22"					# $0
	fMens "$FInfor" "$MInfo45:  $(date '+%d-%m-%Y as  %H:%M:%S') --- $MInfo08"
	fMens "$FInfo1" "$MCor01"
	#											TTT C10: verificar se aplicativo cowsay está instalado
	if [ -n  "$(dpkg --get-selections | grep cowsay | sed '/deinstall/d')" ]; then
		fMens "$FCowsa"  "$CPNOMECOWSAY1"
	else
		fMens "$FInfor" "$MInfo47"
	fi
	#											TTT C11: verificar se aplicativo aha está instalado
	#											(necessário para geração html de arquivo de logs)
	if [ -n "$(dpkg --get-selections | grep aha | sed '/deinstall/d')" ]; then
			:
	else
		fMens "$FInsuc" "$MErr04"
		exit
	fi
	#											criar arquivo de configuração para o PHP
	echo -e "<?php\n\$banco_de_dados = \"$CPBASE\";\n\$username = \"$CPBASEUSER\";" > $CPPADMIN/$CPPHPFILE
	echo -e "\$pass = \"$CPBASEPASSW\";"		>> $CPPADMIN/$CPPHPFILE
	echo -e "\$httphost = \"$CPHTTPHOST\";"		>> $CPPADMIN/$CPPHPFILE
	echo -e "\$httpdominio = \"$CPHTTPDOM\";"   >> $CPPADMIN/$CPPHPFILE
	echo -e "\$banco = \"$CPBASE\";"			>> $CPPADMIN/$CPPHPFILE
	echo -e "\$pastaimagens = \"$CPPIMAGEM\";"	>> $CPPADMIN/$CPPHPFILE
	echo -e "\$pastaprimitivos = \"$CPPRIMITIVOS\";"  >> $CPPADMIN/$CPPHPFILE
	echo -e "\$pastalogs = \"$CPPLOG\";"		>> $CPPADMIN/$CPPHPFILE
	echo -e "\$pastaquarentine = \"$CPPQUARENTINE\";"  >> $CPPADMIN/$CPPHPFILE
	echo -e "\$pastaadmin = \"$CPPADMIN\";"            >> $CPPADMIN/$CPPHPFILE
	echo -e "\$arqlogs   = \"$CPALOG\";"	      >> $CPPADMIN/$CPPHPFILE
	echo -e "\$listatabelas = \"$CPTABELASCRIADAS\";" >> $CPPADMIN/$CPPHPFILE
	echo -e "\$valorcookie = \""$(echo -n "$(date +%s)" | sha1sum | awk '{print $1}')"\";" >> $CPPADMIN/$CPPHPFILE
	echo -e "\$sess_nome = \"superinter$RANDOM\";" 	>> $CPPADMIN/$CPPHPFILE
	echo -e "\$pag_backoffice1 = 1;"				>> $CPPADMIN/$CPPHPFILE
	echo -e "\$pag_admin = 2;"						>> $CPPADMIN/$CPPHPFILE
	echo -e "\$pag_upload = 3;"						>> $CPPADMIN/$CPPHPFILE
	echo -e "\$pag_login = 4;"						>> $CPPADMIN/$CPPHPFILE
	#					upload de arquivos
	echo -e "\$limitar_tamanho = \"$CPLIMITATAM\";"	>> $CPPADMIN/$CPPHPFILE
	echo -e "\$limitar_ext = \"$CPLIMITAEXT\";"		>> $CPPADMIN/$CPPHPFILE
	echo -e "\$caminho_absoluto = \"$CPPUPLOADS\";"	>> $CPPADMIN/$CPPHPFILE 
	echo -e "\$tamanho_max = \"$CPTAMMAX\";"		>> $CPPADMIN/$CPPHPFILE
	echo -e "\$sobrescrever = \"$CPSOBRESCREVER\";"	>> $CPPADMIN/$CPPHPFILE
	echo -e "\$lote = $CPQPDFLOTE;"					>> $CPPADMIN/$CPPHPFILE
	for i in ${!CPEXTENSOES[@]}; do
		if [ $i -eq 0 ]
		then
			a=array\(\"${CPEXTENSOES[$i]}\"
		else
			a=$a,\"${CPEXTENSOES[$i]}\"
		fi
	done
	a=$a\)
	echo -e "\$extensoes_validas = $a;" >> $CPPADMIN/$CPPHPFILE
	echo -e "?>\n" >> $CPPADMIN/$CPPHPFILE
	#											TTT C12: verificar criação do arquivo de configuração para o PHP
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr33"
		exit
	fi
	#											TTT C13: verificar existência arquivo com comandos SQL criação de tabelas
	if [ ! -f $CPPINFO/$CPCRIATABELAS ]; then
		fMens "$FInsuc" "$MErr25"
		exit
	fi	
	#											TTT C14: verificar existência de arquivo com indicação das tabelas a constarem no relatório resumo
	if [ $CPRELATORIO -eq 0 ] && [ ! -f $CPPINFO/$CPRELATORIOTABELAS ]; then
		fMens	"$FInsuc"	"$MErr34"
		exit
	fi	
	#											TTT C15: verificar criação de pasta do acervo (imagens de arquivos PDF)
	fMens "$FInfor" "$MInfo01" 
	rm -rf $CPPIMAGEM 2>/dev/null
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr01"
 		exit
	fi
	mkdir $CPPIMAGEM
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr03"
 		exit
	else
		fMens "$FSucss" "$MInfo02"
	fi
	#											TTT C16: verificar criação de pasta para uploads de arquivos
	rm -rf $CPPUPLOADS 2>/dev/null
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr30"
 		exit
	fi
	mkdir $CPPUPLOADS
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr31"
 		exit
	else
		fMens "$FSucss" "$MInfo06"
	fi
	#											TTT C17: verificar criação de pasta de trabalho
	rm -rf $CPPWORK 2>/dev/null
	mkdir $CPPWORK
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr19"
 		exit
	else
		fMens "$FSucss" "$MInfo25"
	fi
	#											TTT C18: verificar criação de pasta para arquivos originais não PDF
	rm -rf $CPPRIMITIVO
	mkdir $CPPRIMITIVO
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr18"
 		exit
	else
		fMens "$FSucss" "$MInfo23"
	fi
	#											TTT C19: verificar criação de pasta de quarentena
	rm -rf $CPPQUARENTINE
	mkdir $CPPQUARENTINE
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr29"
 		exit
	else
		fMens "$FSucss" "$MInfo24"
	fi
	#											TTT C20: verificar criação de pasta arquivos PHP gerados automaticamente
	rm -rf $CPPAUTOPHP	
	mkdir $CPPAUTOPHP
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr35"
 		exit
	else
		fMens "$FSucss" "$MInfo51"
	fi
	#											TTT C21: verificar criação de pasta arquivos temporários
	rm -rf $CPPTEMP
	mkdir $CPPTEMP
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr37"
 		exit
	else
		fMens "$FSucss" "$MInfo49"
	fi
	# 											TTT C22: verificar existência de pasta administrativa da Superinterface
	if [ ! -d $CPPADMIN ]; then
		fMens "$FInsuc" "$MErr20"
		exit
	fi
	# 											TTT C23: verificar existência de pasta de javascript da Superinterface
	if [ ! -d $CPPJS ]; then
		fMens "$FInsuc" "$MErr41"
		exit
	fi
	#											TTT C24: verificar criação arquivo índice numeração de nomes arquivos PDF
	echo 100 > $CPPADMIN/$CPINDICEPDF
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr07"
		exit
	fi
	#											TTT C25: definir permissões de acesso a pastas e arquivos
	#											Deixar inicialmente os diretorios e pastas com uma permissão padrão
	find ../ -type d -exec chmod $CPPERM750 {} \;
	find ../ -type f -exec chmod $CPPERM640 {} \;
	chmod $CPPERM600 $CPCONFIG              # definir permissão arquivo de configuração
	chmod $CPPERM600 $CPPADMIN/$CPPHPFILE   # definir permissão arquivo de configuração do PHP
	chmod $CPPERM440 super_cowsay1.txt      # definir permissão arquivo de mensagens cowsay
	chmod $CPPERM500 ./*.sh                 # definir permissão arquivos de scripts shell da pasta de instalação
	# --- --- ---
	#
	fMens "$FSucss" "$MInfo03"					# pasta administrativa preparada
	#											TTT C26: testar conexão com o banco de dados
	fMens "$FInfor" "$MInfo19"
	mysql -u $CPBASEUSER -b $CPBASE -p$CPBASEPASSW -e "quit" 2>/dev/null
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr08"
		exit
	else
		fMens "$FSucss" "$MInfo09"
	fi
}

#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   				   			FUNÇÃO DE CRIAÇÃO DAS TABELAS 														|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fCriaTabelas () { 
	#											TTT C27: apagar possíveis tabelas e verificar se base de dados está limpa
	TABLES=$(mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'show tables' | awk '{ print $1}' | grep -v '^Tables' );
	for t in $TABLES
	do
		mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SET FOREIGN_KEY_CHECKS = 0 ; drop table $t"
		if [ $? -ne 0 ]; then
			fMens "$FInsuc" "$MErr12"
			exit
		fi
	done
	fMens "$FSucss" "$MInfo16"
	mysql  -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SET FOREIGN_KEY_CHECKS = 1"
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr13"
 		exit
	fi
	# 											Criar tabela de usuários (reservada do sistema)
	#											Tabela com usuários administradores e curadores do acervo
	sql="CREATE TABLE su_usuarios (id_chave_usuario int not null auto_increment, username varchar(10) NOT NULL, senha varchar(42) NOT NULL, nome_usuario varchar(40) NOT NULL, email varchar(40) NOT NULL, cidade varchar(40) NOT NULL, estado char(2) NOT NULL, privilegio TINYINT unsigned  NOT NULL, ativo bool NOT NULL, primary key (id_chave_usuario));"
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e " $sql"
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr24"
		exit
	fi
	sql="ALTER TABLE su_usuarios comment='Contém a identificação dos usuários para acesso a interface administrativa da Superinterface, ao mesmo tempo em que é uma lista de curadores dos documentos';"
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e " $sql"
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr14"
		exit
	fi
	#											TTT C28: criar e verificar a criação das tabelas da Superinterface
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPPINFO"/"$CPCRIATABELAS"
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo17"
	else
		fMens "$FInsuc" "$MErr13"
 		exit
	fi
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#                     FUNÇÃO AUXILIAR DE INSERÇÃO DE INFORMAÇÕES NA BASE A PARTIR DE ARQUIVOS CSV                           |
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fInsereCsv () {
arquivos=$(find "$CPPINFO"/*.csv -maxdepth 1 -type f -not -iname "$CPRELATORIOTABELAS") # exceto o arquivo contendo lista de tabelas para relatorio resumo
for file in $arquivos
do
	arquivosem=$(basename $file)								# retira o caminho: recebe apenas o nome completo do arquivo
	arquivosem=${arquivosem%.*}									# nome do arquivo sem extensão
	arquivosem=$(echo $arquivosem | sed 's/^[^_]*_//')  		# fica só com a parte após o primeiro underscore, que corresponde nome da tabela
	tabelascsv+=($arquivosem)									# guarda os nomes das tabelas que serão manipuladas
	nomes_col=$(head -1 $file)									# nomes das colunas do arquivo csv
	oldIFS=$IFS
	IFS=','														# altera para vírgula a variável (de sistema) separadora de campo de entrada
	jj=0
	campos=()													# receberá o nome dos campos da tabela
	sql="LOAD DATA LOCAL INFILE '$file' INTO TABLE $arquivosem FIELDS TERMINATED by ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES ("
	for i in $nomes_col
	do
		campos[jj]=$(echo "$i" | sed 's/\"//g')					# retira as aspas que rodeia os conteúdos de cada célula do arquivo csv
		if [ $jj -ne 0 ]; then
			sql=$sql,											# insere uma vírgula entre os campos
		fi
		sql=$sql${campos[jj]}									# insere o nome do campo na montagem do comando sql
		((++jj))
	done
	IFS=$oldIFS
	sql="$sql"")"
	mysql -u  $CPBASEUSER -p$CPBASEPASSW -b $CPBASE  -e "$sql"
	if [ $? -ne 0 ]; then
		fMens "$FInsu2" "$MErr40"
		fMens "$FInsu3" "$file"
	exit
	else
		fMens "$FSucs3" "$MInfo54"
		fMens "$FSucs4" "$file"
	fi
done
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#                     FUNÇÃO AUXILIAR DE INSERÇÃO DE INFORMAÇÕES NA BASE A PARTIR DE ARQUIVOS SQL                           |
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fInsereSql () {
su_quant=$(ls -l $CPPINFO/*.sql 2>/dev/null | grep  "^-"  -c)   # numero arquivos SQL existentes
if [ $su_quant -lt 2 ]; then									# pelo menos 1 arquivo é obrigatório: o de criar tabelas
	fMens	"$FInfor"	"$MInfo15"
	return
fi
arquivos=$(find "$CPPINFO"/*.sql -maxdepth 1 -type f -not -iname "$CPCRIATABELAS") # exceto o arquivo de criação de tabelas
for file in $arquivos
do
	mysql -u  $CPBASEUSER -p$CPBASEPASSW -b $CPBASE  < "$file"  
	if [ $? -ne 0 ]; then
		fMens "$FInsu2" "$MErr38"
		fMens "$FInsu3" "$file"
		exit
	else
		fMens "$FSucs3" "$MInfo52"
		fMens "$FSucs4" "$file"
	fi
done
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   				   			FUNÇÃO DE UPDATE DAS TABELAS    													|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fInsertScript () {
# 				Será chamado um arquivo opcional SHELL para manipular informações e fazer INSERT de dados adicionais na base de dados.
# 				Este arquivo é opcional, não obrigatório. Neste caso, o arquivo mencionado na variável CPINSERTSCRIPT deve 
#				ser retirado desta pasta de instalação.
retval=0
if [ ! -f $CPPINFO/$CPINSERTSCRIPT ]; then
	fMens "$FInfor" "$MInfo20"
else
	fMens "$FInfor" "$MInfo21"
	#	. $(dirname "$0")/$CPINSERTSCRIPT
	. $CPPINFO/$CPINSERTSCRIPT							# executa o script do usuário
	rm -f $CPPTEMP/*									# limpa pasta de arquivos temporários
fi
return
}	# fim da rotina de preparação de tabelas
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   				   	                FUNÇÃO PARA CRIAR USUÁRIO ADMIN												|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fUserAdmin () { 
	#
	var="admin"
	hash="$(echo -n "$var" | sha1sum | awk '{print $1}')"
	sql="INSERT INTO su_usuarios (username, senha , nome_usuario , email , cidade , estado, privilegio , ativo ) VALUES ('admin','${hash}','Administrador','admin@exemplo.com','Campinas','SP',0,TRUE)"						# Administrador tem privilégio = 0 (máximo privilégio)
	#											TTT C29: verifica a criação de usuário administrador
	mysql  -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "$sql"
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo12"
	else
		fMens "$FInsuc" "$MErr11"
 		exit
	fi
	# 						colocar todos os usuários como curadores e INATIVOS, exceto o admin
	sql="UPDATE su_usuarios SET senha = $RANDOM, privilegio = 1, ativo = 0 where username != 'admin'"
	mysql  -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "$sql"
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr22"
 		exit
	fi
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   				   	                FUNÇÃO PARA INFORMAR UM RESUMO DA BASE DE DADOS								|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
fResumo () {
	#								resumo de informações da instalação realizada
	fMens "$FInfor" "$MInfo07"
	#fMens "$FInfo3" "$(printenv SHELL)"
	fMens "$FInfo3" "$($SHELL --version | head -1)"
	fMens "$FInfo3" "$(/usr/bin/lsb_release -ds)"
	fMens "$FInfo3" "$(printenv LANG)"
	fMens "$FInfo3" "$(php -v | head -1)"
	fMens "$FInfo3" "$(mysql  -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e \"select @@version\" | head -1)"
	fMens "$FInfo3" "$(/usr/bin/id -un)"
	fMens "$FInfo4" "$MInfo42"
	fMens "$FInfo1"	"$(pgrep soffice)"
	fMens "$FInfo2" "$MInfo18"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$CPBASE'")"
	#	for i in "${tabelascsv[@]}"							# irá imprimir o número de registros nas tabelas populadas a partir arquivos csv
	#	do
	#		fMens "$FInfo2" "$MInfo53 $i= "
	#		fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM $i") "
	#	done
	if	[ $CPRELATORIO -ne 1 ]; then
	{
		#									relatorio com apenas as tabelas escolhidas
		exec 8< $CPPINFO/$CPRELATORIOTABELAS  # associa lista_arquivos ao descritor 8
		while read arq <&8; do   # Lê uma linha de cada vez do descritor 3.
			arq=$(echo "$arq" | sed 's/\"//g')	# retira as aspas que rodeia os conteúdos de cada célula do arquivo csv
			fMens "$FInfo4" "$MInfo53 $arq= "
			fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM $arq") "
		done
		exec 8<&-  # libera descritor 8
	}
	else {
		#									relatorio com todas as tabelas
		TABLES=$(mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'show tables' | awk '{ print $1}' | grep -v '^Tables' );
		for arq in $TABLES
		do
			fMens "$FInfo4" "$MInfo53 $arq= "
			fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM $arq") "
		done
	}
	fi
}
#
#
fInit										# verificação e preparação do ambiente de instalação
fCriaTabelas								# cria as tabelas
fMens "$FInfor" "$MInfo13" 
tabelascsv=()								# neste array será guardado o nome das tabelas que serão populadas pelos arquivos csv
fInsereCsv 									# rotina para inserir no banco de dados informações dos arquivos csv existentes
fInsereSql									# rotina para inserir no banco de dados informações dos arquivos sql existentes
retval=0
fInsertScript								# Script de responsabilidade do usuário para manipular informações e fazer Inserts adicionais na base de dados
if [ $retval -eq 0 ]; then
	fMens "$FSucss" "$MInfo14"
else
	fMens "$FInsu2" "$MErr17"
	fMens "$FInsu3" "$retval"
	exit
fi
fUserAdmin									# criar usuário admin
#
fMens	"$FInfor"	"$MInfo04"
#											Chama script php para fazer a geração de código PHP da Superinterface
php super_cria_interfaces.php &
PID=$!										# captura o PID do último comando anterior lançado em background.
wait $PID									# wait é um comando built-in do Linux que espera completar um process em execução.
if [ $? -ne 0 ]; then
	fMens "$FInsuc" "$MErr10"				# Erro na geração de código PHP
	exit
fi
fResumo	$tabelascsv									# informar um resumo da base de dados
fMens	"$FSucs2"	"$MInfo43"
fMens	"$FInfo2"	"$MInfo10" ; fMens	"$FInfo1"	"$CPPLOG/$CPALOG"
fMens	"$FInfo2"	"$MInfo05" ; fMens	"$FInfo1"	"$CPPAUTOPHP"
fMens	"$FInfor"	"$MInfo11"
fMens	"$FInfor"	"$MInfo46:  $(date '+%d-%m-%Y as  %H:%M:%S')"
rm -f $CPPLOG/$CPALOGHTML
cat $CPPLOG/super_logshell.log | aha -b > $CPPLOG/$CPALOGHTML
#					configurações de segurança adicionais
chmod $CPPERM600 ./*.cnf
chmod $CPPERM640 $CPPLOG/$CPTABELASCRIADAS
chmod $CPPERM640 $CPPLOG/$CPALOG
chmod $CPPERM640 $CPPLOG/$CPALOGHTML
unoconv --listener &
#
exit	0

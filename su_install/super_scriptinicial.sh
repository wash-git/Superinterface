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
MErr14="Erro! Não foi possível inserir informações na tabela 'su_cidades'"
MErr15="Erro! Não foi possível apagar alguns arquivos antigos"
MErr16="Erro! Não foi possível se conectar com a base de dados legada"
MErr17="Erro! Não foi possível criar as tabelas da aplicação e inserir seus dados"
MErr18="Erro! Não foi possível preparar pasta de arquivos originais não PDF: a pasta não pode ser criada"
MErr19="Erro! Não foi possível preparar pasta de temporários: a pasta não pode ser criada"
MErr20="Erro! Pasta Administrativa não foi encontrada"
MErr21="Erro! Não foi possível inserir conjunto inicial de nomes próprios de brasileiros na base de dados"
MErr22="Erro! Não foi possível inserir conjunto inicial de nomes de cidades do Brasil na base de dados"
MErr23="Erro! Não foi encontrado o arquivo de configuração"
MErr24="Erro! Não foi encontrado o arquivo com comandos SQL para popular tabela de 'su_cidades'"
MErr25="Erro! Não foi encontrado o arquivo com comandos SQL para criação das tabelas da Superinterface"
MErr26="Erro! Não foi possível preparar as pastas necessárias à aplicação Superinterface"
MErr27="Erro! Não foi possível preparar pasta de logs: a pasta não pode ser criada"
MErr28="Erro! É necessário ter instalado o aplicativo 'unoconv', conforme manual de instalação"
MErr29="Erro! Não foi possível preparar pasta de quarentena: a pasta não pode ser criada"
MErr30="Erro! Não foi possível preparar pasta de upload para novos arquivos"
MErr31="Erro! Não foi possível criar pasta de uploads para novos arquivos"
MErr32="Erro! É necessário ter instalado o aplicativo 'detox' (apt-get install detox)"
MErr33="Erro! Não foi possível gerar o arquivo de configuração para as rotinas PHP"
MErr34="Erro! Não foi encontrado o arquivo com comandos SQL para popular tabela de 'su_names_brasil'"
MErr35="Erro! Não foi possível criar pasta para arquivos PHP que viriam a ser automaticamente gerados"
MErr36="Erro! Para instalar a Superinterface é obrigatório estar na pasta 'su_install'"
MErr37="Erro! Não foi possível inserir informações na tabela 'su_instituicoes'"
MErr38="Erro! Não foi encontrado o arquivo com comandos SQL para popular tabela de 'su_instituicoes'"
MErr39="Erro! Não foi possível gerar arquivo auxiliar de nomes de instituições"
MErr40="Erro! Não foi possível inserir conjunto inicial de nomes de instituições na base de dados"
#
MInfo01="Preparando as pastas"
MInfo02="Sucesso! Criada pasta do acervo de arquivos PDF da Superinterface"
MInfo03="Sucesso! Pasta administrativa preparada"
MInfo04="Geração automática de código PHP:"
MInfo05="Verifique os códigos PHP gerados automaticamente na pasta: "
MInfo06="Sucesso! Criada pasta de uploads para novos arquivos"
MInfo07="Sucesso! Informações inseridas corretamente na tabela 'su_instituicoes'"
MInfo08="Iniciando a instalação"
MInfo09="Sucesso! Conexão com o banco de dados foi realizada corretamente"
MInfo10="Verifique o log da instalação da Superinterface através do arquivo: "
MInfo11="Verifique as estruturas das tabelas criadas através da opção 'Tabelas' da interface administrativa"
MInfo12="Sucesso! Criado usuário/senha da interface de administração da Superinterface"
#MInfo13=""
MInfo14="Sucesso! Tabelas adicionais da aplicação do usuário foram criadas, e informações fornecidas foram inseridas"
MInfo15="Atenção: não foi encontrado arquivo SQL para criação tabelas da aplicação externa do usuário. Continuando a instalar a Superinterface"
MInfo16="Sucesso! Possíveis tabelas remanescentes no banco de dados foram eliminadas"
MInfo17="Sucesso! Tabelas do banco de dados (re)criadas, e informações inseridas corretamente"
MInfo18="Quantidade de tabelas geradas= "
MInfo19="Sucesso! Informações inseridas corretamente na tabela 'su_cidades'"
MInfo20="Quantidade de registros na tabela 'su_cidades'= "
#MInfo21=""
MInfo22="Quantidade de registros na tabela 'su_documents'= "
#MInfo23=""
MInfo24="Quantidade de registros na tabela 'su_docs_signatários'= "
MInfo25="Quantidade de registros na tabela 'su_docs_instituicoes'= "
MInfo26="super_install.sh"
MInfo27="Sucesso! Criada pasta de arquivos orginais não PDF"
MInfo28="Sucesso! Conjunto inicial de nomes de instituições, nomes de pessoas e de cidades inseridas na base de dados"
MInfo29="Quantidade de registros na tabela 'su_instituicoes'= "
MInfo30="Quantidade de registros na tabela 'su_nomes_cidades'= "
MInfo31="Quantidade de registros na tabela 'su_names_brasil'= "
MInfo32="Sucesso! Criada pasta de quarentena"
MInfo33="Sucesso! Criada pasta de arquivos temporários"
#MInfo34=""
#MInfo35=""
#MInfo36=""
#MInfo37=""
#MInfo38=""
#MInfo39=""
MInfo40="Quantidade de registros na tabela 'su_docs_cidades'= "
MInfo41="Bem vind@ ao script de instalação da Superinterface em:   "
#MInfo42=""
MInfo43="Parabéns!!!   A instalação da Superinterface foi um sucesso!"
MInfo44="Sucesso! Criada pasta de arquivos de logs"
MInfo45="Data:"
MInfo46="Script terminado em"
MInfo47="Alerta: notamos a falta do aplicativo cowsay. Ele não é obrigatório. Dica: assim que possível, instalar o cowsay  (apt-get install cowsay)"
MInfo48="Alerta: notamos a falta do aplicativo figlet. Ele não é obrigatório. Dica: assim que possível, instalar o figlet  (apt-get install figlet)"
#MInfo49=""
MInfo50="Nenhum arquivo PDF será tratado nesta instalação. A incorporação dos arquivos PDF ao acervo da Superinterface estará a cargo do script ativado via cron"
MInfo51="Sucesso! Criada pasta para guardar os arquivos PHP gerados automaticamente nesta instalação"
#
FInfor=0	# saída normal: new line ao final, sem tratamento de cor
FInfo1=1	# saída normal: new line ao final, sem tratamento de cor e sem ..... (sem pontinhos ilustrativos)
FInfo2=2	# saída sem new line ao final, sem tratamento de cor
FSucss=3	# saída para indicação de sucesso: new line ao final da mensagem. na cor azul. No final, muda para cor branca
FSucs2=4	# saída para indicação de sucesso: new line antes e depois da mensagem, cor azul. No final, muda para cor branca
FInsuc=5	# saída para indicação de erro, na cor vermelha
FInsu1=6	# saída para indicação de erro, na cor vermelha (apenas no screen, não enviado para arquivo de log)
FCowsa=7	# saída para aplicativo cowsay
FFighl=8	# saída para aplicativo fighlet
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
		$FSucss)
			echo -e "\e[34m.....$2\e[97m" | tee -aa "$CPPLOG"/"$CPALOG"
			;;
		$FSucs2)
			echo -e "\n\e[34m.....$2\e[97m" | tee -aa "$CPPLOG"/"$CPALOG"
			;;	
		$FInsuc)
			echo -e  "\n\e[31m.....$2" | tee -a "$CPPLOG"/"$CPALOG"
			echo -e ".....$MErr02\e[97m" | tee -a "$CPPLOG"/"$CPALOG"
			;;
		$FInsu1)
			echo -e  "\n\e[31m.....$2"
			echo -e ".....$MErr02\e[97m"
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
		C13: verificar existência arquivo SQL para criação de tabelas e inserts iniciais
		C14: verificar existência arquivo SQL para inserção de dados tabela su_cidades
		C15: verificar existência arquivo SQL para inserção de dados tabela su_names_brasil
		C16: verificar existência arquivo SQL para inserção de dados tabela su_instituições
		C17: verificar criação de pasta do acervo (imagens de arquivos PDF)
		C18: verificar criação de pasta para uploads de arquivos
		C19: verificar criação de pasta de trabalho temporária
		C20: verificar criação de pasta para arquivos originais não PDF
		C21: verificar criação de pasta de quarentena
		C22: verificar criação de pasta arquivos PHP gerados automaticamente
		C23: verificar existência de pasta administrativa da Superinterface
		C24: verificar criação arquivo índice numeração de nomes arquivos PDF
		C25: definir permissões de acesso a pastas e arquivos
		C26: verificar a conexão com o banco de dados
		C27: verificar se base de dados está limpa
		C28: verificar criação das tabelas da Superinterface
		C29: verificar se existe, e tratar arquivo adicional SQL de aplicação externa
		C30: verificar inserção de dados na tabela su_cidades a partir de arquivo SQL
		C31: verificar inserção de dados na tabela su_instituicoes a partir de arquivo SQL
		C32: verificar inserção de dados na tabela su_names_brasil a partir de arquivo SQL
		C33: verifica criação de arquivo de nomes cidades sem acentuação
		C34: verifica criação de arquivo de nomes instituições sem acentuação
		C35: verifica a criação de usuário administrador
        --------        --------        --------  
'
#
	clear
	#											C01: verificar se é usuário root
	if [ "$EUID" -eq $CPROOT_UID ];  then 
		fMens "$FInsu1" "$MErr05"
		exit
	fi
	#											C02: verificar se pasta corrente é a de instalação
	if [ "${PWD##*/}" != "$CPPINSTALL" ]; then
		fMens "$FInsu1" "$MErr36"
		exit
	fi
	#											C03: verificar se arquivo de configuração está disponível
	if [ ! -f $CPCONFIG ]; then
		fMens "$FInsu1" "$MErr23"
		exit
	fi
	#											limpeza do ambiente de instalação
	#find ../ -type d -not -name su* -not -name .. -exec rm -r {} \
	source  $CPCONFIG							# inserir arquivo de configuração
	#											C04: limpar pasta de administração
	#											apagar possíveis arquivos anteriores para gerar novas versões:
	# 											configuração do PHP,bloqueio do script ativado pelo cron
	rm	-f	{$CPPADMIN/$CPPHPFILE,$CPPADMIN/$CPNOMENOVOS".lock"}
	if [ $? -ne 0 ]; then
 		fMens "$FInsu1" "$MErr15"
 		exit
	fi
	#											C05: limpar pasta de logs, de acervo, de uploads e outras				
	# 											limpar pastas: logs, arquivos do acervo, uploads, temporários, quarentena, primitivo, autoPHP
	rm -rf {$CPPLOG,$CPPIMAGEM,$CPPUPLOADS,$CPPWORK,$CPPQUARENTINE,$CPPRIMITIVO,$CPPAUTOPHP}  2>/dev/null
	if [ $? -ne 0 ]; then
 		fMens "$FInsu1" "$MErr26"
 		exit
	fi
	#											C06: verificar criação de pasta de logs
	mkdir $CPPLOG					
	if [ $? -ne 0 ]; then
 		fMens "$FInsu1" "$MErr27"
 		exit
	fi
	fMens "$FSucss" "$MInfo44"					# sucesso na criação de pasta de logs
	#											veriricar criação de arquivo de logs
	echo "--- Arquivo de LOG criado ---" > $CPPLOG/$CPALOG
	#											C07: verificar se aplicativo unoconv está instalado
	#                                       	(necessário para conversão .docx -> .pdf)
	if [ -n "$(dpkg --get-selections | grep unoconv | sed '/deinstall/d')" ]; then
	:
	else
		fMens "$FInsuc" "$MErr28"
		exit
	fi
	#         
	#											C08: verificar se aplicativo detox está instalado
	if [ -n "$(dpkg --get-selections | grep detox | sed '/deinstall/d')" ]; then
		:
	else
		fMens "$FInsuc" "$MErr32"
		exit
	fi
	#											C09: verificar se aplicativo figlet está instalado
	if [ -n "$(dpkg --get-selections | grep figlet | sed '/deinstall/d')" ]; then
		fMens "$FInfo1" "$MCor02"				# saída na cor amarela 
		fMens "$FFighl"
	else
		fMens "$FInfor" "$MInfo48"	
	fi
	fMens "$FInfo1" "$MCor02"					# saída na cor amarela 
	fMens "$FInfo2"	"$MInfo41"					# enviar mensagem de boas vindas
	fMens "$FInfo1"	"$MInfo26"					# $0
	fMens "$FInfor" "$MInfo45:  $(date '+%d-%m-%Y as  %H:%M:%S') --- $MInfo08"
	fMens "$FInfo1" "$MCor01"
	#											C10: verificar se aplicativo cowsay está instalado
	if [ -n  "$(dpkg --get-selections | grep cowsay | sed '/deinstall/d')" ]; then
		fMens "$FCowsa"  "$CPNOMECOWSAY1"
	else
		fMens "$FInfor" "$MInfo47"
	fi
	#											C11: verificar se aplicativo aha está instalado
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
	#											C12: verificar criação do arquivo de configuração para o PHP
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr33"
		exit
	fi
	#											C13: verificar existência de arquivo com comandos SQL de criação de 
	#											tabelas e inserts iniciais
	if [ ! -f $CPCRIATABELAS ]; then
		fMens "$FInsuc" "$MErr25"
		exit
	fi	
	#											C14: verificar existência arquivo SQL p/ inserção dados tabela su_cidades
	if [ ! -f $CPINSERECIDADES ]; then
		fMens "$FInsuc" "$MErr24"
		exit
	fi
	#											C15: verificar existência arquivo SQL p/ inserção dados tabela su_names_brasil
	if [ ! -f $CPINSERENOMES ]; then
		fMens "$FInsuc" "$MErr34"
		exit
	fi
	#											C16: verificar existência arquivo SQL p/ inserção dados tabela su_instituições
	if [ ! -f $CPINSEREINST ]; then
		fMens "$FInsuc" "$MErr38"
		exit
	fi



	#											C17: verificar criação de pasta do acervo (imagens de arquivos PDF)
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
	#											C18: verificar criação de pasta para uploads de arquivos
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
	#											C19: verificar criação de pasta de trabalho temporária
	rm -rf $CPPWORK 2>/dev/null
	mkdir $CPPWORK
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr19"
 		exit
	else
		fMens "$FSucss" "$MInfo33"
	fi
	#											C20: verificar criação de pasta para arquivos originais não PDF
	rm -rf $CPPRIMITIVO
	mkdir $CPPRIMITIVO
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr18"
 		exit
	else
		fMens "$FSucss" "$MInfo27"
	fi
	#											C21: verificar criação de pasta de quarentena
	rm -rf $CPPQUARENTINE
	mkdir $CPPQUARENTINE
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr29"
 		exit
	else
		fMens "$FSucss" "$MInfo32"
	fi
	#											C22: verificar criação de pasta arquivos PHP gerados automaticamente
	rm -rf $CPPAUTOPHP	
	mkdir $CPPAUTOPHP
	if [ $? -ne 0 ]; then
 		fMens "$FInsuc" "$MErr35"
 		exit
	else
		fMens "$FSucss" "$MInfo51"
	fi
	# 											C23: verificar existência de pasta administrativa da Superinterface
	if [ ! -d $CPPADMIN ]; then
		fMens "$FInsuc" "$MErr20"
		exit
	fi
	#											C24: verificar criação arquivo índice numeração de nomes arquivos PDF
	echo 100 > $CPPADMIN/$CPINDICEPDF
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr07"
		exit
	fi
	#											C25: definir permissões de acesso a pastas e arquivos
	#											Deixar inicialmente os diretorios e pastas com uma permissão padrão
	find ../ -type d -exec chmod $CPPERM750 {} \;
	find ../ -type f -exec chmod $CPPERM640 {} \;
	chmod $CPPERM600 $CPCONFIG              # definir permissão arquivo de configuração
	chmod $CPPERM600 $CPPADMIN/$CPPHPFILE   # definir permissão arquivo de configuração do PHP
	chmod $CPPERM440 super_cowsay1.txt      # definir permissão arquivo de mensagens cowsay
	chmod $CPPERM500 ./*.sh                 # definir permissão arquivos de scripts shell da pasta de instalação
	chmod $CPPERM440 *.[sS][qQ][lL]         # definir permissão arquivos SQL
	# --- --- ---
	chmod $CPPERM750 $CPPINSTALL            # definir permissão pasta de instalação da Superinterface
	chmod $CPPERM750 $CPPPHP                # definir permissão pasta arquivos PHP da admin da Superinterface
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
	#
	fMens "$FSucss" "$MInfo03"					# pasta administrativa preparada
	#											C26: testar conexão com o banco de dados
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
#			   				   	    FUNÇÃO DE PREPARAÇÃO DOS ARQUIVOS PDF DO REPOSITÓRIO									|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
#											os arquivos PDF para o repositório serão preparados pelo script ativado pelo cron
function fArquivos () {
	fMens	"$FInfor"	"$MInfo50"
	return
}
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   				   			FUNÇÃO DE PREPARAÇÃO DAS TABELAS													|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fTabelas () { 
	#											C27: apagar possíveis tabelas e verificar se base de dados está limpa
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
	#											C28: criar e verificar existência das tabelas da Superinterface
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPCRIATABELAS"
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo17"
	else
		fMens "$FInsuc" "$MErr13"
 		exit
	fi
	#											C29: verificar se existe arquivo adicional SQL de aplicação externa
	if [ -f $CPTABAPLICACAO ]; then
		#										criar tabelas da aplicação e inserir seus dados
		mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPTABAPLICACAO"
		if [ $? -eq 0 ]; then
			fMens "$FSucss" "$MInfo14"
		else
			fMens "$FInsuc" "$MErr17"
 			exit
		fi
	else
		fMens "$FInfor" "$MInfo15"
	fi
	#											C30: verificar inserção de dados na tabela 'su_cidades'
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPINSERECIDADES"
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo19"
	else
		fMens "$FInsuc" "$MErr14"
 		exit
	fi
	#											C31: verificar inserção de dados na tabela 'su_instituicoes'
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPINSEREINST"
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo07"
	else
		fMens "$FInsuc" "$MErr37"
 		exit
	fi
	#				resumo
	fMens "$FInfo2" "$MInfo18"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$CPBASE'")"
	fMens "$FInfo2" "$MInfo22"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_documents")"
	fMens "$FInfo2" "$MInfo24"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_docs_signatarios") "
	fMens "$FInfo2" "$MInfo25"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_docs_instituicoes")"
	fMens "$FInfo2" "$MInfo20"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_cidades") "
	fMens "$FInfo2" "$MInfo40"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "SELECT count(*) FROM su_docs_cidades") "
	#											C32: verificar inserção de dados na tabela 'su_names_brasil'
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPINSERENOMES"
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr21"
 		exit
	fi
	#											C33: verifica criação de arquivo de nomes cidades sem acentuação
	mysql  -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "INSERT INTO su_nomes_cidades(nome_cidade) SELECT nome_cidade FROM su_cidades"
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr22"
 		exit
	fi
	rm -rf  $CPPADMIN/$CPNOMECIDADES
	mysql --skip-column-names --raw -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'select * from su_nomes_cidades' |  sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' |  tr [:lower:] [:upper:] > $CPPADMIN/$CPNOMECIDADES
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr06"
 		exit
	fi
	#											C34: verifica criação de arquivo de nomes instituições sem acentuação
	mysql  -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "INSERT INTO su_nomes_instituicoes(nome_instituicao) SELECT nome_instituicao FROM su_instituicoes"
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr40"
 		exit
	fi
	rm -rf  $CPPADMIN/$CPNOMEINST
	mysql --skip-column-names --raw -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'select * from su_nomes_instituicoes' |  sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' |  tr [:lower:] [:upper:] > $CPPADMIN/$CPNOMEINST
	if [ $? -ne 0 ]; then
		fMens "$FInsuc" "$MErr39"
 		exit
	fi



	#				resumo
	fMens "$FSucss" "$MInfo28"
	fMens "$FInfo2" "$MInfo29"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'SELECT count(*) FROM su_instituicoes')" 
	fMens "$FInfo2" "$MInfo31"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'SELECT count(*) FROM su_names_brasil')"
	fMens "$FInfo2" "$MInfo30"
	fMens "$FInfo1" "$(mysql -N -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'SELECT count(*) FROM su_nomes_cidades')"
}	# fim da rotina de preparação de tabelas
#
# --------------------------------------------------------------------------------------------------------------------------+
#											 																				|
#			   				   	                FUNÇÃO PARA CRIAR USUÁRIO ADMIN												|
#																															|
# --------------------------------------------------------------------------------------------------------------------------+
function fUseradmin () { 
	#
	var="admin"
	hash="$(echo -n "$var" | sha1sum | awk '{print $1}')"
	sql="INSERT INTO su_usuarios (username, senha , nome , email , cidade , estado, privilegio , ativo ) VALUES ('admin','${hash}','Administrador','admin@exemplo.com','Campinas','SP',0,TRUE)";	# Administrador tem privilégio = 0 (máximo privilégio)
	#											C35: verifica a criação de usuário administrador
	mysql  -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e "$sql"
	if [ $? -eq 0 ]; then
		fMens "$FSucss" "$MInfo12"
	else
		fMens "$FInsuc" "$MErr11"
 		exit
	fi
}
#
#
fInit				# verificação e preparação do ambiente de instalação
fArquivos			# preparar os arquivos PDF
fTabelas			# gerar as tabelas e os inserts de dados
fUseradmin			# criar usuário admin
#
fMens	"$FInfor"	"$MInfo04"
#					Chama script php para fazer a geração de código PHP da Superinterface
php super_cria_interfaces.php &
PID=$!				# captura o PID do último comando anterior lançado em background.
wait $PID			# wait é um comando built-in do Linux que espera completar um process em execução.
if [ $? -ne 0 ]; then
	fMens "$FInsuc" "$MErr10"	# Erro na geração de código PHP
	exit
fi
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
#
exit	0

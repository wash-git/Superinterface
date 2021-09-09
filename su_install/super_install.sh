#!/bin/bash
#							A instalação pode ser demorada. Vamos usar o recurso hohup
CPPINSTALL="su_install"						  # nome da pasta de instalação
#							verificar se pasta corrente é a de instalação
if [ "${PWD##*/}" != "$CPPINSTALL" ]; then
	echo "Erro! Para instalar a Superinterface, primeiro vá para a pasta 'su_install'"        
	exit 1
fi
nohup ./super_scriptinicial.sh > /dev/null &  # No Hangups e script em background. 
echo -e "\n\n\e[33m.....Acompanhe o andamento da instalação da Superinterface através do arquivo de logs em ../su_logs/super_logshell.log\e[97m\n\n"
exit 0


#		Arquivo SHELL complementar para fazer INSERTs de informações na base de dados
#		Arquivo chamado apenas na rotina de instalação da Superinterface.
#		Trata-se de um código específico fruto da modelagem da base de dados de uma aplicação em particular.
#		Este arquivo deve ser modificado conforme cada aplicação.  Se não for necessário realizar INSERTs
#		na base de dados, este arquivo deve ser retirado desta pasta de instalação.
#
#		É importante verificar se cada comando foi executado corretamente.  Em caso de erro, fazer retornar a variável
#		retval com um valor numérico diferente de 0.  Ao final, se tudo foi executado corretamente, fazer
#		a variável retval retornar com valor 0.
#
#                                               Criação de tabelas da aplicação e insert de informações a partir de 
#												arquivo SQL previamente preparado
#mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$CPPINFO/super_tabelas_inserts.sql"
#if [ $? -ne 0 ]; then
#	retval=1
#	return $retval
#fi
rm -rf  $CPPADMIN/super_cidades_maiusculas.txt
mysql --skip-column-names --raw -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'select * from su_nomes_cidades' |  sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' |  tr [:lower:] [:upper:] > $CPPADMIN/super_cidades_maiusculas.txt
if [ $? -ne 0 ]; then
	retval=2
	return $retval
fi
rm -rf  $CPPADMIN/$CPNOMEINST
mysql --skip-column-names --raw -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'select * from su_nomes_instituicoes' |  sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' |  tr [:lower:] [:upper:] > $CPPADMIN/$CPNOMEINST
if [ $? -ne 0 ]; then
	retval=3
	return $retval
fi
retval=0
return $retval
# fim do arquivo SHELL complementar, específico a modelagem da base de dados realizada

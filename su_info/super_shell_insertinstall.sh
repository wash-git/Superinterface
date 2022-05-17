#		Arquivo SHELL complementar para fazer INSERTs de informações na base de dados
#		Arquivo chamado apenas na rotina de instalação da Superinterface.
#		Trata-se de um código específico fruto da modelagem da base de dados de uma aplicação em particular.
#		Este arquivo deve ser modificado conforme cada aplicação.  Se não for necessário realizar INSERTs
#		na base de dados, este arquivo deve ser retirado desta pasta de instalação.
#
#               Indicação de erro/sucesso: é importante verificar se cada comando foi executado corretamente.  
#               Em caso de erro, fazer retornar a variável retval com um valor numérico diferente de 0.
#               Em caso de sucesso, retornar a variável retval com valor 0.
#
retval=0								# retorna indicação de sucesso
return $retval
# fim do arquivo SHELL complementar, específico a modelagem da base de dados realizada

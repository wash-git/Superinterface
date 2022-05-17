#		Arquivo SHELL complementar para realizar INSERTs de informações na base de dados
#		Arquivo chamado da rotina do vigilante no procedimento de inserção de novos arquivos no acervo.
#		Trata-se de um código específico fruto da modelagem da base de dados de uma aplicação em particular.
#		Este arquivo deve ser modificado conforme cada aplicação.
#
#		Indicação de erro/sucesso: é importante verificar se cada comando foi executado corretamente.  
#		Em caso de erro, fazer retornar a variável retval com um valor numérico diferente de 0.
#		Em caso de sucesso, retornar a variável retval com valor 0.
#
#		Pela modelagem realizada, o Giramundonics irá possibilitar a busca por duas maneiras:
#		- por instituição;
#		- pela cidade.
#		Além de buscar por uma terceira forma que é pelo nome do arquivo.
#		Vamos então fazer a preparação das tabelas para possibilitar estas buscas do Giramundonics.
#
# ###################### Bloco 1: gerar arquivo temporário em letras maiúsculas #####################
#
#						instituições
rm -rf  $CPPTEMP/super_temp_instituicoes_maiusculas.txt
mysql --skip-column-names --raw -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'select * from su_nomes_instituicoes' |  sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' |  tr [:lower:] [:upper:] > $CPPTEMP/super_temp_instituicoes_maiusculas.txt
if [ $? -ne 0 ]; then
	retval=1
	return $retval
fi
#						cidades
rm -rf  $CPPTEMP/super_temp_cidades_maiusculas.txt
mysql --skip-column-names --raw -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE -e 'select * from su_nomes_cidades' |  sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' |  tr [:lower:] [:upper:] > $CPPTEMP/super_temp_cidades_maiusculas.txt
if [ $? -ne 0 ]; then
	retval=2
	return $retval
fi
#
# ###################### Bloco 2: gerar as ocorrências ################################################
#
#						instituições
cat $CPPTEMP/super_temp_instituicoes_maiusculas.txt | sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' | awk 'BEGIN{FS=","}{print "grep -Howi \""$1"\" '$CPPWORK'/*.txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA' | awk '\''BEGIN{FS=\":\"}{print $2\", \"$1}'\'' | sort | uniq -c | sed '\''s/\\, /\\,/g'\'' | sed '\''s/   /  /g'\''| sed '\''s/  / /g'\'' | sed '\''s/  //g'\'' | awk '\''{guarda=$1; $1=\"\"; print $0\",\"guarda;}'\''"}' > $CPPTEMP/super_temp_ocorrencias_instituicoes.bash 2>/dev/null	
if [ $? -ne 0 ]; then
		retval=3
		return $retval
fi
bash $CPPTEMP/super_temp_ocorrencias_instituicoes.bash > $CPPTEMP/super_temp_ocorrencias_instituicoes.txt 2> /dev/null
if [ $? -ne 0 ]; then
		retval=4
		return $retval
fi
#						cidades
cat $CPPTEMP/super_temp_cidades_maiusculas.txt | sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' | awk 'BEGIN{FS=","}{print "grep -Howi \""$1"\" '$CPPWORK'/*.txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA' | awk '\''BEGIN{FS=\":\"}{print $2\", \"$1}'\'' | sort | uniq -c | sed '\''s/\\, /\\,/g'\'' | sed '\''s/   /  /g'\''| sed '\''s/  / /g'\'' | sed '\''s/  //g'\'' | awk '\''{guarda=$1; $1=\"\"; print $0\",\"guarda;}'\''"}' > $CPPTEMP/super_temp_ocorrencias_cidades.bash 2>/dev/null
if [ $? -ne 0 ]; then
		retval=5
		return $retval
fi
bash $CPPTEMP/super_temp_ocorrencias_cidades.bash > $CPPTEMP/super_temp_ocorrencias_cidades.txt 2> /dev/null
if [ $? -ne 0 ]; then
		retval=6
		return $retval
fi
rm -f $CPPTEMP/super_temp_ocorrencias_cidades.bash $CPPTEMP/super_temp_ocorrencias_instituicoes.bash
#
# ###################### Bloco 3: preparar aquivo SQL para popular tabela de ocorrências ################
#
#						para tabela su_docs_instituicoes
cat $CPPTEMP/super_temp_ocorrencias_instituicoes.txt | sed 's/txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA'/pdf/g' | awk 'BEGIN{FS=","}{gsub(/^ /,"",$1);print "insert into su_docs_instituicoes (id_instituicao, id_documento, ocorrencia_inst) values ((select id_chave_instituicao from su_instituicoes where instituicao_sem_acentuacao=\""$1"\" limit 1),(select id_chave_documento from su_documents where photo_filename_documento like \""$2"\" limit 1),"$3");"}' > $CPPTEMP/super_temp_popular_su_docs_instituicoes.sql
if [ $? -ne 0 ]; then
		retval=7
		return $retval
fi
#													trocar indicação de pastas: de temporária para a pasta de imagens
sed "s#$CPPWORK#$CPPIMAGEM#g" -i $CPPTEMP/super_temp_popular_su_docs_instituicoes.sql
if [ $? -ne 0 ]; then
		retval=8
		return $retval
fi
#
#						para tabela su_docs_cidades
cat $CPPTEMP/super_temp_ocorrencias_cidades.txt | sed 's/txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA'/pdf/g' | awk 'BEGIN{FS=","}{gsub(/^ /,"",$1);print "insert into su_docs_cidades (id_cidade, id_documento, ocorrencia) values ((select id_chave_cidade from su_cidades where cidade_sem_acentuacao=\""$1"\" limit 1),(select id_chave_documento from su_documents where photo_filename_documento like \""$2"\" limit 1),"$3");"}' > $CPPTEMP/super_temp_popular_su_docs_cidades.sql
if [ $? -ne 0 ]; then
		retval=9
		return $retval
fi
#													trocar indicação de pastas: de temporária para a pasta de imagens
sed "s#$CPPWORK#$CPPIMAGEM#g" -i $CPPTEMP/super_temp_popular_su_docs_cidades.sql
if [ $? -ne 0 ]; then
		retval=10
		return $retval
fi
rm -f $CPPTEMP/super_temp_ocorrencias_cidades.txt $CPPTEMP/super_temp_ocorrencias_instituicoes.txt
#
# ###################### Bloco 4: preparar arquivo SQL visando popular outras tabelas ########################
#
find $CPPWORK/*.[pP][dD][fF] | grep -i pdf | sed $'s/\//\t\t /g' | awk '{guarda=$NF; printf "insert into su_documents (photo_filename_documento, alt_foto_jpg, nome_documento) values (\"'$CPPIMAGEM'/"$NF"\",";gsub(/\.pdf/,"", $NF); printf "\"'$CPPIMAGEM'/"$NF"_pagina1.jpg\",\"" ; gsub(/-/," ",$NF); gsub(/_/," ",$NF); print $NF"\");"; out=""; print "insert into su_docs_signatarios (id_signatario, id_documento) values (NULL,(select id_chave_documento from su_documents where photo_filename_documento=\"'$CPPIMAGEM'/"guarda"\"));"}' > $CPPTEMP/super_temp_documentos_novospdf.sql
if [ $? -ne 0 ]; then
		retval=11
		return $retval
fi
#
# ###################### Bloco 5: inserir informações na base de dados ########################################
#
for i in "$CPPTEMP"/*.sql; do
	mysql -u $CPBASEUSER -p$CPBASEPASSW -b $CPBASE < "$i"
	if [ $? -ne 0 ];then
			rm -f $CPPTEMP/*.sql 
			retval=12
			return $retval
	fi
done
retval=0					# retorna indicação de sucesso
return $retval
# fim do arquivo SHELL complementar, específico a modelagem da base de dados

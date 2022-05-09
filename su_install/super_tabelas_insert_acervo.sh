#		Arquivo SHELL complementar para a preparação dos INSERTs de informações na base de dados
#		Arquivo chamado da rotina do vigilante para inserir novos arquivos no acervo.
#		Trata-se de um código específico fruto da modelagem da base de dados de uma aplicação em particular.
#		Este arquivo deve ser modificado conforme cada aplicação.
#
#		É importante verificar se cada comando foi executado corretamente.  Em caso de erro, fazer retornar a variável
#		retval com um valor numérico diferente de 0.  Ao final, se tudo foi executado corretamente, fazer
#		a variável retval retornar com valor 0.
#
	#					gerar arquivo com ocorrências das instituicoes nos arquivos TXT
	#fMens	"$FInfor" "$MInfo18"
	cat $CPPADMIN/$CPNOMEINST | sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' | awk 'BEGIN{FS=","}{print "grep -Howi \""$1"\" '$CPPWORK'/*.txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA' | awk '\''BEGIN{FS=\":\"}{print $2\", \"$1}'\'' | sort | uniq -c | sed '\''s/\\, /\\,/g'\'' | sed '\''s/   /  /g'\''| sed '\''s/  / /g'\'' | sed '\''s/  //g'\'' | awk '\''{guarda=$1; $1=\"\"; print $0\",\"guarda;}'\''"}' > $CPPLOG/super_temp_ocorrencias_instituicoes.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		#fMens "$FInsu4" "$MErr50"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_ocorrencias_instituicoes.bash
		retval=1
		return $retval
	fi
	bash $CPPLOG/super_temp_ocorrencias_instituicoes.bash > $CPPLOG/super_temp_ocorrencias_instituicoes.txt 2> /dev/null
	if [ $? -eq 0 ]; then
		#fMens "$FSucss" "$MInfo13"
		rm -f $CPPLOG/super_temp_ocorrencias_instituicoes.bash
	else
		#fMens "$FInsu4" "$MErr50"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_ocorrencias_instituicoes.bash $CPPLOG/super_temp_ocorrencias_instituicoes.txt 
		retval=2
		return $retval
	fi
	#													gerar arquivo SQL para popular tabela su_docs_instituicoes
	cat $CPPLOG/super_temp_ocorrencias_instituicoes.txt | sed 's/txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA'/pdf/g' | awk 'BEGIN{FS=","}{gsub(/^ /,"",$1);print "insert into su_docs_instituicoes (id_instituicao, id_documento, ocorrencia_inst) values ((select id_chave_instituicao from su_instituicoes where instituicao_sem_acentuacao=\""$1"\" limit 1),(select id_chave_documento from su_documents where photo_filename_documento like \""$2"\" limit 1),"$3");"}' > $CPPLOG/super_temp_popular_su_docs_instituicoes.sql
	if [ $? -ne 0 ]; then
		#fMens "$FInsu4" "$MErr51"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_popular_su_docs_instituicoes.sql $CPPLOG/super_temp_ocorrencias_instituicoes.txt 
		retval=3
		return $retval
	fi
	#													trocar indicação de pastas: de temporária para a pasta de imagens
	sed "s#$CPPWORK#$CPPIMAGEM#g" -i $CPPLOG/super_temp_popular_su_docs_instituicoes.sql
	if [ $? -eq 0 ]; then
		:
	#		fMens "$FSucss" "$MInfo37"
	else
		#fMens "$FInsu4" "$MErr51"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_popular_su_docs_instituicoes.sql $CPPLOG/super_temp_ocorrencias_instituicoes.txt 
		retval=4
		return $retval
	fi
	rm -f $CPPLOG/super_temp_ocorrencias_instituicoes.txt
	#													gerar arquivo com ocorrências das cidades nos arquivos TXT
	#fMens "$FInfor" "$MInfo15"
	cat $CPPADMIN/$CPNOMECIDADES | sed 'y/áÁàÀãÃâÂéÉêÊíÍóÓõÕôÔúÚçÇ/aAaAaAaAeEeEiIoOoOoOuUcC/' | awk 'BEGIN{FS=","}{print "grep -Howi \""$1"\" '$CPPWORK'/*.txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA' | awk '\''BEGIN{FS=\":\"}{print $2\", \"$1}'\'' | sort | uniq -c | sed '\''s/\\, /\\,/g'\'' | sed '\''s/   /  /g'\''| sed '\''s/  / /g'\'' | sed '\''s/  //g'\'' | awk '\''{guarda=$1; $1=\"\"; print $0\",\"guarda;}'\''"}' > $CPPLOG/super_temp_ocorrencias_cidades.bash 2>/dev/null
	if [ $? -ne 0 ]; then
		#fMens "$FInsu4" "$MErr14"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_ocorrencias_cidades.bash
		retval=5
		return $retval
	fi
	bash $CPPLOG/super_temp_ocorrencias_cidades.bash > $CPPLOG/super_temp_ocorrencias_cidades.txt 2> /dev/null
	if [ $? -eq 0 ]; then
		#fMens "$FSucss" "$MInfo16"
		rm -f $CPPLOG/super_temp_ocorrencias_cidades.bash
	else
		#fMens "$FInsu4" "$MErr14"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_ocorrencias_cidades.bash $CPPLOG/super_temp_ocorrencias_cidades.txt 
		retval=6
		return $retval
	fi
	#													gerar arquivo de instruções SQL para popular tabela su_docs_cidades
	cat $CPPLOG/super_temp_ocorrencias_cidades.txt | sed 's/txt.'$CPACENTO'.'$CPCONTRL'.'$CPMAIUSCULA'/pdf/g' | awk 'BEGIN{FS=","}{gsub(/^ /,"",$1);print "insert into su_docs_cidades (id_cidade, id_documento, ocorrencia) values ((select id_chave_cidade from su_cidades where cidade_sem_acentuacao=\""$1"\" limit 1),(select id_chave_documento from su_documents where photo_filename_documento like \""$2"\" limit 1),"$3");"}' > $CPPLOG/super_temp_popular_su_docs_cidades.sql
	if [ $? -ne 0 ]; then
		#fMens "$FInsu4" "$MErr15"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_popular_su_docs_cidades.sql $CPPLOG/super_temp_ocorrencias_cidades.txt 
		retval=7
		return $retval
	fi
	#													trocar indicação de pastas: de temporária para a pasta de imagens
	sed "s#$CPPWORK#$CPPIMAGEM#g" -i $CPPLOG/super_temp_popular_su_docs_cidades.sql
	if [ $? -eq 0 ]; then
		:
	#		fMens "$FSucss" "$MInfo17"
	else
		#fMens "$FInsu4" "$MErr15"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.	# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_popular_su_docs_cidades.sql $CPPLOG/super_temp_ocorrencias_cidades.txt 
		retval=8
		return $retval
	fi
	rm -f $CPPLOG/super_temp_ocorrencias_cidades.txt
	#												preparar arquivo SQL visando popular as tabelas:
#	find $CPPWORK/*.[pP][dD][fF] | grep -i pdf | sed $'s/\//\t\t /g' | awk '{guarda=$NF; printf "insert into su_documents (photo_filename_documento, alt_foto_jpg, nome_documento) values (\"'$CPPIMAGEM'/"$NF"\",";gsub(/\.pdf/,"", $NF); printf "\"'$CPPIMAGEM'/"$NF"_pagina1.jpg\",\"" ; gsub(/-/," ",$NF); gsub(/_/," ",$NF); print $NF"\");"; out=""; print "insert into su_docs_signatarios (id_signatario, id_documento) values ((select id_chave_registrado from su_registrados where nome_registrado like \"signatário indefinido\"),(select id_chave_documento from su_documents where photo_filename_documento=\"'$CPPIMAGEM'/"guarda"\"));"; print "insert into su_docs_instituicoes (id_instituicao, id_documento) values ((select id_chave_instituicao from su_instituicoes where nome_instituicao like \"Instituição Indefinida\"),(select id_chave_documento from su_documents where photo_filename_documento=\"'$CPPIMAGEM'/"guarda"\"));"}' > $CPPLOG/super_temp_documentos_novospdf.sql
	find $CPPWORK/*.[pP][dD][fF] | grep -i pdf | sed $'s/\//\t\t /g' | awk '{guarda=$NF; printf "insert into su_documents (photo_filename_documento, alt_foto_jpg, nome_documento) values (\"'$CPPIMAGEM'/"$NF"\",";gsub(/\.pdf/,"", $NF); printf "\"'$CPPIMAGEM'/"$NF"_pagina1.jpg\",\"" ; gsub(/-/," ",$NF); gsub(/_/," ",$NF); print $NF"\");"; out=""; print "insert into su_docs_signatarios (id_signatario, id_documento) values ((select id_chave_registrado from su_registrados where nome_registrado like \"signatário indefinido\"),(select id_chave_documento from su_documents where photo_filename_documento=\"'$CPPIMAGEM'/"guarda"\"));"}' > $CPPLOG/super_temp_documentos_novospdf.sql
	if [ $? -eq 0 ]; then
		:
	#		fMens "$FSucss" "$MInfo04"
	else
		#fMens "$FInsu4" "$MErr22"
		#mv -f $CPPWORK/*.[pP][dD][fF] $CPPQUARENTINE/.			# enviar os arquivos PDF para quarentena
		#rm -f $CPPWORK/*.*
		#rm -f $CPPLOG/super_temp_*.sql 2>/dev/null
		retval=9
		return $retval
	fi
	retval=0
	return $retval
# fim do arquivo SHELL complementar, específico a modelagem da base de dados

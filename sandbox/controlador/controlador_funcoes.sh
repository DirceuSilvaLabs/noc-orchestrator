
# Verificar dependencias
function Dependencias(){
	if [ "$1" == "verificar" ]
	then
		$CMD_CLEAR
		if [ -z "$SISTEMA_OPERACIONAL"  ]
        	then
			DetectaSO SISTEMA_OPERACIONAL
			if [ -z "$SISTEMA_OPERACIONAL"  ]
			then
				echo "Sistema Operacional não suportado"
				echo "Cancelando a execução deste script...."
				exit
			fi

			DetectaDistribuicaoLinux DISTRIBUICAO
			if [ -z  "$DISTRIBUICAO"  ]
                	then
                        	echo "Distribuição não suportada"
                        	echo "Cancelando a execução deste script...."
                        	exit
                	fi
        	fi


		echo "Sistema Operacional: $SISTEMA_OPERACIONAL"
		echo "Distribuição: $DISTRIBUICAO"


		echo "INICIANDO VERIFICAÇÃO DOS PACOTES PYTHON"
		#VerificaPacotePython 	
		local filename=$ARQUIVO_PACOTES_PYTHON
		if [ -f $filename ]
		then
			while read -r line
			do
    				name="$line"
			 	CMD_PYTHON -c "import $name" 2>/dev/null && echo "PACOTE $name está instalado" || echo "PACOTE $name NÃO ESTÁ INSTALADO"
				done < "$filename"
		else
			echo "Não foi encontrado o arquivo $filename"
			echo "Favor configurar corretamente a variável ARQUIVO_PACOTES_PYTHON"
			echo "Cancelando a execução deste script...."
                	exit
		fi
	fi
	
	if [ "$1" == "instalar"  ]
	then
		Dependencias verificar
		echo "Instalando os pacotes python necessários"
		echo "Criando virtualenv..."
		$CMD_VIRTUALENV $NOME_VIRTUAL_ENV
		##TODO: Necessário erminar isto...
		#/bin/bash source ./$NOME_VIRTUAL_ENV/bin/activate
		#$CMD_PIP -r $ARQUIVO_PACOTES_PYTHON
		#Dependencias verificar

		
	fi
}


function Instalar(){
	Dependencias instalar
	
}

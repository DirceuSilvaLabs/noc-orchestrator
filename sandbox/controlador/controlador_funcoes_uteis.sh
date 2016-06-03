function ObtemComando(){
    local condition=$(which $1 2>/dev/null | grep -v "not found" | wc -l)
    if [ $condition -eq 0 ] ; then
        echo "Não foi possível encontrar o comando/programa \"$1\" no seu sistema (a procura é realizada via which nos paths do usuário) "
        echo "O script \"$0\" necessita do \"$1\" para ser executado"
        echo "A execução do script está sendo cancelada."
        exit;
    fi
    eval "$2=`which $1`"


}

function AbsorveBufferTeclado(){
        if test -t 0; then
            while read -t 0 notused; do
                read input_temp
            done
        fi

}

function Info(){
        $CMD_CLEAR
        echo "## INFORMACOES DO $0:"
        echo "# CRIADOR: contato318"
        echo "# VERSAO: $VERSAO_SCRIPT"
        echo "# MANTENEDOR DA VERSAO: $MANTENEDOR"        

}



function VerificaPacotePython(){
	ObtemComando pip CMD_PIP
        $CMD_PIP list
}

function DetectaDistribuicaoLinux(){
 # Verificando qual é a distribuicao linux
                if [ -f /etc/lsb-release ]; then
                        . /etc/lsb-release
                        local DISTRO=$DISTRIB_ID
		       #eval  "$1='$DISTRO'"
                elif [ -f /etc/debian_version ]; then
                        local DISTRO=Debian
			#eval  "$1='$DISTRO'"
                        # XXX or Ubuntu
                elif [ -f /etc/redhat-release ]; then
                        local DISTRO=`cat /etc/redhat-release`
			eval  "$1='$DISTRO'"
                        # XXX or CentOS or Fedora
                else
			echo "Distribuição não suportada"

                fi

}

function DetectaSO(){
        if [[ "$OSTYPE" == "linux-gnu" ]]; then
		eval "$1='Linux'"
        elif [[ "$OSTYPE" == "darwin"* ]]; then
                # Mac OSX
                echo "Mac OSX ainda não é suportado... Desculpe ;)"
        elif [[ "$OSTYPE" == "cygwin" ]]; then
                # POSIX compatibility layer and Linux environment emulation for Windows
                echo "Cygwin ainda não é suportado... Desculpe ;)"
        elif [[ "$OSTYPE" == "msys" ]]; then
                # Lightweight shell and GNU utilities compiled for Windows (part of MinGW)
                echo "Msys ainda não é suportado... Desculpe ;)"
        elif [[ "$OSTYPE" == "win32" ]]; then
                # I'm not sure this can happen.
                echo "Windows ainda não é suportado... Desculpe ;)"
        elif [[ "$OSTYPE" == "freebsd"* ]]; then
                echo "Freebsd ainda não é suportado... Desculpe ;)"
        else
                echo "Não foi possível detectar o tipo do Sistema Operacional"
                echo "Não foi possível verificar as dependencias..."
        fi

}


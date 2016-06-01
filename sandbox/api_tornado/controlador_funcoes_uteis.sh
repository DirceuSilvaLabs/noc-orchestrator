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
        read

}


#!/bin/bash

#####################
# INCLUINDO AS LIBS #
#####################
diretorio_atual="$(dirname "$0")"
# Carregando as parametrizacoes do script
source "$diretorio_atual/controlador_parametrizacao.sh"

# Carregando as funcoes uteis
source "$diretorio_atual/controlador_funcoes_uteis.sh"

# Carregando as funcoes
source "$diretorio_atual/controlador_funcoes.sh"


function MenuPrincipal(){
  AbsorveBufferTeclado
  echo "------------------------------------------"
  echo "---> $NOME_APP"
  echo "------------------------------------------"
  echo "Opções:"
  echo
  echo "1. Verificar dependencias"
  echo "2. Instalar"
  echo "3. Reinstalar"
  echo "4. Iniciar $NOME_APP"
  echo "5. Parar $NOME_APP"
  echo "6. Verificar status  $NOME_APP"
  echo "="
  echo "(I)nformações sobre este script"
  echo "(Q)uit / (S)air"
  echo
  echo -n "Qual a opção desejada? "
  read opcao
  case $opcao in
    1) Info; Main ;;
    2) Adicionar ;;
    3) Deletar ;;
    4) Backup ;;
    I|i) Info; $CMD_SLEEP 1 ; Main ;;
    Q|q|S|s) exit ;;
    *) echo "Opção desconhecida." ; $CMD_SLEEP 2 ; Main ;;
  esac
}





##############################################################
# OBTENDO OS CAMINHOS DOS BINARIOS NECESSARIOS PARA O SCRIPT #
#############################################################
ObtemComando clear CMD_CLEAR
ObtemComando sleep CMD_SLEEP


#######################
# CHMADA DA PRINCIPAL #
#######################
function Main(){
    $CMD_CLEAR
    AbsorveBufferTeclado
    MenuPrincipal
}

Main

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

# Comandos utilizados
source "$diretorio_atual/controlador_comandos.sh"

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
    1) Dependencias verificar;read; Main ;;
    2) Instalar;read; Main ;;
    
    I|i) Info ;read; Main ;;
    Q|q|S|s) exit ;;
    *) echo "Opção desconhecida." ; $CMD_SLEEP 2 ; Main ;;
  esac
}






#######################
# CHMADA DA PRINCIPAL #
#######################
function Main(){
    $CMD_CLEAR
    AbsorveBufferTeclado
    MenuPrincipal
}

Main

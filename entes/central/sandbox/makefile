
CONTEXTO = sandbox
SHELL := /bin/bash
CURRENT_DIR:=$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
ROOT_DIR := $(HOME)

NO_COLOR=\x1b[0m
GREEN_COLOR=\x1b[32;01m
RED_COLOR=\x1b[31;01m
ORANGE_COLOR=\x1b[33;01m

OK_STRING=$(GREEN_COLOR)[OK]$(NO_COLOR)
ERROR_STRING=$(RED_COLOR)[ERRORS]$(NO_COLOR)
WARN_STRING=$(ORANGE_COLOR)[WARNINGS]$(NO_COLOR)


#############
# FUNCTIONS #
#############


define pergunta_critical
    echo -e "\t$(RED_COLOR)$(1)$(NO_COLOR) "
		while true; do \
	    read -p '          Informe: (y/n)' yn ; \
	    case $$yn in  \
	        y|Y ) echo "              Continuando..."; break ;; \
	        n|N ) echo "              Ok... saindo, cancelando, desistindo...."; sleep 2; exit 255 ;; \
	        * ) echo "              Por favor, escolha y ou n." ;; \
	     esac ; \
	  done
endef
define msg_critical
    echo -e "$(RED_COLOR)-->[$(1)]$(NO_COLOR)\n"
endef

define msg_warn
    echo -e "$(ORANGE_COLOR)-->[$(1)]$(NO_COLOR)\n"
endef

define msg_ok
    echo -e "$(GREEN_COLOR)-->[$(1)]$(NO_COLOR)\n"
endef

define menu
    echo -e "$(GREEN_COLOR)[$(1)]$(NO_COLOR)"
endef





########################
# BINARIOS E PROGRAMAS #
########################
FIND_MAKE=find $(ROOT_DIR) -name Makefile



.PHONY: ajuda
ajuda: help

.PHONY: limpa_tela
limpa_tela:
	@clear

.PHONY: exec_bash_env
exec_bash_env: ## Run bash (container) simulate .env
	docker run -it --rm --env-file $(CURRENT_DIR)/.env $(CONTEXTO) bash



.PHONY: send_git
send_git: ## Send to git (build, tests and send)
	git pull
	make build
	git add :/ --all && git commit -m "FIX" --all || echo
	git push



.PHONY: build
build: ## Local build
	docker build -t  $(CONTEXTO) .
	@make test-all

.PHONY: test-all
test-all: limpa_tela
	@make test-python
	@make test-pip



.PHONY: test-pip
test-pip:
	@echo ""
	@$(call msg_warn,"pip version...")
	@sleep 1; docker run --name $(CONTEXTO) --rm  -it $(CONTEXTO) pip --version && \
	  echo -e "\t$(GREEN_COLOR)Get pip version = OK $(NO_COLOR) " || \
		echo -e "\t$(RED_COLOR)Get pip version = NOK $(NO_COLOR) "

.PHONY: test-python
test-python:
	@echo ""
	@$(call msg_warn,"Python3 version...")
	@sleep 1; docker run --name $(CONTEXTO) --rm -it $(CONTEXTO) python3 --version | \
	  grep -q "Python " && \
	  echo -e "\t$(GREEN_COLOR)Get python3 version = OK $(NO_COLOR) " || \
		echo -e "\t$(RED_COLOR)Get python3 version = NOK $(NO_COLOR) "


.PHONY: local-inicia
local-inicia: ## Sobe localmente (desenvolvimento)
	@make build
	@$(call msg_ok,"INCIIANDO...")
	@sleep 1; docker run -p 80:80 --name $(CONTEXTO) --rm $(CONTEXTO)  

.PHONY: sair
sair:
	@clear

.PHONY: help
help: limpa_tela
	@$(call menu, "============== $(CONTEXTO) ==============")
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST)  | awk 'BEGIN {FS = ":.*?## "}; {printf "\t\033[36m%-30s\033[0m %s\n", $$1, $$2}'

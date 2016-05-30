# Documentação geral do noc-orchestrator

O sistema foca em executar tarefas de orchestração na infraestrutura de TI de forma assíncrona. 

## Definições utilizadas no projeto
Principais definições do projeto:
* **Procedimento**: Procedimento é a execução de uma ou mais **tarefas**. Importante ressaltar que o procedimento segue o conceito de processo e é representado por um *fluxograma*. Um procedimento sempre será executado para um servidor ou para um grupo de servidores. Neste último caso, na prática, o procedimento é executado unitariamente e separadamente (em paralelo) em cada um dos servidores de determinado grupo.
* **Tarefa**: Unidade básica de execução. Exemplo: Parar um serviço ou criar um usuário. Uma tarefa, sempre que possível, é atrelada a um único módulo do Ansible. Toda tarefa deverá, obrigatoriamente, retornar o status da sua execução, isto é, se a execução ocorreu com sucesso ou com erro.
* **Inventariado**: Conjunto de hosts cadastrados (isto é, servidores que são passíveis de execução de tarefas/procedimentos). Cada host terá uma ou mais etiquetas representando o *grupo* a que pertence.
* **Grupo** de hosts: Um grupo de host nada mais é do que uma flag para realizar o agrupamento lógico de determinados hosts. Um servidor poderá possuir uma ou mais etiqueta, isto é, um mesmo servidor poderá estar em mais de um grupo ao mesmo tempo. 




## Camadas
O projeto foi divido em partes, sendo:

* **Camada de apresentação**:  Camada de gerenciamento e operação do noc-orchestrator. Sub dividida em outras duas camadas:
 * **Frontend**: Camada de apresentação ao usuário.
 * **Backend**: Camada de controle e persistência de dados.
* **Camada de agendamento**: Camada responsável por gerenciar a execução dos procedimentos. Esta camada realiza o agendamento das tarefas nos respectivos nós de execuções e controla o fluxo de execução do procedimento em questão.
* **Nó(s) de execução**:  No ambiente poderá existir um ou mais nó de execução. O nó é responsável pela efetiva execução de determinada tarefa em determinado host alvo.


Cada uma das camadas são autocontidas - possuem seu próprio instalador e a comunicação entre camadas dar-se-á sempre por API Rest.


# Documentação geral do noc-orchestrator


## Definições utilizadas no projeto
Principais definições do projeto:
* **Procedimento**: Procedimento é a execução de uma ou mais **tarefas**. Importante ressaltar que o procedimento segue o conceito de processo e é representado por um *fluxograma*. Um procedimento sempre será executado para um servidor ou para um grupo de servidores. Neste último caso, na prática, o procedimento é executado unitariamente e separadamente (em paralelo) em cada um dos servidores de determinado grupo.
* **Tarefa**: Unidade básica de execução. Exemplo: Parar um serviço ou criar um usuário. Uma tarefa, sempre que possível, é atrelada a um único módulo do Ansible. Toda tarefa deverá, obrigatoriamente, retornar o status da sua execução, isto é, se a execução ocorreu com sucesso ou com erro.
  * **Tipos de tarefas**:
    * **Monitoramento**: tarefa que monitora algum ativo. Exemplo: Verifica o status de um serviço em determinado host, etc.. Futuramente será desenvolvivo um tipo novo de tarefa de monitoramento - que será o monitorameto passivo, a qual receberá de forma passivo dados oriundo de fontes diversas via trap.
    * **Ação/atividade**: tarefa que efetivamente executa uma determinada ação, como: Inicializar um serviço, criar um usuário, etc.
    * **Notificação**: tarefa utilizada para enviar notificação. Incialmente as notificações serão por Email e Telegram.
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



## Visão geral do funcionamento

O funcionamento geral consiste em:
* É criado um determinado procedimento; o qual é composto por tarefas, blocos de decisão e laços de repetição.
* Após a criação do procedimento, o usuário poderá executar (ou agendar a execução) do mesmo.Quando este determinado procedimento for agendado ele é registrado na camada de agendamento (lembrando que todas as execuções são agendadas, para o futuro ou para o presente).
* Quando a camada de agendamento recebe tal procedimento a ser agendado, a camada grava tal requisição. Processos da camada de agendamento verifica a fila de agendamento. Quando chega o momento da execução, o processo começa a processar as respectivas tarefas - para realizar isto o processo envia uma requisição de tarefa para o nó de processamento.
* A tarefa chegando no nó de processamento, entra na fila do mesmo. Processos executores consome tal fila. Após a execução da tarefa, o processo retorna o status da execução para a camada de agendamento. Neste momento, a camada decide o fluxo da execução do procedimento conforme o status retornado.

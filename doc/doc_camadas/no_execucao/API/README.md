#Visão geral da API da Camada do no_execucao




## Entidades da API

Segue descrição das entidades.


### Entidade tarefa

As entidades contidas na API responsável por comunicação com a camada de agendamento são:

* Entidade **tarefa**: esta entidade está responsável por executar as solicitações dada camada de agendamento, esta entidade poderá submeter determinada tarefa para a fila de execução, poderá cancelar determinada tarefa e/ou listar as tarefas (com ou sem filtro).
* 


A entidade **tarefa** possui  métodos responsáveis por processar determinada solicitação, levando em conta o tipo de tarefa.
Os tipos definidos até o momento são:
* **monitoramento**
* **acao**
* **notificacao**


A API da entidade  **tarefa** possui os seguintes métodos:
* Submeter Tarefa (**POST**): Recebe da camada de agendamento os dados necessários com informações de determinada tarefa, ao receber esses dados a API submeterá essa tarefa a uma fila no qual ficará pendente até ser executada.
* Cancelar Tarefa (**DELETE**): Este método tem como principal papel cancelar uma tarefa que está na fila caso seja necessário.
* Consultar Todas as Tarefas (**GET**): Seu papel é retornar uma lista com todos as tarefas que estão na fila de acordo com determinado status. 
* Consultar Tarefa por Filtro(**GET**): Seu papel é retornar uma consulta de tarefas com filtro complexo, este método necessariamente precisará de um filtro.


Cada método da entidade Tarefa poderá ser acessado da seguinte forma:


**/app/{versao}/tarefa/{tipo}**

Sendo:

* **{versao}** = Versão desejada da API.
* **{tipo}** =  Tipo de tarefa a ser executada.
* Para casos especiais como o método **Consultar Tarefa por Filtro** será necessário passar por parâmetro um filtro no qual será utilizado para buscar o nó solicitado. Desta forma a url passaria a ser:
 * **/app/{versao}/tarefa/{tipo}/{filtro}**
 

# TODO
Está por fazer:
* Descrição e exemplos de testes internos e externos. Isto será realizado quando a API estiver funcional;
* Mapa de dados de input e output. Será descrito já na primeira versão da API








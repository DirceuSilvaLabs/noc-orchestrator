<?php
namespace Model\Client;
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}

use Model\Banco\Organizacao;

class Organizacao extends Client{
	
	public function __construct($aRequest){
		parent::__construct($aRequest);
	}
	
	public function salvar(){
		$params = $this->_request['params'];
		$organizacao = new Organizacao();
		$organizacao->setEmail($params['email']);
		$organizacao->setNome($params['nome']);
		$organizacao->setResponsavel($params['responsavel']);
		return $organizacao->salvar();
	}
	
	public function listarTodos(){
		$org = new Organizacao();
		$todos = $org->listarTodos();
		$lista = array();
		foreach ($todos as $v){
			$lista[] = $v->toArray();
		}
		return $lista;
	}
	
	public function buscarPorId(){
		$org = new Organizacao();
		return $org->buscarPorId($this->_request['params'])->toArray();
	}
	
}
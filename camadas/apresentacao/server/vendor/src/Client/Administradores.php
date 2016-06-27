<?php
namespace Model\Client;
if (strcmp ( basename ( $_SERVER ['SCRIPT_NAME'] ), basename ( __FILE__ ) ) === 0) {
	exit ( "Acesso negado" );
}

use Model\Banco\Administradores as Adm;
use Model\Client\Token;

class Administradores extends Client {
	
	public function __construct($aRequest) {
		parent::__construct ( $aRequest );
	}
	
	public function salvar() {
		$params = $this->_request ['params'];
		$administradores = new Adm ();
		$administradores->setNome($params['nome']);
		$administradores->setEmail ( $params ['email'] );
		$administradores->setOrganizacao ( $params ['organizacao'] );
		return $administradores->salvar();
		
	}
	public function listarTodos() {
		$ad = new Adm ();
		$todos = $ad->listarTodos ();
		$lista = array ();
		foreach ( $todos as $v ) {
			$lista [] = $v->toArray ();
		}
		return $lista;
	}
	
	function buscarPorId(){
		$ad = new Adm();
		return $ad->buscarPorId($this->_request['params'])->toArray();
	}
	
	function buscaPorOrganizacao(){
		$ad = new Adm();
		$todos = $ad->buscarPorOrganizacao($this->_request['params'])->toArray();
	 	$lista = array();
	 	foreach ($todos as $v){
	 		$lista[] = $v->toArray();
	 	}
	 	
	 	return $lista;
	}
	
	function excluir(){
		$ad = new Adm();
		$ad->excluir($this->_request['params']);
		return true;
	}
}
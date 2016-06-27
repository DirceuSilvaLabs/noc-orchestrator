<?php

namespace Model\Client;

if (strcmp ( basename ( $_SERVER ['SCRIPT_NAME'] ), basename ( __FILE__ ) ) === 0) {
	exit ( "Acesso negado" );
}

use Model\Banco\Token as TokenBanco;

class Token extends Client {
	public function __construct($aRequest) {
		parent::__construct ( $aRequest );
	}
	private function gerarCodigo() {
		return substr ( md5 ( uniqid ( rand (), true ) ), 0, 8 );
	}
	public function salvar($aOrganizacao) {
		$params = $this->_request ['params'];
		$token = new TokenBanco ();
		$token->setIdOrganizacao ( $params ['organizacao'] );
		$token->setCodigo ( $this->gerarCodigo () );
		$token->setValidade ( '2016-01-01 00:00:00' );
		return $token->salvar ();
	}
	public function buscar() {
		$to = new TokenBanco ();
		return $to->buscarPorId ( $this->_request ['params'] )->toArray ();
	}
	public function listarTodos() {
		$ad = new TokenBanco ();
		$todos = $ad->listarTodos ();
		$lista = array ();
		foreach ( $todos as $v ) {
			$lista [] = $v->toArray ();
		}
		return $lista;
	}
}
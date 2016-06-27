<?php

namespace Model\Banco;

if (strcmp ( basename ( $_SERVER ['SCRIPT_NAME'] ), basename ( __FILE__ ) ) === 0) {
	exit ( "Acesso negado" );
}
class Token {
	private $id;
	private $IdOrganizacao;
	private $codigo;
	private $validade;
	public function __construct() {
	}
	public function __destruct() {
	}
	public function getId() {
		return $this->id;
	}
	public function setId($aId) {
		$this->id = $aId;
	}
	public function getIdOrganizacao() {
		return $this->organizacao;
	}
	public function setIdOrganizacao($aOrganizacao) {
		$this->organizacao = $aOrganizacao;
	}
	public function getCodigo() {
		return $this->codigo;
	}
	public function setCodigo($aCodigo) {
		$this->codigo = $aCodigo;
	}
	public function getValidade() {
		return $this->validade;
	}
	public function setValidade($aValidade) {
		$this->validade = $aValidade;
	}
	private function criarTabela() {
		$sql = "
				CREATE TABLE IF NOT EXISTS `token` (
				`id` int(10)auto_increment,
				`id_organizacao` int(10),
				`codigo` varchar(9),
				`validade` TIMESTAMP,
				PRIMARY KEY(`id`)
				)ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";
		
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ();
		return true;
	}
	public function salvar() {
		$this->criarTabela ();
		$sql = "INSERT INTO token (id_organizacao, codigo, validade) VALUES (:id_organizacao, :codigo, :validade)";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ( [ 
				':id_organizacao' => $this->getOrganizacao (),
				':codigo' => $this->getCodigo (),
				':validade' => $this->getValidade () 
		] );
		$id = Conexao::getInstance ()->lastInsertId ();
		return $id;
	}
	public function buscarPorId($aId) {
		$sql = "SELECT codigo FROM token WHERE id_organizacao =:id";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ( [ 
				':id' => $aId 
		] );
		return $p->fetchObject ( __CLASS__ );
	}
	public function toArray() {
		$atributos = get_object_vars ( $this );
		foreach ( $atributos as $k => $v ) {
			if (preg_match ( "/^_/", $k )) {
				unset ( $atributos [$k] );
			}
		}
		return $atributos;
	}
	public function listarTodos() {
		$sql = "SELECT * FROM token";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ();
		$lista = array ();
		while ( $row = $p->fetchObject ( __CLASS__ ) ) {
			$lista [] = $row;
		}
		return $lista;
	}
}
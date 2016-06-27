<?php

namespace Model\Banco;

if (strcmp ( basename ( $_SERVER ['SCRIPT_NAME'] ), basename ( __FILE__ ) ) === 0) {
	exit ( "Acesso negado" );
}
use Model;

class Organizacao {
	private $id;
	private $nome;
	private $responsavel;
	private $email;
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
	public function getNome() {
		return $this->nome;
	}
	public function setNome($aNome) {
		$this->nome = $aNome;
	}
	public function getResponsavel() {
		return $this->responsavel;
	}
	public function setResponsavel($aResponsavel) {
		$this->responsavel = $aResponsavel;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($aEmail) {
		$this->email = $aEmail;
	}
	private function criarTabela() {
		$sql = "
			CREATE TABLE IF NOT EXISTS `organizacao`(
				`id` int(10) auto_increment,
				`nome` varchar(255) ,
				`responsavel` varchar(255) ,
				`email` varchar(255) ,
				PRIMARY KEY(`id`)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8;		
		";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ();
		return true;
	}
	public function salvar() {
		$this->criarTabela ();
		$sql = "INSERT INTO organizacao(nome,responsavel, email) 
				VALUES (:nome, :resposanvel, :email)";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ( [ 
				':nome' => $this->getNome (),
				':resposanvel' => $this->getResponsavel (),
				':email' => $this->getEmail () 
		] );
		$id = Conexao::getInstance ()->lastInsertId ();
		return $id;
	}
	public function buscarPorId($aId) {
		$sql = "SELECT * FROM organizacao WHERE id =:id";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ( [ 
				':id' => $aId 
		] );
		return $p->fetchObject ( __CLASS__ );
	}
	public function listarTodos() {
		$sql = "SELECT * FROM organizacao";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ();
		$lista = array ();
		while ( $row = $p->fetchObject ( __CLASS__ ) ) {
			$lista [] = $row;
		}
		return $lista;
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
}
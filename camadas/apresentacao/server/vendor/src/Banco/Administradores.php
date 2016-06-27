<?php

namespace Model\Banco;

if (strcmp ( basename ( $_SERVER ['SCRIPT_NAME'] ), basename ( __FILE__ ) ) === 0) {
	exit ( "Acesso negado" );
}
class Administradores {
	private $id;
	private $nome;
	private $email;
	private $organizacao;
	
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
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($aEmail) {
		$this->email = $aEmail;
	}
	public function getSenha() {
		return $this->senha;
	}
	public function setSenha($aSenha) {
		$this->senha = $aSenha;
	}
	public function getOrganizacao() {
		return $this->organizacao;
	}
	public function setOrganizacao($aOrganizacao) {
		$this->organizacao = $aOrganizacao;
	}
	private function criarTabela() {
		$sql = "
			CREATE TABLE IF NOT EXISTS `administradores`(
				`id` int(10) auto_increment,
				`id_organizacao` int(10),
				`nome` varchar(255) ,
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
		$sql = "INSERT INTO administradores(id_organizacao, nome, email)
				VALUES (:id_organizacao, :nome, :email)";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ( [ 
				':id_organizacao' => $this->getOrganizacao (),
				':nome' => $this->getNome (),
				':email' => $this->getEmail ()
		] );
		$id = Conexao::getInstance ()->lastInsertId ();
		return $id;
	}
	public function buscarPorId($aId) {
		$sql = "SELECT * FROM administradores WHERE id =:id";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ( [ 
				':id' => $aId 
		] );
		return $p->fetchObject ( __CLASS__ );
	}
	public function listarTodos() {
		$sql = "SELECT * FROM administradores";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ();
		$lista = array ();
		while ( $row = $p->fetchObject ( __CLASS__ ) ) {
			$lista [] = $row;
		}
		return $lista;
	}
	public function buscarPorOrganizacao($aIdOrganizacao) {
		$sql = "SELECT * FROM administradores WHERE id_organizacao =:id_organizacao";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ( [ 
				':id_organizacao' => $aIdOrganizacao 
		] );
		$lista = array ();
		while ( $row = $p->fetchObject ( __CLASS__ ) ) {
			$lista [] = $row;
		}
		return $lista;
	}
	public function excluir($aId) {
		$sql = "DELETE FROM administradores WHERE id = :id";
		$p = Conexao::getInstance ()->prepare ( $sql );
		$p->execute ();
		return true;
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
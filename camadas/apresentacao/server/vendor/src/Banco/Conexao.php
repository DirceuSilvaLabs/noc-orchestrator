<?php
namespace Model\Banco;
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}

use \PDO;

class Conexao { 

	public static $instance;
	const HOST = 'localhost';
	const BANCO = "noc_orchestrator";
	const USUARIO = "root";
	const PASSWORD = "";
	
	private function __construct() { 
		
	} 

	public static function getInstance() { 
		if (!isset(self::$instance)) { 
			self::$instance = new PDO(
					'mysql:host='.Conexao::HOST.';dbname='.Conexao::BANCO, 
					Conexao::USUARIO, Conexao::PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING); 
			self::$instance->setAttribute(PDO::ATTR_PERSISTENT, true);
		}
		return self::$instance; 
	} 
}

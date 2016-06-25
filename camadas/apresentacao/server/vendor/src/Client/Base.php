<?php
namespace Model\Client;
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}

use Model\Banco\Conexao;
use Model\Sistema\Util;

class Base extends Client{
	
	public function __construct($aRequest){
		parent::__construct($aRequest);
	}

	public function salvar(){
		
	}
	
	public function dados(){
		$sql = "select * from db where db = :db and grant_priv = :gp";
		
		$p = Conexao::getInstance()->prepare($sql);
		$p->execute([
				':db'=>$this->_request['params']['db'],
				':gp'=>$this->_request['params']['gp']
		]);
		
		$lista = array();
		while($row = $p->fetch(\PDO::FETCH_ASSOC)){
			$r = array();
			foreach ($row as $k=>$v){
				$r[Util::underlineToMaiuscula($k)] = $v;
			}
			$lista[] = $r;
		}
		return $lista;
		
	}
	
}
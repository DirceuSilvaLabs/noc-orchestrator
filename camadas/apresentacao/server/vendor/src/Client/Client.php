<?php
namespace Model\Client;
date_default_timezone_set("America/Sao_Paulo");
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}
// ini_set("display_errors",1);
// ini_set("display_startup_erros",1);
// error_reporting(E_ALL);

class Client{
	protected $_request;
	
	public function __construct($aRequest){
		$this->_request = $aRequest;
	}
}
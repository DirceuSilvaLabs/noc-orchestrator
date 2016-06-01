<?php
namespace Model\Client;
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}

class Client{
	protected $_request;
	
	public function __construct($aRequest){
		$this->_request = $aRequest;
	}
}

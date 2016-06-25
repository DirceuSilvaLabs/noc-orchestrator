<?php
namespace Model\Client;
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}


class Teste extends Client{
	
	public function __construct($aRequest){
		parent::__construct($aRequest);
	}
	
	public function teste(){
		$org = new Organizacao($this->_request);
		return $org->salvar();
	}
}
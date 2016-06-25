<?php
namespace Model\Client;
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}

class Base extends Client{
	
	public function __construct($aRequest){
		parent::__construct($aRequest);
	}
	
}
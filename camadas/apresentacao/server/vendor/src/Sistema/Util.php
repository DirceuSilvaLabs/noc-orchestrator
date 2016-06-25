<?php
namespace Model\Sistema;

date_default_timezone_set("America/Sao_Paulo");
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}
// ini_set("display_errors",1);
// ini_set("display_startup_erros",1);
// error_reporting(E_ALL);

class Util { 

	public static function maiusculaToUnderline($aString = ""){
		$txt = "";
		$letras = str_split($aString);
		foreach ($letras as $k => $v){
			if($k == 0){
				$v = strtolower($v);
			}
				
			if(strcmp($v, strtoupper($v)) == 0){
				$v = "_".strtolower($v);
			}
				
			$txt .= $v;
		}
	
		return $txt;
	}
	
	public static function underlineToMaiuscula($aString = "", $aPrimeiraMaiuscula = false){
		$txt = "";
		$letras = str_split($aString);
		$muda = false;
		$primeiraLetra = true;
		foreach ($letras as $k => $v){
			if($muda){
				$muda = false;
				$v = strtoupper($v);
			}
				
			if($v === "_"){
				$muda = true;
			}else{
	
				if($primeiraLetra){
					if($aPrimeiraMaiuscula){
						$v = strtoupper($v);
					}else{
						$v = strtolower($v);
					}
					$primeiraLetra = false;
				}
	
				$txt .= $v;
			}
		}
	
		return $txt;
	}
}

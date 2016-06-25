<?php
namespace Model\Sistema;
if(strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){ exit("Acesso negado");}

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

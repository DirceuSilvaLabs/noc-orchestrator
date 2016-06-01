<!DOCTYPE html>
<html data-ng-app="app" data-ng-controller="appController">
    <head>
		<meta charset="utf-8">
<style>
	table, tr, td, th{
		border: solid 1px black;
		border-collapse: collapse;
	}
	table{
		width:100%;
	}
	body{
		padding:0px;
		margin:0px;
		font-size: 12px;
	}
</style>
</head>
<body>
<table border='1'>

<?php
require_once 'vendor/autoload.php';
date_default_timezone_set("America/Sao_Paulo");
ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);

//define o tipo de retorno deve ser json
// header('Content-Type: application/json');

use Model\Banco\SistemaConexao;
try{
	//pega o request
	$request = json_decode(file_get_contents("php://input"), true);
	if(!$request){
		$request = $_REQUEST;
	}
	
	//verifica o tipo de retorno se é download ou apenas html
	if(isset($request['params']['tipo'])){
		if($request['params']['tipo']=='d'){
			header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
			header("Content-Disposition: inline; filename=resultado.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
	}
	
	//pega a classe.metodo e remove caracteres especiais
	$method = preg_replace('/[^0-9a-zA-Z\.]/','',$request["method"]);
	
	//pega os params
	$params = $request["params"];
	
	//pega a auth
	$auth = $request["auth"];
	
	//pega o id da requisição
	$id = $request["id"];
	
	//separa a classe do método
	$classe_metodo = explode(".", $method);
	
	//define o pacote da classe, requisição do cliente deve obrigatóriamente direcionar para o pacote client
	$classe = "Model\\Client\\".$classe_metodo[0];
	
	//cria uma instancia da classe passando os parametros e definidio o lazy como falso
	$objeto = new $classe($request, false);
	
	//pega o resultado do método solicitado
	$result = $objeto->$classe_metodo[1]();
	$keys = array();
	$linha0 = true;
	foreach ($result as $k => $v){
		if($linha0){
			echo '<thead><tr>';
			foreach ($v as $kk => $vv) {
				$_col = strtoupper($kk) === $kk?$kk:strtoupper(SistemaConexao::maiusculaToUnderline($kk));
				
				echo '<th>'.$_col.'</th>';
				$keys[] = $kk;
			}
			echo '</thead></tr>';
			echo '<tbody>';
			$linha0 = false;
		}
		
		echo '<tr>';
		foreach ($keys as $vv) {

			$valor = trim($v[$vv]);
			if(is_float($valor)){
				$valor = number_format($valor, 2, ',', '.');
			}
			echo '<td>'.$valor.'</td>';
		}
		echo '</tr>';
// 		if($k > 10){
// 			break;
// 		}
	}
	if(count($result)>0){
		echo '</tbody>';
	}
	
}catch(\Exception $e){
	echo $e->getMessage();
}

?>
</table>
</body>
</html>
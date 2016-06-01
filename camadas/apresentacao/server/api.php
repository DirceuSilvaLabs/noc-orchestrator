<?php
require_once 'vendor/autoload.php';
date_default_timezone_set("America/Sao_Paulo");
// ini_set("display_errors",1);
// ini_set("display_startup_erros",1);
// error_reporting(E_ALL);

//define o tipo de retorno deve ser json
header('Content-Type: application/json');


try{
	//pega o request
	$request = json_decode(file_get_contents("php://input"), true);
	if(!$request){
		$request = $_REQUEST;
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
	
	//pega o método, pegar o array direto dá erro no PHP7
	$metodo = $classe_metodo[1];
	
	//define o pacote da classe, requisição do cliente deve obrigatóriamente direcionar para o pacote client
	$classe = "Model\\Client\\".$classe_metodo[0];
	
	//cria uma instancia da classe passando os parametros e definidio o lazy como falso
	$objeto = new $classe($request, false);
	
	//pega o resultado do método solicitado
	$result = $objeto->$metodo();
	
	//monta o json para devolução
	$json = array(
			"jsonrpc"=>"2.0",
			"id"=>$request["id"]
	);
	
	//adiciona o resutado no json
	$json["result"] = $result;
	
	//publica o resultado em json
	echo json_encode($json, true);
	
	
}catch(\Exception $e){
	
	//cria array de retorno com erro
	$json = array(
			"jsonrpc"=>"2.0",
			"id"=>$request["id"]
	);
	
	//define o erro
	$json["error"] = array(
			"message"=>$e->getMessage(),//.' ['.$e->getFile().':'.$e->getLine().']',
			"code"=>$e->getCode()
	);
	
	//publica o resultado em json
	echo json_encode($json, true);
}
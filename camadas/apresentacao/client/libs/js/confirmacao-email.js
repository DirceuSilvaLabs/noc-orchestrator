var primeiroAcesso = true;

function validar() {
	let
	codVerificacao = $("#codVerificacao").val();

	if (codVerificacao == '') {
		alert('Informe o código de verificação');

		return false;
	}
	return true;
}

function coolConfirmacaoEmail() {

	if (validar()) {
		verificar()
	}
}

function verificar() {
	let
	dados = {
		jsonrpc : '2.0',
		auth : '',
		id : 1,
		method : 'Token.verifica',
		params : localStorage.getItem("instituica0o")
	};
	console.log(dados);
	alert('Chama reenviar Codigo');
		
	if(primeiroAcesso){
		window.location.href = "adicionar-administradores-locais.html";
	}else{
		window.location.href = "Admin/index.html";
	}
// window.location.href = "adicionar-administradores-locais.html";
	// api(dados);
}

function reenviarEmail() {
	alert('Chama reenviar Codigo');
	return

	let
	dadosReenviarToken = {
		jsonrpc : '2.0',
		auth : '',
		id : 1,
		method : 'Token.gerar',
		params : {
			instituicao : localStorage.getItem("instituicao"),
		}
	}

	$
			.ajax({
				type : "GET",
				data : dadosReenviarToken,
				url : "http://localhost/noc-orchestrator/camadas/apresentacao/server/api.php",
				success : function(aRetorno) {
					alert("Novo Token enviado. Por favor, refaça a comparação");
				}
			})
}

function api(dados) {
	$
			.ajax({
				type : "GET",
				data : dados,
				url : "http://localhost/noc-orchestrator/camadas/apresentacao/server/api.php",
				success : function(aRetorno) {
					if (aRetorno.result) {
						
						if(primeiroAcesso){
							window.location.href = "adicionar-administradores-locais.html";
						}else{
							window.location.href = "Admin/index.html";
						}
					} else {
						alert("Token inválido");
					}
				}
			});
}

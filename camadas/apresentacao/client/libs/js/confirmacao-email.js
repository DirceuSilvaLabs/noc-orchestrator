function validar() {
	let	codVerificacao = $("#codVerificacao").val();

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
	var dados = {
		jsonrpc : '2.0',
		auth : '',
		id : 1,
		method : 'Token.buscar',
		params : localStorage.getItem("instituicao")
	};
	console.log(dados);

	//api(dados);
	window.location.href = "adicionar-administradores-locais.html";
}

function api(dados) {
	$
			.ajax({
				type : "GET",
				data : dados,
				url : "http://localhost/noc-orchestrator/camadas/apresentacao/server/api.php",
				success : function(aRetorno) {
					console.log(aRetonro);
					if ($("#avancar").val() == aRetorno.toString()) {
						alert('passou')
						window.location.href = "adicionar-administradores-locais.html";

					} else {
						alert("codigo invalido");
					}
				}
			});
}

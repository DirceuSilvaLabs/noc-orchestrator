var retorno;

function validarCadastroOrganizacao() {
	let
	organizacao = $("#Organizacao").val();
	let
	nome = $("#nome").val();
	let
	email = $("#email").val();

	if (organizacao == '') {
		// $.toaster({ priority : 'danger', title : 'Preenchimento Obrigatório',
		// message : 'Informe o nome da Organizacao!'});
		alert("Informe o nome da Organizacao");
		return false;

	} else if (nome == '') {
		alert("Informe o seu nome");
		return false;

	} else if (email == '') {
		alert("Informe o email");
		return false;
	}

	return true;
}

function coolCadastroOrganizacao() {
	if (validarCadastroOrganizacao()) {

		let
		organizacao = $("#organizacao").val();
		let
		responsavel = $("#nome").val();
		let
		email = $("#email").val();

		let
		dados = {
			jsonrpc : '2.0',
			auth : '',
			id : 1,
			method : 'Organizacao.salvar',
			params : {
				nome : organizacao,
				email : email,
				responsavel : responsavel
			}
		};

		api(dados);
		alert('ainda nao envia o codigo por email');
		window.location.href = "confirmacao-email.html";
	}

	function api(dados) {
		$
				.ajax({
					type : "GET",
					data : dados,
					url : "http://localhost/noc-orchestrator/camadas/apresentacao/server/api.php",
					success : function(aRetorno) {
						localStorage.setItem("instituicao", aRetorno.result);
					}
				});
	}

}

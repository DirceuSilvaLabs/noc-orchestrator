$('#lista').on('dblclick', 'li', function() {
	$(this).animate({
		'margin-left' : '+=100'
	}, function() {
		$(this).remove();
	});
});

$('#adicionar').click(
		function() {
			var texto = "Endereço: " + $("#endereco").val() + " | Token: "
					+ $("#Token").val();
			$('<li>').text(texto).css({
				'color' : 'blue',
				'background-color' : 'lightgrey'
			}).appendTo('#lista');
			$("#endereco").val("");
			$("#Token").val("");
		});

function Informacao() {
	alert("Estou implementando");
}
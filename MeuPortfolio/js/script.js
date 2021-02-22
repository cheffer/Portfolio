$(document).ready(() => {

	// Links pags //
	$('#idPagJogos').on('click', () => {
		$.get('jogos.html', data => {
			$('#pagina').html(data);
		})

	})

	$('#idPagProjetos').on('click', () => {
		$.get('projetos.html', data => {
			//console.log(data);
			$('#pagina').html(data);
		})
	})

	$('#idBtnEnviar').on('click', () => {
		$.get('enviar_email.php', data => {
			//console.log(data);
			$('#pagina').html(data);
		})
	})
	// Links pags //
	
})
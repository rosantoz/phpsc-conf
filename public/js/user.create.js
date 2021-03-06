$(document).ready(function() {
	$('#userForm').submit(function () {
		$('#userForm button').prop('disabled', true);
		$('html, body').animate({scrollTop:0}, 'fast');
		
		$.ajax(
			{
				url: $('#userForm').prop('action'),
				type: $('#userForm').prop('method').toUpperCase(),
				data: {
					name: $('#name').val(),
					email: $('#email').val(),
					bio: $('#bio').val()
				},
				success: function(response)
				{
					$('.alert').removeClass('alert-danger')
							   .removeClass('alert-success')
							   .removeClass('alert-info');
					
					if (response.error) {
						$('.alert h4').html('Erro ao realizar seu cadastro');
						$('.alert span').html(response.error);
						$('.alert').addClass('alert-danger').fadeIn();
						
						$('#userForm button').prop('disabled', false);
						
						return ;
					}
					
					$('.alert h4').html('Cadastro realizado com sucesso');
					$('.alert span').html('Seja bem vindo @' + response.data.username + '!');
					$('.alert').addClass('alert-success').fadeIn();
					
					if (response.redirectTo) {
						setTimeout(
							function()
							{
								window.location = baseUrl + response.redirectTo;
							},
							1000
						);
					}
				}
			}
		);
		
		return false;
	});
});
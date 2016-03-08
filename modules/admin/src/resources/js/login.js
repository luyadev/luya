var observeLogin = function(form, url, secureUrl) {
	$(form).submit(function(e) {
        $('#errorsContainer').hide();
		$('.spinner').show(); $('.submit-icon').hide();
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: url,
			data: $(this).serialize(),
			success : function(response) {
                $('.spinner').hide(); $('.submit-icon').show();
				var refresh = response['refresh'];
				var errors = response['errors'];
				var enterSecureToken = response['enterSecureToken'];
				
				var errorHtml = '<ul>';
				for(var i in errors) {
					errorHtml = errorHtml + '<li>' + errors[i] + '</li>';
				}
				errorHtml = errorHtml + '</ul>';
				
				if (errors) {
					$('#errorsContainer').html(errorHtml);
					$('#errorsContainer').show();
				}
				
				
				if (enterSecureToken) {
					$('#secureForm').show();
					$('#loginForm').hide();
				}
				
				if (refresh) {
                    $('#secureForm').hide();
                    $('#loginForm').hide();
                    $('#success').show();
                    location.reload();
				}
			},
			dataType: "json"
		});
	});
	
	$('#secureForm').submit(function(e) {
		$('#errorsContainer').hide();
        $('.spinner').show(); $('.submit-icon').hide();
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: secureUrl,
			data: $(this).serialize(),
			success : function(response) {
                $('.spinner').hide(); $('.submit-icon').show();
				var refresh = response['refresh'];
				
				if (response['errors']) {
					$('#errorsContainer').html('<ul><li>' + response['errors'] + '</li></ul>');
					$('#errorsContainer').show();
				}
				
				if (refresh) {
                    $('#secureForm').hide();
                    $('#loginForm').hide();
					$('#success').show();
                    location.reload();
				}
			},
			dataType: "json"
		})
	});
	
	$('#abortToken').click(function(e) {
        $('.spinner').hide(); $('.submit-icon').show();
		$('#errorsContainer').hide();
		$('#secureForm').hide();
		$('#loginForm').show();
		$('#success').hide();
	});
};
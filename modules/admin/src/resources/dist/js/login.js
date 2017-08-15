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
					$('#luya-loading-overlay').show();
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
		$('#errorsSecureContainer').hide();
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
					$('#errorsSecureContainer').html('<ul><li>' + response['errors'] + '</li></ul>');
					$('#errorsSecureContainer').show();
				}
				
				if (refresh) {
					$('#luya-loading-overlay').show();
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
        $('.spinner').hide(); 
        $('.submit-icon').show();
		$('#errorsContainer').hide();
		$('#secureForm').hide();
		$('#loginForm').show();
		$('#success').hide();
	});

    $(window).load(function() {
        $('.login-logo').addClass('login-logo-loaded');
        $('.login-form').addClass('login-form-loaded');
    });

};
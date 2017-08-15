var observeLogin = function(form, url, secureUrl) {
	$(form).submit(function(e) {
        $('#errorsContainer').hide();
        $('.login-btn[type="submit"]').attr('disabled', true);
        $('.login-spinner').show();
        $('.login-btn-label').hide();
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: url,
			data: $(this).serialize(),
			success : function(response) {
                $('.login-btn[type="submit"]').attr('disabled', false);
                $('.login-spinner').hide();
                $('.login-btn-label').show();
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
                    $('.login-logo').hide();
                    location.reload();
				}
			},
			dataType: "json"
		});
	});
	
	$('#secureForm').submit(function(e) {
		$('#errorsSecureContainer').hide();
        $('.login-btn[type="submit"]').attr('disabled', true);
        $('.login-spinner').show();
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: secureUrl,
			data: $(this).serialize(),
			success : function(response) {
                $('.login-spinner').hide();
                $('.login-btn[type="submit"]').attr('disabled', false);
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
                    $('.login-logo').hide();
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
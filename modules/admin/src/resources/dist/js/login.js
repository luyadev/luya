var observeLogin = function (form, url, secureUrl) {
    $(form).submit(function (e) {
        $('#errorsContainer').hide();
        $('.login-btn[type="submit"]').attr('disabled', true);
        $('.login-spinner').show();
        $('.login-btn-label').hide();
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            success: function (response) {
                $('.login-btn[type="submit"]').attr('disabled', false);
                $('.login-spinner').hide();
                $('.login-btn-label').show();
                var refresh = response['refresh'];
                var errors = response['errors'];
                var enterSecureToken = response['enterSecureToken'];

                var errorHtml = '<ul>';
                for (var i in errors) {
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
                    $('#success').show();
                    $('#secureForm').hide();
                    $('#loginForm').hide();
                    $('.login-logo').hide();
                    location.reload();
                }
            },
            dataType: "json"
        });
    });

    $('#secureForm').submit(function (e) {
        $('#errorsSecureContainer').hide();
        $('.login-btn[type="submit"]').attr('disabled', true);
        $('.login-spinner').show();
        $('.login-btn-label').hide();
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: secureUrl,
            data: $(this).serialize(),
            success: function (response) {
                $('.login-spinner').hide();
                $('.login-btn-label').show();
                $('.login-btn[type="submit"]').attr('disabled', false);
                var refresh = response['refresh'];

                if (response['errors']) {
                    $('#errorsSecureContainer').html('<ul><li>' + response['errors'] + '</li></ul>');
                    $('#errorsSecureContainer').show();
                }

                if (refresh) {
                    $('#success').show();
                    $('#secureForm').hide();
                    $('#loginForm').hide();
                    $('.login-logo').hide();
                    location.reload();
                }
            },
            dataType: "json"
        })
    });

    $('#abortToken').click(function (e) {
        $('.spinner').hide();
        $('.submit-icon').show();
        $('#errorsContainer').hide();
        $('#secureForm').hide();
        $('#loginForm').show();
        $('#success').hide();
    });
};

var checkInputLabels = function () {
    var $loginInput = $('.login-input');

    var check = function($element) {
        var val = $element.val() ? $element.val() : '';

        var autofillBg = window.getComputedStyle($element[0], null).getPropertyValue("background-color") === 'rgb(250, 255, 189)' ? true : false;

        if(val.length >= 1 || autofillBg === true) {
            $element.addClass('is-not-empty').removeClass('is-empty');
        } else {
            $element.addClass('is-empty').removeClass('is-not-empty');
        }
    };

    $loginInput.on('keyup', function() {
        check($(this));
    });

    $loginInput.each( function() {
        check($(this));
    });
};

$(window).on('load', function () {
    $('.login-logo').addClass('login-logo-loaded');
    $('.login-form').addClass('login-form-loaded');
    checkInputLabels();
});



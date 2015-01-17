$( document ).ready( function() {
    loginBackground();
});

function loginBackground() {
    var basePath    = $( 'body' ).data( 'image-path' );
    var imageCount  = 6;

    $( 'body' ).css({
        'background-size':          "cover",
        '-webkit-background-size':  "cover",
        '-moz-background-size':     "cover",
        '-o-background-size':       "cover"
    });

    var changeImage = function( basePath, imageCount ) {
        var imageNumber = Math.floor((Math.random() * imageCount) + 1);
        var imagePath   = basePath + imageNumber + ".jpg";

        // Preload image before displaying it
        var image = new Image();
        image.src = imagePath;
        image.onload = function() {
            $( 'body' ).css( 'background', "url(" + imagePath + ") no-repeat center center fixed" );

            if( $( 'body' ).css( 'transition' ) != "background 1s ease 0s") {
                $( 'body' ).css({
                    'transition':               "1s background ease",
                    '-webkit-transition':       "1s background ease"
                });
            }

            setTimeout( function() {
                changeImage( basePath, imageCount );
            }, 5000);
        };
    };

    changeImage( basePath, imageCount );

    return true;
}
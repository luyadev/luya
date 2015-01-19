function loginBackground( options ) {
    var $body       = $( 'body' );
    var basePath    = options.imagePath || "";
    var imageCount  = options.imageCount || 0;

    $body.css({
        'background-size':          "cover",
        '-webkit-background-size':  "cover",
        '-moz-background-size':     "cover",
        '-o-background-size':       "cover"
    });

    changeImage( basePath, imageCount );
}

function changeImage( basePath, imageCount ) {
    var imageNumber = Math.floor((Math.random() * imageCount) + 1);
    var imagePath   = basePath + imageNumber + ".jpg";
    var image       = new Image();

    // Preload image before displaying it
    image.src = imagePath;
    image.onload = function() {
        var $body = $( 'body' );
        $body.css( 'background', "url(" + imagePath + ") no-repeat center center fixed" );

        if( $body.css( 'transition' ) != "background 1s ease 0s") {
            $body.css({
                'transition':               "1s background ease",
                '-webkit-transition':       "1s background ease"
            });
        }

        setTimeout( function() {
            changeImage( basePath, imageCount );
        }, 5000);
    };
}
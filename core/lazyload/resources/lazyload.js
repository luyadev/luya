(function ( $ ) {

    // Used to store the images
    var images = [];

    var settings = {
        // Default settings
        defaultAspectRatio: 1.777777778,
        threshold: 200,
        loaderHtml: '<div class="loader"></div>',

        imageIdentifierPrefix: 'lazy-image-'
    };

    var viewportChanged = false;
    var touchScrolling = false;

    var getVisibleImages = function() {
        return $.grep(images, function( image ) {
            if(typeof image == 'undefined')
                return false;

            var $image = $('#' + settings.imageIdentifierPrefix + image.id);

            if($image.length <= 0)
                return false;

            var docViewTop = $(window).scrollTop() - 200 - settings.threshold;
            var docViewBottom = (docViewTop + $(window).height()) + 200 + settings.threshold;
            var elemTop = $image.offset().top;
            var elemBottom = elemTop + $image.outerHeight();

            return (
                elemTop >= docViewTop && elemTop <= docViewBottom ||
                elemTop <= docViewTop && elemBottom <= docViewBottom && elemBottom >= docViewTop
            );
        });
    };

    var loadVisibleImages = function() {
        $('.lazy-image').show();

        var visibleImages = getVisibleImages();

        $(visibleImages).each( function() {
            var $loadImage = $('<img/>', {
                src: this.sources.default,
                class: this.class,
            });

            var image = this;
            $loadImage.on('load', function() {
                delete images[image.id];

                if(image.asBackground) {
                    var $html = $(image.html).css({
                        backgroundImage: 'url(' + image.sources.default + ')'
                    });
                    $('#' + settings.imageIdentifierPrefix + image.id).replaceWith(
                        $html.attr('id', settings.imageIdentifierPrefix + image.id)
                    );
                } else {
                    $('#' + settings.imageIdentifierPrefix + image.id).replaceWith(
                        $loadImage.attr('id', settings.imageIdentifierPrefix + image.id)
                    );
                }

                $(document).trigger("lazyimage-loaded", {type: 'success', imageId: '#' + settings.imageIdentifierPrefix + image.id});
            });

            $loadImage.on('error', function() {
                delete images[image.id];

                $('#' + settings.imageIdentifierPrefix + image.id).css('cursor', 'default').find('.loader').replaceWith(
                    '<span style="position: absolute; left: 0; right: 0; top: 50%; font-size: 40px; line-height: 40px; margin-top: -20px; text-align: center; opacity: .2;">?</span>'
                );
                $('#' + settings.imageIdentifierPrefix + image.id).show();

                $(document).trigger("lazyimage-loaded", {type: 'error', imageId: '#' + settings.imageIdentifierPrefix + image.id});
            });
        });
    };

    $.fn.lazyLoad = function( options ) {
        if(options == 'refresh') {
            if(typeof arguments[1] !== 'undefined') {
                settings = $.extend(settings, arguments[1] );
            }

            loadVisibleImages();
            return true;
        }

        settings = $.extend(settings, options );

        /**
         * Fill the images array and replace the images with placeholders (aspect ratio)
         */
        this.each( function(index) {
            var imageWidth = $(this).attr('data-width')
            imageHeight = $(this).attr('data-height')
            imageAspectRatio = settings.defaultAspectRatio
            imageAsBackground = $(this).attr('data-as-background');

            if(imageWidth && imageHeight) {
                imageAspectRatio = imageHeight / imageWidth;
            }

            images.push({
                id: index,
                class: $(this).attr('class'),
                width: imageWidth,
                height: imageHeight,
                aspectRatio: imageAspectRatio,
                asBackground: imageAsBackground,
                html: $(this)[0].outerHTML,
                sources: {
                    default: $(this).attr('data-src')
                }
            });

            var $placeholder = $('<div/>', {
                class: 'lazyload-placeholder ' + $(this).attr('class'),
                id: settings.imageIdentifierPrefix + index,
            }).css({
                position: 'relative'
            }).append($('<div/>').css({
                'height' : 0,
                'padding-bottom': imageAspectRatio * 100 + '%'
            })).append($(settings.loaderHtml));

            $(this).replaceWith($placeholder);
        });

        loadVisibleImages();

        setInterval( function() {
            if(viewportChanged == true || touchScrolling == true) {
                loadVisibleImages();
                viewportChanged = false;
            }
        }, 250);
        $(document).on('touchmove', function() {
            touchScrolling = true;
        });
        $(window).on('scroll resize', function() {
            viewportChanged = true;
            touchScrolling = false;
        });
    };

}( jQuery ));
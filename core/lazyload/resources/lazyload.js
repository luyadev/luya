(function ( $ ) {

    $.fn.lazyLoad = function( options ) {

        var images = [];

        var settings = $.extend({
            // Default settings
            defaultAspectRatio: 1.777777778,
            threshold: 200,
            loaderHtml: '<div class="loader"></div>',

            imageIdentifierPrefix: 'lazy-image-'

        }, options );

        var scrolled = false;

        /**
         * Fill the images array and replace the images with
         */
        this.each( function(index) {
            var imageWidth = $(this).attr('data-width')
            imageHeight = $(this).attr('data-height')
            imageAspectRatio = settings.defaultAspectRatio;

            if(imageWidth && imageHeight) {
                imageAspectRatio = imageHeight / imageWidth;
            }

            images.push({
                id: index,
                class: $(this).attr('class'),
                width: imageWidth,
                height: imageHeight,
                aspectRatio: imageAspectRatio,
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
            })).append($(settings.loaderHtml).css({position: 'absolute', top: 0}));

            $(this).replaceWith($placeholder);
        });

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
            var visibleImages = getVisibleImages();

            $(visibleImages).each( function() {
                var $loadImage = $('<img/>', {
                    src: this.sources.default,
                    class: this.class,
                });

                var image = this;
                $loadImage.on('load', function() {
                    delete images[image.id];
                    $('#' + settings.imageIdentifierPrefix + image.id).replaceWith(
                        $loadImage
                    );
                });
            });
        };

        loadVisibleImages();

        setInterval( function() {
            if(scrolled == true) {
                loadVisibleImages();
                scrolled = false;
            }
        }, 250);
        $(window).on('scroll', function() {
            scrolled = true;
        });
    };

}( jQuery ));
/**
 * @file
 * Lazyloading
 */

(function ($) {

    // Default settings, can be overwritten
    var settings = {
        // General settings
        threshold: 200,
        imageIdentifierPrefix: 'lazy-image-',
        imageSelector: '.lazy-image:not(.lazy-placeholder)',
        placeholderClass: 'lazy-placeholder',

        // Settings for non image placeholder
        defaultAspectRatio: 1.777777778,
        loaderHtml: '<div class="loader"></div>',

        // Settings for image placeholder
    };

    // Status object, will be used to determine if a refresh is necessary
    var status = {
        viewportChanged: false,
        touchScrolling: false,
        resized: false
    };

    // The image array, will be filled on init and only updated if necessary
    var images = [];

    /**
     * This function runs only once.
     * Search for all images (by settings.imageSelector) and save them in the
     * images variable. All important data gets collected here too.
     * After all images are stored, the palceholders will be generated and
     * the image boundaries will be calculated.
     */
    var fetchImages = function() {
        $(settings.imageSelector).each(function (index) {
            // Add the identifying class
            $(this).addClass(settings.imageIdentifierPrefix + index);

            // Get some useful infos
            var imageWidth = parseInt($(this).attr('data-width')),
                imageHeight = parseInt($(this).attr('data-height')),
                aspectRatio = settings.defaultAspectRatio,
                asBackground = $(this).attr('data-as-background');

            // If we have an image width & height we can calculate the aspectRatio
            // the aspect ration is only used for the div placeholder
            if (imageWidth && imageHeight) {
                aspectRatio = imageHeight / imageWidth;
            }

            var divPlaceholderExists = false;
            if($(this).next('.' + settings.placeholderClass).length >= 1) {
                divPlaceholderExists = true;
            }

            images.push({
                id: index,
                source: $(this).attr('data-src'),
                boundaries: {},
                hasPlaceholderImage: $(this).hasClass('lazyimage'),
                divPlaceholderExists: divPlaceholderExists,
                width: imageWidth,
                height: imageHeight,
                aspectRatio: aspectRatio,
                asBackground: asBackground,
                html: $(this)[0].outerHTML
            });

        });

        insertPlaceholder();
        calculateImageBoundaries();
    };

    /**
     * This function runs only once.
     * All images that don't have a placeholder image or are only background-
     * images will get a placeholder element inserted after the iamge.
     */
    var insertPlaceholder = function() {
        $(images).each(function () {
            if(!this.hasPlaceholderImage && !this.asBackground && !this.divPlaceholderExists) {
                // Get the image by id
                var $image = $('.' + settings.imageIdentifierPrefix + this.id);
                var cssClass = $image.attr('class');

                // Check if cssClass is set and if yes, remove the imageIdentifier
                if(typeof cssClass === 'string') {
                    cssClass = cssClass.replace(settings.imageIdentifierPrefix + this.id, '');
                }

                // Generate a placeholder element with the same class and
                // insert it after the image.
                var $placeholder = $('<div/>', {
                    class: settings.placeholderClass + ' ' + cssClass,
                });

                $placeholder.append($('<div/>').css({
                    'height': 0,
                    'padding-bottom': (this.aspectRatio * 100) + '%'
                }));

                $placeholder.append($(settings.loaderHtml));

                $placeholder.insertAfter($image);

                if(images[this.id]) {
                    images[this.id].divPlaceholderExists = true;
                }
            }
        });
    };

    /**
     * This function determines which images are visible.
     * It will run everytime a status (in the status object) gets updated.
     */
    var getVisibleImages = function() {
        var filterImages = function() {
            return $.grep(images, function (image) {
                if (typeof image === 'undefined')
                    return false;

                var windowTop = $(window).scrollTop();
                var windowHeight = $(window).innerHeight();

                var docViewTop = windowTop - 200 - settings.threshold;
                var docViewBottom = (windowTop + windowHeight) + 200 + settings.threshold;

                // Check if image is in view
                return (
                    image.boundaries.top >= docViewTop && image.boundaries.top <= docViewBottom ||
                    image.boundaries.top <= docViewTop && image.boundaries.bottom <= docViewBottom && image.boundaries.bottom >= docViewTop
                );
            });
        };

        // If the screen got resized we need to update the image boundaries first
        if (status.resized) {
            status.resized = false;
            return calculateImageBoundaries(filterImages());
        }

        return filterImages();
    };

    /**
     * Load all visible images
     */
    var loadVisibleImages = function () {
        var visibleImages = getVisibleImages();

        $(visibleImages).each(function () {
            // Generate a new image, add the source so it starts loading
            var $loadImage = $('<img/>', {
                src: this.source
            });

            var image = this;

            // If the image was loaded successfully
            $loadImage.on('load', function () {
                // Remove the image from the images array because it's not
                // needed anymore
                delete images[image.id];

                var $image = $('.' + settings.imageIdentifierPrefix + image.id);
                var $placeholder = $image.next('.' + settings.placeholderClass);

                // Update the original img tag to show the image
                $image.attr('src', image.source);
                $image.addClass('loaded');

                if (image.asBackground) {
                    // If the image is a background-image we need to update the
                    // original div with the background image url
                    $('.' + settings.imageIdentifierPrefix + image.id).css({
                        backgroundImage: 'url(' + image.source + ')'
                    })
                } else if (!image.hasPlaceholderImage) {
                    // If the image has a placeholder div we need to remove it
                    $placeholder.remove();
                }

                // Trigger a success event
                $(document).trigger("lazyimage-loaded", {
                    type: 'success',
                    imageId: '.' + settings.imageIdentifierPrefix + image.id
                });
            });

            // If the image can't be loaded
            $loadImage.on('error', function () {
                delete images[image.id];

                // Trigger a error event
                $(document).trigger("lazyimage-loaded", {
                    type: 'error',
                    imageId: '.' + settings.imageIdentifierPrefix + image.id
                });
            });
        });
    };

    /**
     * Calculates the images top and bottom boundaries
     */
    var calculateImageBoundaries = function(callback) {
        for (var imageIndex in images) {
            var image = images[imageIndex];
            var $image = $('.' + settings.imageIdentifierPrefix + image.id);
            var $placeholder = $image.next('.' + settings.placeholderClass);

            // The image might not have a placeholder, if that's the case
            // we use the image element itself
            var elemTop = $placeholder.length > 0 ? $placeholder.offset().top : $image.offset().top;

            image.boundaries = {
                top: elemTop,
                bottom: elemTop + ($placeholder.length > 0 ? $placeholder.outerHeight() : $image.outerHeight()),
            };

            // Update the image in the images array
            images[imageIndex] = image;
        }

        if (typeof callback === 'function') {
            return callback();
        }
    };

    $.fn.lazyLoad = function (options) {

        // Fetch images to prepare the iamges array
        fetchImages();

        // Regularly check for changes and run needed functions
        setInterval(function () {
            if (status.viewportChanged === true || status.touchScrolling === true) {
                loadVisibleImages();
                status.viewportChanged = false;
                status.touchScrolling = false;
            }
        }, 250);

        // Listen to different events the script needs to react to
        $(document).on('touchmove', function () {
            status.touchScrolling = true;
        });
        $(window).on('scroll resize', function () {
            status.viewportChanged = true;
            status.touchScrolling = false;
        });
        $(window).on('resize', function () {
            status.resized = true;
        });

        // Finally, start loading of the first visible images (if there are any)
        loadVisibleImages();
    };

}(jQuery));

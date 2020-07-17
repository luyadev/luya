/**
 * @file
 * Lazyloading
 */

(function ($) {

    var initialized = false;

    // Default settings, can be overwritten
    var settings = {
        // General settings
        threshold: 200,
        imageIdentifierPrefix: 'lazyimage-',
        imageSelector: '.lazyimage:not(.lazy-placeholder)',
        placeholderClass: 'lazyimage-placeholder',

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

    var lastId = 0;
    var getNewId = function() {
        return lastId += 1;
    };

    var debug = function(msg) {
        console.log(msg)
    }

    /**
     * This function runs only once.
     * Search for all images (by settings.imageSelector) and save them in the
     * images variable. All important data gets collected here too.
     * After all images are stored, the palceholders will be generated and
     * the image boundaries will be calculated.
     */
    var fetchImages = function() {
        images = [];
        $(settings.imageSelector).each(function (index) {
            if(!$(this).hasClass('loaded')) {
                var id = getNewId();

                // Add the identifying class
                $(this).addClass(settings.imageIdentifierPrefix + id);

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

                images.push({
                    id: id,
                    source: $(this).attr('data-src'),
                    boundaries: {},
                    width: imageWidth,
                    height: imageHeight,
                    aspectRatio: aspectRatio,
                    asBackground: asBackground,
                    html: $(this)[0].outerHTML
                });
            }
        });

        calculateImageBoundaries();
    };

    /**
     * This function determines which images are visible.
     * It will run everytime a status (in the status object) gets updated.
     */
    var getVisibleImages = function() {
        var filterImages = function() {
            var windowTop = $(window).scrollTop();
            var windowHeight = $(window).height();

            var docViewTop = windowTop - settings.threshold;
            var docViewBottom = (windowTop + windowHeight) + settings.threshold;

            return images.filter( function(image) {
                if (typeof image === 'undefined')
                    return false;

                // Check if image is in view
                return (
                    image.boundaries.top >= docViewTop && image.boundaries.top <= docViewBottom ||
                    image.boundaries.top <= docViewTop && image.boundaries.bottom <= docViewBottom && image.boundaries.bottom >= docViewTop
                )
            })
        };

        // If the screen got resized we need to update the image boundaries first
        if (status.resized) {
            status.resized = false;
            return calculateImageBoundaries(filterImages);
        }

        return filterImages();
    };

    /**
     * Load all visible images
     */
    var loadVisibleImages = function () {
        var visibleImages = getVisibleImages();

        if (visibleImages.length) {
            debug({
                windowTop: {
                    actual: $(window).scrollTop(),
                    withThreshold: $(window).scrollTop() - settings.threshold
                },
                windowBottom: {
                    actual: $(window).scrollTop() + $(window).height(),
                    withThreshold: ($(window).scrollTop() + $(window).height()) + settings.threshold
                },
                loadingImages: visibleImages
            })
        }

        $(visibleImages).each(function () {
            // Generate a new image, add the source so it starts loading
            var $loadImage = $('<img/>', {
                src: this.source
            });

            var image = this;
            var imageIndex = images.map(function(e) { return e.id; }).indexOf(image.id);

            // If the image was loaded successfully
            $loadImage.on('load', function () {
                // Remove the image from the images array because it's not
                // needed anymore
                delete images[imageIndex];

                var $image = $('.' + settings.imageIdentifierPrefix + image.id);

                // Update the original img tag to show the image
                $image.attr('src', image.source);
                $image.addClass('loaded');

                if (image.asBackground) {
                    // If the image is a background-image we need to update the
                    // original div with the background image url
                    $('.' + settings.imageIdentifierPrefix + image.id).css({
                        backgroundImage: 'url(' + image.source + ')'
                    })
                }

                // Trigger a success event
                $(document).trigger("lazyimage-loaded", {
                    type: 'success',
                    imageId: '.' + settings.imageIdentifierPrefix + image.id
                });
            });

            // If the image can't be loaded
            $loadImage.on('error', function () {
                delete images[imageIndex];

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

    var checkViewportChanges = function() {
        if (status.viewportChanged === true || status.touchScrolling === true) {
            loadVisibleImages();
            status.viewportChanged = false;
            status.touchScrolling = false;
        }

        if (images.filter(image => !!image).length) {
            window.requestAnimationFrame(checkViewportChanges)
        }
    }

    $.lazyLoad = function (options) {        
        if(typeof options === 'string') {
            switch(options) {
                case 'refetchElements':
                fetchImages();
                loadVisibleImages();
                break;
            }
        } else if (!initialized) {
            initialized = true;

            if(options) {
                settings = $.extend(settings, options);
            }

            // Fetch images to prepare the iamges array
            fetchImages();

            // Regularly check for changes and run needed functions
            window.requestAnimationFrame(checkViewportChanges)

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
        }

        return this;
    };

}(jQuery));

describe("Test LazyLoading: Image loading", function() {
    var originalTimeout;
    var basicLazyLoadImageFixture = '<img class="js-lazyimage lazyimage" data-src="https://source.unsplash.com/random/500x250" data-width="500" data-height="250">';

    beforeEach(function() {
        // Increase timeout to 30 seconds in case unsplash has a
        // major problem
        originalTimeout = jasmine.DEFAULT_TIMEOUT_INTERVAL;
        jasmine.DEFAULT_TIMEOUT_INTERVAL = 30000;
    });

    it("should have class `loaded`", function (done) {
        var imageId;

        ( function($) {
            // Set imageLoaded to false and wait for event sent by the lazyloading plugin
            var imageLoaded = false;
            $(document).one('lazyimage-loaded', function(e, info) {
                if(info.type == 'success') {
                    imageId = info.image.id;
                    imageLoaded = true;
                }
            });

            // Load fixture
            const fixture = setFixtures(basicLazyLoadImageFixture);

            // Init lazyloading
            $.lazyLoad();

            // Check every half second if the image has been loaded
            // and if so, call the done() function
            // var startTime = Date.now();
            setInterval(function() {
                if(imageLoaded) {
                    // Check if this.imageId has class loaded
                    expect(fixture.find(`.lazyimage-${imageId}`).hasClass('loaded')).toBe(true);
                    done();
                } else {
                    // console.log('Waiting for image to load... (' + Math.round((Date.now() - startTime) / 1000) + 's)');
                }
            }, 500);
        }) (jQuery)
    });

    /*
        it("should call 2 events", function (done) {
            ( function($) {
                // Set imageLoaded to false and wait for event sent by the lazyloading plugin
                let imageLoaded = false

                let events = 0
                $(document).on('lazyimage-loading', function(e, info) {
                    events++
                });
                $(document).on('lazyimage-loaded', function(e, info) {
                    imageLoaded = true
                    events++
                });

                // Load fixture
                setFixtures(basicLazyLoadImageFixture);

                // Init lazyloading
                $.lazyLoad('refetchElements');

                // Check every half second if the image has been loaded
                // and if so, call the done() function
                // var startTime = Date.now();
                setInterval(function() {
                    if(imageLoaded) {
                        // Check if this.imageId has class loaded
                        expect(events).toEqual(2);
                        done();
                    } else {
                        // console.log('Waiting for image to load... (' + Math.round((Date.now() - startTime) / 1000) + 's)');
                    }
                }, 500);
            }) (jQuery)
        });
    */

    afterEach(function() {
        jasmine.DEFAULT_TIMEOUT_INTERVAL = originalTimeout;
    });
});

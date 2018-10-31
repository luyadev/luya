describe("Test LazyLoading: Placheolder", function() {
    var basicLazyLoadImageFixture = '<img class="lazy-image" data-src="https://source.unsplash.com/random/500x250" data-width="500" data-height="250">';

    it("should have a placeholder", function () {
        setFixtures(basicLazyLoadImageFixture);

        // Init lazyload which should insert placeholder
        $('.lazy-image').lazyLoad();

        // Check for placeholder
        expect($('.lazy-image').next('.lazy-placeholder')[0].outerHTML).toBe(
            '<div class="lazy-placeholder lazy-image "><div style="height: 0px; padding-bottom: 50%;"></div><div class="loader"></div></div>'
        );
    });

});

describe("Test LazyLoading: Image loading", function() {
    var originalTimeout;
    var imageId;
    var basicLazyLoadImageFixture = '<img class="lazy-image" data-src="https://source.unsplash.com/random/500x250" data-width="500" data-height="250">';

    beforeEach(function(done) {
        // Increase timeout to 30 seconds in case unsplash has a
        // major problem
        originalTimeout = jasmine.DEFAULT_TIMEOUT_INTERVAL;
        jasmine.DEFAULT_TIMEOUT_INTERVAL = 30000;

        // Set imageLoaded to false and wait for event sent by the lazyloading plugin
        var imageLoaded = false;
        $(document).on('lazyimage-loaded', function(e, info) {
            if(info.type == 'success') {
                imageId = info.imageId;
                imageLoaded = true;
            }
        });

        // Load fixture
        setFixtures(basicLazyLoadImageFixture);

        // Init lazyloading
        $('.lazy-image').lazyLoad();

        // Check every second if the image has been loaded
        // and if so, call the done() function
        setInterval(function() {
            if(imageLoaded) {
                done();
            }
        }, 1000);
    });

    afterEach(function() {
        jasmine.DEFAULT_TIMEOUT_INTERVAL = originalTimeout;
    });

    it("should have class loaded", function () {
        // Check if this.imageId has class loaded
        expect($(imageId).hasClass('loaded')).toBe(true);
    });
});

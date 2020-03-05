describe('Test TextToSpeech: output speech from text', function() {
    const controlButtons = '<div><button id="play-button">play</button> <button id="pause-button">pause</button><button id="stop-button">stop</button></div>';
    beforeEach(function() {
        originalTimeout = jasmine.DEFAULT_TIMEOUT_INTERVAL;
        jasmine.DEFAULT_TIMEOUT_INTERVAL = 10000;
    });

    afterEach(function() {
        jasmine.DEFAULT_TIMEOUT_INTERVAL = originalTimeout;
    });

    it('should output "test" with with browser speech capabilities', function(done) {
        (function($) {
            setFixtures(controlButtons);
            $.textToSpeech({ text: 'test test test' });
            $('body').on('textToSpeech:finished', () => {
                done();
            });
            $('#play-button').trigger('click');
            done();
        })(jQuery);
    });
});

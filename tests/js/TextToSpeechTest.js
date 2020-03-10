describe('Test TextToSpeech', function() {
    const controlButtons = '<div><button id="play-button">play</button> <button id="pause-button">pause</button><button id="stop-button">stop</button></div>';

    beforeEach(async function() {
        originalTimeout = jasmine.DEFAULT_TIMEOUT_INTERVAL;
        jasmine.DEFAULT_TIMEOUT_INTERVAL = 10000;
    });

    afterEach(function() {
        jasmine.DEFAULT_TIMEOUT_INTERVAL = originalTimeout;
    });

    it('check speech, events and setText/getText', function(done) {
        (function($) {
            const textToSpeak = 'Lorem ipsum dolor sit amet!';
            const fixture = setFixtures(controlButtons);
            let eventsFired = [];

            const tts = $.textToSpeech({
                text: textToSpeak + 'asd',
                eventSelector: fixture
            });

            // Check if text via settings works
            expect(tts.getText()).toBe(textToSpeak + 'asd')
            
            tts.setText(textToSpeak)

            // Check if text via setText works
            expect(tts.getText()).toBe(textToSpeak)

            fixture.on('textToSpeech:play', () => {
                eventsFired.push('play')
            });

            fixture.on('textToSpeech:pause', () => {
                eventsFired.push('pause')
            });

            fixture.on('textToSpeech:resume', () => {
                eventsFired.push('resume')
            });

            fixture.on('textToSpeech:stop', () => {
                expect(eventsFired).toEqual(['play', 'pause', 'resume'])
                done();
            });

            tts.play(textToSpeak);

            setTimeout(() => {
                tts.pause();

                setTimeout(() => {
                    tts.play();
                }, 500)
            }, 500)
        })(jQuery);
    });
});

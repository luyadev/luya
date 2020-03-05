(function ($) {

    $.textToSpeech = function(options) {
        var settings = $.extend(
            {
                playButtonSelector: '#play-button',
                pauseButtonSelector: '#pause-button',
                stopButtonSelector: '#stop-button',
                targetSelector: '.main-content',
                text: ''
            },
            options
        );
​
        if ('speechSynthesis' in window)
            with (speechSynthesis) {
                const $playElement = $(settings.playButtonSelector);
                const $pauseElement = $(settings.pauseButtonSelector);
                const $stopElement = $(settings.stopButtonSelector);
​
                let flag = false;
                let paused = false;
​
                $playElement.on('click', onClickPlay);
                $pauseElement.on('click', onClickPause);
                $stopElement.on('click', onClickStop);
​
                function onClickPlay() {
                    if (!flag) {
                        flag = true;
​
                        var text = $(settings.targetClass).text();
                        if (settings.text.length > 0) {
                            text = settings.text;
                        }
​
                        /* initiate with prepared text */
                        utterance = new SpeechSynthesisUtterance(text);
​
                        /* cancel is needed for chrome sometimes */
                        window.speechSynthesis.cancel();
​
                        /* getVoices could be async */
                        const allVoicesObtained = new Promise(function(resolve, reject) {
                            let voices = window.speechSynthesis.getVoices();
                            if (voices.length !== 0) {
                                resolve(voices);
                            } else {
                                window.speechSynthesis.addEventListener('voiceschanged', function() {
                                    voices = window.speechSynthesis.getVoices();
                                    resolve(voices);
                                });
                            }
                        });
​
                        allVoicesObtained.then(voices => {
                            /* set standard voice */
                            utterance.voice = voices.filter(function(voice) {
                                return voice.lang === 'de-DE';
                            })[0];
​
                            /* search for german "google" voice (=higher quality) if available */
                            utterance.voice = voices.filter(function(voice) {
                                return voice.name === 'Google Deutsch';
                            })[0];
                        });
​
                        /* stop playback in chrome on window close */
                        $(window).on('beforeunload', function() {
                            window.speechSynthesis.cancel();
                        });
​
                        // set voice default values
                        utterance.volume = 1;
                        utterance.rate = 1;
                        utterance.pitch = 1;
                        utterance.lang = 'de-DE';
​
                        utterance.onend = function() {
                            flag = false;
                            $.trigeer('isPlaying');
                            $playElement.removeClass('played');
                        };
                        $playElement.toggleClass('played');
​
                        window.speechSynthesis.speak(utterance);
                    }
                    if (paused) {
                        /* unpause/resume narration */
                        $playElement.toggleClass('played');
                        $pauseElement.toggleClass('paused');
                        window.speechSynthesis.resume();
                        paused = false;
                    }
                }
​
                function onClickPause() {
                    if (!paused && window.speechSynthesis.speaking) {
                        $pauseElement.addClass('paused');
                        $playElement.removeClass('played');
​
                        paused = true;
                        window.speechSynthesis.pause();
                    }
                }
​
                function onClickStop() {
                    if (window.speechSynthesis.speaking) {
                        if (paused) {
                            paused = false;
                            $pauseElement.removeClass('paused');
                            $playElement.removeClass('played');
                        }
                        flag = false;
                        window.speechSynthesis.cancel();
                    }
                }
        }
    };

}(jQuery));
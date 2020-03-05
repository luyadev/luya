(function($) {
    $.textToSpeech = function(options) {
        var settings = $.extend(
            {
                playButtonSelector: '#play-button',
                pauseButtonSelector: '#pause-button',
                stopButtonSelector: '#stop-button',
                playClass: 'played',
                pauseClass: 'paused',
                targetSelector: '.main-content',
                text: '',
                playEvent: 'textToSpeech:play',
                pauseEvent: 'textToSpeech:pause',
                stopEvent: 'textToSpeech:stop',
                finishedPlayingEvent: 'textToSpeech:finished',
                eventSelector: 'body',
                language: 'en',
                favoriteVoice: ''
            },
            options
        );

        if ('speechSynthesis' in window)
            with (speechSynthesis) {
                const $playElement = $(settings.playButtonSelector);
                const $pauseElement = $(settings.pauseButtonSelector);
                const $stopElement = $(settings.stopButtonSelector);

                let flag = false;
                let paused = false;

                $playElement.on('click', onClickPlay);
                $pauseElement.on('click', onClickPause);
                $stopElement.on('click', onClickStop);

                function onClickPlay() {
                    if (!flag) {
                        flag = true;

                        var text = $(settings.targetSelector).text();
                        if (settings.text instanceof Function) {
                            text = settings.text();
                        } else if (settings.text.length > 0) {
                            text = settings.text;
                        }

                        /* initiate with prepared text */
                        utterance = new SpeechSynthesisUtterance(text);
                        console.log(utterance);

                        /* cancel is needed for chrome sometimes */
                        window.speechSynthesis.cancel();

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

                        allVoicesObtained.then(voices => {
                            /* set standard voice */
                            utterance.voice = voices.filter(function(voice) {
                                return voice.lang === settings.language;
                            })[0];

                            /* search for german "google" voice (=higher quality) if available */
                            utterance.voice = voices.filter(function(voice) {
                                return voice.name === settings.favoriteVoice;
                            })[0];
                        });

                        /* stop playback in chrome on window close */
                        $(window).on('beforeunload', function() {
                            window.speechSynthesis.cancel();
                        });

                        // set voice default values
                        utterance.volume = 1;
                        utterance.rate = 1;
                        utterance.pitch = 1;
                        utterance.lang = settings.language;

                        utterance.onend = function() {
                            flag = false;
                            $playElement.removeClass(settings.playClass);
                            $(settings.eventSelector).trigger(settings.finishedPlayingEvent);
                        };

                        $playElement.toggleClass(settings.playClass);
                        window.speechSynthesis.speak(utterance);
                    }
                    if (paused) {
                        /* unpause/resume narration */
                        $playElement.toggleClass(settings.playClass);
                        $pauseElement.toggleClass(settings.pauseClass);
                        window.speechSynthesis.resume();
                        paused = false;
                    }
                    $(settings.eventSelector).trigger(settings.playEvent);
                }

                function onClickPause() {
                    if (!paused && window.speechSynthesis.speaking) {
                        $pauseElement.addClass(settings.pauseClass);
                        $playElement.removeClass(settings.playClass);

                        paused = true;
                        window.speechSynthesis.pause();
                        $(settings.eventSelector).trigger(settings.pauseEvent);
                    }
                }

                function onClickStop() {
                    if (window.speechSynthesis.speaking) {
                        if (paused) {
                            paused = false;
                            $pauseElement.removeClass(settings.pauseClass);
                            $playElement.removeClass(settings.playClass);
                        }
                        flag = false;
                        window.speechSynthesis.cancel();
                        $(settings.eventSelector).trigger(settings.stopEvent);
                    }
                }
            }
    };
})(jQuery);

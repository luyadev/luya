(function($) {
    $.textToSpeech = function(options) {
        var settings = $.extend(
            {
                text: '',
                playEvent: 'textToSpeech:play',
                pauseEvent: 'textToSpeech:pause',
                resumeEvent: 'textToSpeech:resume',
                stopEvent: 'textToSpeech:stop',
                errorEvent: 'textToSpeech:error',
                finishedPlayingEvent: 'textToSpeech:finished',
                eventSelector: 'document',
                language: 'en',
                favoriteVoice: ''
            },
            options
        );

        if ('speechSynthesis' in window)
            with (speechSynthesis) {
            return {
                utterance: null,
                isPaused: false,
                checkIfSpeakingInterval: null,

                play() {
                    if (this.isPaused) {
                        return this.resume()
                    }

                    this.utterance = new SpeechSynthesisUtterance(settings.text);

                    this.utterance.onerror = (e) => {
                        console.error(e)
                        this.stop()
                        $(settings.eventSelector).trigger(settings.errorEvent)
                    }

                    /* stop playback in chrome on window close */
                    $(window).on('beforeunload', function() {
                        window.speechSynthesis.cancel();
                    });

                    try {
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
                            if (this.utterance) {
                                /* set standard voice */
                                this.utterance.voice = voices.filter(function(voice) {
                                    return voice.lang === settings.language;
                                })[0];

                                /* search for german "google" voice (=higher quality) if available */
                                this.utterance.voice = voices.filter(function(voice) {
                                    return voice.name === settings.favoriteVoice;
                                })[0];

                                // set voice default values
                                this.utterance.volume = 1;
                                this.utterance.rate = 1;
                                this.utterance.pitch = 1;
                                this.utterance.lang = settings.language;

                                this.checkIfSpeaking()
                                window.speechSynthesis.speak(this.utterance);
                                $(settings.eventSelector).trigger(settings.playEvent);
                            }
                        });
                    } catch(e) {
                        console.warn(e)
                        this.stop()
                    }
                },

                pause() {
                    /* pause narration */
                    this.isPaused = true;
                    window.speechSynthesis.pause();
                    $(settings.eventSelector).trigger(settings.pauseEvent);
                },

                resume() {
                    if (this.isPaused) {
                        this.isPaused = false;
                        window.speechSynthesis.resume();
                        $(settings.eventSelector).trigger(settings.resumeEvent);
                    }
                },

                stop() {
                    if (this.checkIfSpeakingInterval) {
                        clearInterval(this.checkIfSpeakingInterval);
                    }

                    this.isPaused = false;
                    window.speechSynthesis.cancel();
                    $(settings.eventSelector).trigger(settings.stopEvent);
                },

                checkIfSpeaking() {
                    this.checkIfSpeakingInterval = setInterval(() => {
                        if (this.utterance && !this.isPaused && !window.speechSynthesis.speaking) {
                            this.stop()
                        }
                    }, 500);
                },

                setText(text) {
                    settings.text = text
                },

                getText() {
                    return settings.text
                }

            }
        } else {
            return false
        }
    };
})(jQuery);

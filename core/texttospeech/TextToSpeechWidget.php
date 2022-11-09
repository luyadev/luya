<?php

namespace luya\texttospeech;

use luya\base\Widget;
use luya\helpers\Json;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Text to Speech.
 *
 * Using the browsers text to speech option to return a websites text. Either be providing the text as string or read the text from a given css class selector.
 *
 * Example using a Selector:
 *
 * ```
 * <?php
 * TextToSpeechWidget::widget(['targetSelector' => '#content']);
 * ?>
 * <div id="content">
 *    Hello World, this is LUYA Text to Speech!
 * </div>
 * ```
 *
 * By default the Widget will generate a play, pause and stop icon at the location the widget is integrated.
 *
 * @author Martin Petrasch <martin@zephir.ch>
 * @author Basil Suter <git@nadar.io>
 * @since 1.1.0
 */
class TextToSpeechWidget extends Widget
{
    /**
     * @var string The jQuery selector which should be used to read the content from, examples:
     * - `.container`: All elements which class `.container` will be spoken.
     * - `#content`: The element with id `id="content"` only will be spoken.
     *
     * The input data will be wrapped with `$()`.
     */
    public $targetSelector;

    /**
     * @var string If enabled, the {{$targetSelector}} attribute has no effect and only the text from the property will be read - on start.
     */
    public $text;

    /**
     * @var string The selector for the play button.
     */
    public $playButtonSelector = '#play-button';

    /**
     * @var string The selector for the pause button.
     */
    public $pauseButtonSelector = '#pause-button';

    /**
     * @var string The selector for the stop button.
     */
    public $stopButtonSelector = '#stop-button';

    /**
     * @var string The class which will be assigned to the play button when playing sound.
     */
    public $playButtonActiveClass = 'playing';

    /**
     * @var string The class which will be assigned to the pause button when pause button is clicked.
     */
    public $pauseButtonActiveClass = 'paused';

    /**
     * @var string The class of the div in which the buttons are located, the button wrapper div class.
     */
    public $containerClass = 'text-to-speech-container';

    /**
     * @var string The class which each of the text-to-speech buttons recieves.
     */
    public $buttonClass = 'btn text-to-speech-button';

    /**
     * @var integer The size of the default buttons, in pixel.
     */
    public $buttonSize = 30;

    /**
     * @var array|boolean You can either disable the default buttons by setting buttons to false, or you can provide an array with button configurations, each element requires the following keys:
     * - label:
     * - id:
     * - content:
     */
    public $buttons;

    /**
     * @var string The SVG code for the play icon when using default buttons.
     */
    public $playSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"/></svg>';

    /**
     * @var string The SVG code for the stop icon when using default buttons.
     */
    public $stopSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M144 479H48c-26.5 0-48-21.5-48-48V79c0-26.5 21.5-48 48-48h96c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zm304-48V79c0-26.5-21.5-48-48-48h-96c-26.5 0-48 21.5-48 48v352c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48z"/></svg>';

    /**
     * @var string The SVG code for the pause icon when using default buttons.
     */
    public $pauseSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48z"/></svg>';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        if (!$this->text && !$this->targetSelector) {
            throw new InvalidConfigException("Either text or targetSelector property must be configured.");
        }
        if ($this->buttons === null || $this->buttons === true) {
            $this->buttons[] = $this->createButton('Play', 'play-button', $this->playSVG);
            $this->buttons[] = $this->createButton('Pause', 'pause-button', $this->pauseSVG);
            $this->buttons[] = $this->createButton('Stop', 'stop-button', $this->stopSVG);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        TextToSpeechAsset::register($this->view);

        $config = Json::htmlEncode([
            'text' => $this->text ?: '', // must be an empty string as it will checked with .length
            'language' => Yii::$app->language,
        ]);

        $this->view->registerJs("
            var tts = $.textToSpeech({$config});
            var playButton = $('{$this->playButtonSelector}');
            var pauseButton = $('{$this->pauseButtonSelector}');
            " . ($this->targetSelector ? "tts.setText($('{$this->targetSelector}').text());" : "") . "
            var applyPlayClasses = function () {
                playButton.addClass('{$this->playButtonActiveClass}');
                pauseButton.removeClass('{$this->pauseButtonActiveClass}');
            };
            var applyPauseClasses = function () {
                playButton.removeClass('{$this->playButtonActiveClass}');
                pauseButton.addClass('{$this->pauseButtonActiveClass}');
            };
            var cleanupClasses = function () {
                playButton.removeClass('{$this->playButtonActiveClass}');
                pauseButton.removeClass('{$this->pauseButtonActiveClass}');
            };
            $('document').on('textToSpeech:play', applyPlayClasses);
            $('document').on('textToSpeech:pause', applyPauseClasses);
            $('document').on('textToSpeech:resume', applyPlayClasses);
            $('document').on('textToSpeech:stop', cleanupClasses);
            playButton.on('click', function() { tts.play() });
            pauseButton.on('click', function() { tts.pause() });
            $('{$this->stopButtonSelector}').on('click', function() { tts.stop() });
        ");

        return $this->render('texttospeech', [
            'buttons' => $this->buttons,
            'id' => $this->getId(),
            'containerClass' => $this->containerClass,
            'buttonClass' => $this->buttonClass,
            'buttonSize' => $this->buttonSize,
        ]);
    }

    /**
     * Create a default button element.
     *
     * @param string $label
     * @param string $id
     * @param string $svg
     * @return array
     */
    protected function createButton($label, $id, $svg)
    {
        return [
            'label' => $label,
            'id' => $id,
            'content' => $svg,
        ];
    }
}

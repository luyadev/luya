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
    public $buttonClass = 'text-to-speech-button';

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
    public $playSVG = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve"><g><path d="M45.563,29.174l-22-15c-0.307-0.208-0.703-0.231-1.031-0.058C22.205,14.289,22,14.629,22,15v30c0,0.371,0.205,0.711,0.533,0.884C22.679,45.962,22.84,46,23,46c0.197,0,0.394-0.059,0.563-0.174l22-15C45.836,30.64,46,30.331,46,30S45.836,29.36,45.563,29.174z M24,43.107V16.893L43.225,30L24,43.107z"/><path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M30,58C14.561,58,2,45.439,2,30S14.561,2,30,2s28,12.561,28,28S45.439,58,30,58z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>';

    /**
     * @var string The SVG code for the stop icon when using default buttons.
     */
    public $stopSVG = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve"><path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M44,44H16V16h28V44z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>';

    /**
     * @var string The SVG code for the pause icon when using default buttons.
     */
    public $pauseSVG = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 202.205 202.205" style="enable-background:new 0 0 202.205 202.205;" xml:space="preserve"><g> <g> <path style="fill:#010002;" d="M23.483,202.205H85.83V0H23.483V202.205z M31.417,7.934h46.479v186.336H31.417V7.934z"/> <path style="fill:#010002;" d="M116.372,0v202.205h62.351V0H116.372z M170.788,194.271h-46.486V7.934h46.482v186.336H170.788z"/> </g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>';
    
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
            'playButtonSelector' => $this->playButtonSelector,
            'pauseButtonSelector' => $this->pauseButtonSelector,
            'stopButtonSelector' => $this->stopButtonSelector,
            'targetSelector' => $this->targetSelector,
            'playClass' => $this->playButtonActiveClass,
            'pauseClass' => $this->pauseButtonActiveClass,
            'text' => $this->text ? $this->text : '', // must be an empty string as it will checked with .length
            'language' => Yii::$app->composition->langShortCode,
        ]);

        $this->view->registerJs("$.textToSpeech({$config});");

        return $this->render('texttospeech', [
            'buttons' => $this->buttons,
            'id' => $this->getId(),
            'containerClass' => $this->containerClass,
            'buttonClass' => $this->buttonClass,
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
<?php

namespace luya\tests\core\texttospeech;

use luya\texttospeech\TextToSpeechWidget;
use luyatests\LuyaWebTestCase;

class TextToSpeechWidgetTest extends LuyaWebTestCase
{
    public function testRender()
    {
        $content = TextToSpeechWidget::widget([
            'targetSelector' => '#foobar'
        ]);

        $this->assertContainsNoSpace('
        <div id="w0" class="text-to-speech-container">
<button type="button" style="height:30px; width:30px;" class="btn text-to-speech-button btn text-to-speech-button-play-button" id="play-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"/></svg></button>
<button type="button" style="height:30px; width:30px;" class="btn text-to-speech-button btn text-to-speech-button-pause-button" id="pause-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48z"/></svg></button>
<button type="button" style="height:30px; width:30px;" class="btn text-to-speech-button btn text-to-speech-button-stop-button" id="stop-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M144 479H48c-26.5 0-48-21.5-48-48V79c0-26.5 21.5-48 48-48h96c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zm304-48V79c0-26.5-21.5-48-48-48h-96c-26.5 0-48 21.5-48 48v352c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48z"/></svg></button>
</div>', $content);
    }
}

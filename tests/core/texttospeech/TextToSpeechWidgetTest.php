<?php

namespace luya\tests\core\texttospeech;

use luya\texttospeech\TextToSpeechWidget;
use luyatests\LuyaWebTestCase;

class TextToSpeechWidgetTest extends LuyaWebTestCase
{
    public function testRender()
    {
        $content = TextToSpeechWidget::widget([
            
        ]);

        $this->assertContains('button class="text-to-speech-button text-to-speech-button-stop-button" id="stop-button"', $content);
    }
}
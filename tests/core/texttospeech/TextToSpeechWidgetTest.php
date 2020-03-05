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

        $this->assertContains('<button type="button" style="height:30px; width:30px;" class="text-to-speech-button text-to-speech-button-stop-button" id="stop-button"', $content);
    }
}
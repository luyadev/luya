<?php

namespace luyatests\core\components;

use luya\components\Formatter;
use luyatests\LuyaWebTestCase;

class FormatterTest extends LuyaWebTestCase
{
    public function testDefaultSettingsFromGivenArray()
    {
        $ts = '1494338433'; // 9. May 2017, 16:00:33

        $formatter = new Formatter([
            'dateFormats' => [
                'en' => 'MM/MM/MM',
                'de' => 'YYYY/YYYY/YYYY',
            ],
            'locale' => 'de',
        ]);

        // only with php intl extension the response will be like this!
        $this->assertSame('2017/2017/2017', $formatter->asDate($ts));

        $formatter = new Formatter([
            'datetimeFormats' => [
                'en' => 'HH/mm',
                'de' => 'HH:mm',
                'fr' => 'HH.mm',
            ],
            'locale' => 'fr',
        ]);

        $this->assertSame('14.00', $formatter->asDatetime($ts));

        $formatter = new Formatter([
            'timeFormats' => [
                'en' => 'HH/mm/ss',
                'de' => 'mm/HH/ss',
                'fr' => 'HH:mm:ss',
            ],
            'locale' => 'fr',
        ]);

        $this->assertSame('14:00:33', $formatter->asTime($ts));
    }

    public function testautoFormat()
    {
        $formatter = new Formatter();

        $this->assertSame(1, $formatter->autoFormat(1));
        $this->assertSame('Yes', $formatter->autoFormat(true));
        $this->assertSame('No', $formatter->autoFormat(false));
        $this->assertSame('<a href="mailto:demo@luya.io">demo@luya.io</a>', $formatter->autoFormat('demo@luya.io'));
        $this->assertSame('<a href="https://luya.io">https://luya.io</a>', $formatter->autoFormat('https://luya.io'));
    }
}

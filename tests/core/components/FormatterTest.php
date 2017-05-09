<?php

namespace luyatests\core\components;

use luyatests\LuyaWebTestCase;
use luya\components\Formatter;

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
        
        $this->assertSame('2017/2017/2017', $formatter->asDate($ts));
        
        $formatter = new Formatter([
            'datetimeFormats' => [
                'en' => 'HH/mm',
                'de' => 'mm/HH',
                'fr' => 'HH:mm',
            ],
            'locale' => 'de',
        ]);
        
        $this->assertSame('00/16', $formatter->asDatetime($ts));
        
        $formatter = new Formatter([
            'timeFormats' => [
                'en' => 'HH/mm/ss',
                'de' => 'mm/HH/ss',
                'fr' => 'HH:mm:ss',
            ],
            'locale' => 'fr',
        ]);
        
        $this->assertSame('16:00:33', $formatter->asTime($ts));
    }
}
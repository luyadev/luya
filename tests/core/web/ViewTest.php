<?php

namespace luyatests\core\web;

use luya\web\View;

class ViewTest extends \luyatests\LuyaWebTestCase
{
    public function testCompress()
    {
        $view = new View();

        $string = '  ';
        $resultString = $view->compress($string);
        $this->assertEquals(1, strlen($resultString));

        $string = ' ';
        $resultString = $view->compress($string);
        $this->assertEquals(1, strlen($resultString));

        $string = '<test>

        </test>';
        $resultString = $view->compress($string);
        $this->assertEquals(14, strlen($resultString));

        $string = 'test  test test';
        $resultString = $view->compress($string);
        $this->assertEquals(14, strlen($resultString));
    }
}

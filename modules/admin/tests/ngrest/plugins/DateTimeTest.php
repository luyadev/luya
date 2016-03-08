<?php

namespace tests\web\admin\ngrest\plugins;

class DateTimeTest extends \tests\web\BasePlugin
{
    public function testPlugin()
    {
        $text = new \admin\ngrest\plugins\DateTime();
        //$this->assertEquals('<span>{{item.*1000 | date : "dd.MM.yyyy - HH:mm"}}</span>', $this->renderListHtml($text));
        $this->assertEquals('<zaa-datetime fieldid="" fieldname="" model="" label="" i18n=""></zaa-datetime>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-datetime fieldid="" fieldname="" model="" label="" i18n=""></zaa-datetime>', $this->renderUpdateHtml($text));

        /* @todo: test against real config values 
        $text->setConfig('id', 'foo', 'bar', 'baz', 12);
        $this->assertEquals("<span>{{item.}}</span>", $this->renderListHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderUpdateHtml($text));
        */
    }
}

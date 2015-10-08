<?php

namespace tests\web\admin\ngrest\plugins;

class PasswordTest extends \tests\web\BasePlugin
{
    public function testPlugin()
    {
        $text = new \admin\ngrest\plugins\Password();
        $this->assertEquals('<span>{{item.}}</span>', $this->renderListHtml($text));
        $this->assertEquals('<zaa-password fieldid="" fieldname="" model="" label="" i18n=""></zaa-password>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-password fieldid="" fieldname="" model="" label="" i18n=""></zaa-password>', $this->renderUpdateHtml($text));

        /* @todo: test against real config values 
        $text->setConfig('id', 'foo', 'bar', 'baz', 12);
        $this->assertEquals("<span>{{item.}}</span>", $this->renderListHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderUpdateHtml($text));
        */
    }
}

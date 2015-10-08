<?php

namespace tests\web\admin\ngrest\plugins;

class ToggleStatusTest extends \tests\web\BasePlugin
{
    public function testPlugin()
    {
        $text = new \admin\ngrest\plugins\ToggleStatus();
        $this->assertEquals("<span ng-class=\"{'mdi-navigation-check' : item.}\"></span><span ng-class=\"{'mdi-navigation-close' : !item.}\"></span>", $this->renderListHtml($text));
        $this->assertEquals('<zaa-checkbox fieldid="" fieldname="" model="" label="" i18n="" options=\'{"true-value":1,"false-value":0}\'></zaa-checkbox>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-checkbox fieldid="" fieldname="" model="" label="" i18n="" options=\'{"true-value":1,"false-value":0}\'></zaa-checkbox>', $this->renderUpdateHtml($text));

        /* @todo: test against real config values 
        $text->setConfig('id', 'foo', 'bar', 'baz', 12);
        $this->assertEquals("<span>{{item.}}</span>", $this->renderListHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderCreateHtml($text));
        $this->assertEquals('<zaa-text fieldid="" fieldname="" model="" label="" grid="" placeholder=""></zaa-text>', $this->renderUpdateHtml($text));
        */
    }
}

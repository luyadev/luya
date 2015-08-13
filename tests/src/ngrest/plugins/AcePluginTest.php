<?php

namespace tests\src\ngrest\plugins;

class AcePluginTest extends BasePlugin
{
    public function testPlugin()
    {
        $ace = new \admin\ngrest\plugins\Ace();
        
        $this->assertEquals("", $this->renderListHtml($ace));
        $this->assertEquals("<div ui-ace=\"{useWrapMode : true,  showGutter: true, theme:'chrome', mode: 'json'}\" ng-model=\"\"></div>", $this->renderCreateHtml($ace));
        $this->assertEquals("<div ui-ace=\"{useWrapMode : true,  showGutter: true, theme:'chrome', mode: 'json'}\" ng-model=\"\"></div>", $this->renderUpdateHtml($ace));
    }
}
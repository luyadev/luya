<?php

namespace tests\web\admin\ngrest\plugins;

class AceTest extends \tests\web\BasePlugin
{
    public function testPlugin()
    {
        $ace = new \admin\ngrest\plugins\Ace();

        $this->assertEquals('', $this->renderListHtml($ace));
        $this->assertEquals("<div ui-ace=\"{useWrapMode : true,  showGutter: true, theme:'chrome', mode: 'json'}\" ng-model=\"\"></div>", $this->renderCreateHtml($ace));
        $this->assertEquals("<div ui-ace=\"{useWrapMode : true,  showGutter: true, theme:'chrome', mode: 'json'}\" ng-model=\"\"></div>", $this->renderUpdateHtml($ace));
    }
}

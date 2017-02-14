<?php


namespace cmstests\src\widgets;

use cmstests\CmsFrontendTestCase;
use luya\cms\widgets\LangSwitcher;
use yii\base\Widget;

class LangSwitcherTest extends CmsFrontendTestCase
{
    public function testWidgetOutput()
    {
        $this->assertSame('<ul class="list-element">
<li><li class="lang-element-item lang-element-item--active"><a class="lang-link-item lang-link-item--active" href="/luya/envs/dev/public_html/">English</a></li></li>
<li><li class="lang-element-item"><a class="lang-link-item" href="/luya/envs/dev/public_html/de">Deutsch</a></li></li>
</ul>', LangSwitcher::widget());
        
    }
}
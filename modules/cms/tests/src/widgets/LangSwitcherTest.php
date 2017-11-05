<?php


namespace cmstests\src\widgets;

use cmstests\CmsFrontendTestCase;
use luya\cms\widgets\LangSwitcher;

class LangSwitcherTest extends CmsFrontendTestCase
{
    public function testWidgetOutput()
    {
        $this->assertSame('<ul class="list-element">
<li class="lang-element-item lang-element-item--active"><a class="lang-link-item lang-link-item--active" href="/luya/envs/dev/public_html/">English</a></li>
<li class="lang-element-item"><a class="lang-link-item" href="/luya/envs/dev/public_html/de">Deutsch</a></li>
</ul>', LangSwitcher::widget());
    }

    public function testCallable()
    {
        $out = LangSwitcher::widget(['linkLabel' => function ($lang) {
            return strtoupper($lang['short_code']);
        }]);
        
        $this->assertSame('<ul class="list-element">
<li class="lang-element-item lang-element-item--active"><a class="lang-link-item lang-link-item--active" href="/luya/envs/dev/public_html/">EN</a></li>
<li class="lang-element-item"><a class="lang-link-item" href="/luya/envs/dev/public_html/de">DE</a></li>
</ul>', $out);
    }
    
    public function testSortCallable()
    {
        $out = LangSwitcher::widget(['itemsCallback' => function ($items) {
            ksort($items);
            
            return $items;
        }]);
        
        
        $this->assertSame('<ul class="list-element">
<li class="lang-element-item"><a class="lang-link-item" href="/luya/envs/dev/public_html/de">Deutsch</a></li>
<li class="lang-element-item lang-element-item--active"><a class="lang-link-item lang-link-item--active" href="/luya/envs/dev/public_html/">English</a></li>
</ul>', $out);
    }

    public function testOutputWithoutUl()
    {
        $out = LangSwitcher::widget(['noListTag' => true]);

        $this->assertSame('<li class="lang-element-item lang-element-item--active"><a class="lang-link-item lang-link-item--active" href="/luya/envs/dev/public_html/">English</a></li>
<li class="lang-element-item"><a class="lang-link-item" href="/luya/envs/dev/public_html/de">Deutsch</a></li>', $out);
    }
}

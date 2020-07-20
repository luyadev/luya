<?php

namespace luyatests\core\lazyload;

use luyatests\LuyaWebTestCase;
use luya\lazyload\LazyLoad;

class LazyLoadTest extends LuyaWebTestCase
{
    public function testWidget()
    {
        $this->assertSame(
            '<div class="lazyimage-wrapper add"><img class="js-lazyimage lazyimage" data-src="abc.jpg"><div class="lazyimage-placeholder"><div style="display: block; height: 0px; padding-bottom: 56.25%;"></div><div class="loader"></div></div><noscript><img class="lazyimage loaded add" src="abc.jpg" /></noscript></div>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add'])
        );
    }

    public function testWidgetWithOptions()
    {
        $this->assertSame(
            '<div class="lazyimage-wrapper add"><img class="js-lazyimage lazyimage" alt="The image alt" title="The image title" data-src="abc.jpg"><div class="lazyimage-placeholder"><div style="display: block; height: 0px; padding-bottom: 56.25%;"></div><div class="loader"></div></div><noscript><img class="lazyimage loaded add" src="abc.jpg" /></noscript></div>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add', 'options' => ['alt' => 'The image alt', 'title' => 'The image title']])
        );
    }
}

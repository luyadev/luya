<?php

namespace luyatests\core\lazyload;

use luyatests\LuyaWebTestCase;
use luya\lazyload\LazyLoad;

class LazyLoadTest extends LuyaWebTestCase
{
    public function testWidget()
    {
        $this->assertSame('<img class="lazy-image add" data-src="abc.jpg"><noscript><img class="lazy-image add" src="abc.jpg" /></noscript>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add']));
    }

    public function testWidgetWithOptions() {
        $this->assertSame('<img class="lazy-image add" alt="The image alt" title="The image title" data-src="abc.jpg"><noscript><img class="lazy-image add" src="abc.jpg" /></noscript>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add', 'options' => ['alt' => 'The image alt', 'title' => 'The image title']]));
    }
}

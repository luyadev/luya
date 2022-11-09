<?php

namespace luyatests\core\lazyload;

use luya\lazyload\LazyLoad;
use luyatests\LuyaWebTestCase;

class LazyLoadTest extends LuyaWebTestCase
{
    public function testWidget()
    {
        $this->assertSame(
            '<div class="lazyimage-wrapper add"><img class="js-lazyimage lazyimage add" data-src="abc.jpg" data-replace-placeholder="1"><div class="lazyimage-placeholder"><div style="display: block; height: 0px; padding-bottom: 56.25%;"></div><div class="loader"></div></div><noscript><img class="loaded add" src="abc.jpg" /></noscript></div>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add'])
        );
    }

    public function testWidgetWithOptions()
    {
        $this->assertSame(
            '<div class="lazyimage-wrapper add"><img class="js-lazyimage lazyimage add" alt="The image alt" title="The image title" data-src="abc.jpg" data-replace-placeholder="1"><div class="lazyimage-placeholder"><div style="display: block; height: 0px; padding-bottom: 56.25%;"></div><div class="loader"></div></div><noscript><img class="loaded add" src="abc.jpg" /></noscript></div>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add', 'options' => ['alt' => 'The image alt', 'title' => 'The image title']])
        );
    }

    public function testLazyLoadWithHeightCalculationWithNumbers()
    {
        $this->assertSame(
            '<div class="lazyimage-wrapper add"><img class="js-lazyimage lazyimage add" data-src="abc.jpg" data-width="1080" data-height="1920" data-replace-placeholder="1"><div class="lazyimage-placeholder"><div style="display: block; height: 0px; padding-bottom: 177.77777777778%;"></div><div class="loader"></div></div><noscript><img class="loaded add" src="abc.jpg" /></noscript></div>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add', 'height' => 1920,  'width' => 1080])
        );
    }

    public function testLazyLoadAttributesOnly()
    {
        $this->assertSame(
            'class="js-lazyimage add" data-src="abc.jpg" data-width="1080" data-height="1920" data-as-background="1"',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add', 'height' => 1920,  'width' => 1080, 'attributesOnly' => true])
        );
    }

    public function testLazyLoadReplacePlaceholderOptionOff()
    {
        $this->assertSame(
            '<div class="lazyimage-wrapper add"><img class="js-lazyimage lazyimage" data-src="abc.jpg" data-width="1080" data-height="1920" data-replace-placeholder="0"><div class="lazyimage-placeholder"><div style="display: block; height: 0px; padding-bottom: 177.77777777778%;"></div><div class="loader"></div></div><noscript><img class="loaded add" src="abc.jpg" /></noscript></div>',
            LazyLoad::widget(['src' => 'abc.jpg', 'extraClass' => 'add', 'height' => 1920,  'width' => 1080, 'replacePlaceholder' => false])
        );
    }
}

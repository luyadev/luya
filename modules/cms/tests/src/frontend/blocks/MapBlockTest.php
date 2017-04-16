<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class MapBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\MapBlock';

    public function testEmptyRender()
    {
        $this->assertSame('', $this->renderFrontendNoSpace());
    }
    
    public function testAddress()
    {
        $this->block->setVarValues(['address' => 'Mountain View, California, United States']);
        
        $this->assertContains('<iframe src="https://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&q=Mountain+View%2C+California%2C+United+States&z=15&t=h&output=embed" width="600" height="450" frameborder="0" style="border:0"></iframe>', $this->renderFrontendNoSpace());
    }
    
    public function testZoomAndType()
    {
        $this->block->setVarValues(['address' => 'Mountain View, California, United States', 'zoom' => 1, 'maptype' => 'k']);
    
        $this->assertContains('<iframe src="https://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&q=Mountain+View%2C+California%2C+United+States&z=1&t=k&output=embed" width="600" height="450" frameborder="0" style="border:0"></iframe>', $this->renderFrontendNoSpace());
    }
}

<?php

namespace cmstests\src\helpers;

use cmstests\CmsFrontendTestCase;
use luya\cms\helpers\BlockHelper;

class BlockHelperTest extends CmsFrontendTestCase
{
    public function testSelectArrayOption()
    {
        $this->assertSame([['value' => 'Hello', 'label' => 'World']], BlockHelper::selectArrayOption(['Hello' => 'World']));
    }
    
    public function testCheckboxArrayOption()
    {
        $this->assertSame(['items' => [['value' => 'Hello', 'label' => 'World']]], BlockHelper::checkboxArrayOption(['Hello' => 'World']));
    }
    
    public function testImageUpload()
    {
        $this->assertFalse(BlockHelper::imageUpload(1));
    }
    public function testImageArrayUpload()
    {
        $this->assertSame([], BlockHelper::imageArrayUpload([
            ['imageId' => 1],
            ['imageId' => 2]
        ]));
    }
    
    public function testFileUpload()
    {
        $this->assertFalse(BlockHelper::fileUpload(1));
    }
    public function testFileArrayUpload()
    {
        $this->assertSame([], BlockHelper::fileArrayUpload(
            [
            ['fileId' => 1],
            ['fileId' => 2]
        ]
        ));
    }

    public function testInternalGenerateLinkObject()
    {
        $url = BlockHelper::linkObject(['type' => 1, 'value' => 2]);
        $this->assertInstanceOf('luya\web\LinkInterface', $url);
        
        $this->assertSame('_self', $url->getTarget());
    }
    
    public function testExternalGenerateLinkObject()
    {
        $url = BlockHelper::linkObject(['type' => 2, 'value' => 'https://luya.io']);
        $this->assertInstanceOf('luya\web\LinkInterface', $url);
    
        $this->assertSame('_blank', $url->getTarget());
    }
}

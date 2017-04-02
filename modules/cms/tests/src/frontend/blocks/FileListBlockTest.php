<?php

namespace cmstests\src\frontend\blocks;

use luya\cms\frontend\blocks\FileListBlock;
use cmstests\BlockTestCase;

class FileListBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\FileListBlock';
    
    public function testEmpty()
    {
        $this->assertEmpty($this->renderFrontend());
    }
    
    public function testFiles()
    {
        $this->block->addExtraVar('fileList', [
                ['source' => 'path/to/image.jpg', 'caption' => 'foobar', 'extension' => 'jpg'],
        ]);
        $this->assertContains('<ul><li><a target="_blank" href="path/to/image.jpg">foobar</a></li></ul>', $this->renderFrontendNoSpace());
    }

    public function testFilesWithSuffix()
    {
        $this->block->setCfgValues(['showType' => 1]);
        $this->block->addExtraVar('fileList', [
                ['source' => 'path/to/image.jpg', 'caption' => 'foobar', 'extension' => 'jpg'],
        ]);
        $this->assertContains('<ul><li><a target="_blank" href="path/to/image.jpg">foobar (jpg)</a></li></ul>', $this->renderFrontendNoSpace());
    }
}

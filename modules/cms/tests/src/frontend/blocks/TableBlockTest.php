<?php

namespace cmstests\src\frontend\blocks;

use cmstests\BlockTestCase;

class TableBlockTest extends BlockTestCase
{
    public $blockClass = 'luya\cms\frontend\blocks\TableBlock';
    
    public function testEmptyRender()
    {
        $this->assertSame('', $this->renderFrontendNoSpace());
    }
    
    public function testTableData()
    {
        $this->block->setVarValues(['table' => [[1,2,3], ['a', 'b', 'c']]]);
        $this->assertSame('<div><table class="table"><tbody><tr><td>1</td><td>2</td><td>3</td></tr><tr><td>a</td><td>b</td><td>c</td></tr></tbody></table></div>', $this->renderFrontendNoSpace());
    }
    
    public function testTableDataWithHeader()
    {
        $this->block->setVarValues(['table' => [[1,2,3], ['a', 'b', 'c']]]);
        $this->block->setCfgValues(['header' => 1]);
        $this->assertSame('<div><table class="table"><thead><tr><th>1</th><th>2</th><th>3</th></tr></thead><tbody><tr><td>a</td><td>b</td><td>c</td></tr></tbody></table></div>', $this->renderFrontendNoSpace());
    }
    
    public function testTableDataWithMarkdown()
    {
        $this->block->setVarValues(['table' => [[1,2,3], ['*a*', 'b', 'c']]]);
        $this->block->setCfgValues(['parseMarkdown' => 1]);
        $this->assertSame('<div><table class="table"><tbody><tr><td><p>1</p></td><td><p>2</p></td><td><p>3</p></td></tr><tr><td><p><em>a</em></p></td><td><p>b</p></td><td><p>c</p></td></tr></tbody></table></div>', $this->renderFrontendNoSpace());
    }
    
    public function testWithAllOptions()
    {
        $this->block->setVarValues(['table' => [[1,2,3], ['*a*', 'b', 'c']]]);
        $this->block->setCfgValues([
            'divCssClass' => 'foo-bar',
            'equaldistance' => 1,
            'border' => 1,
            'stripe' => 1,
            'header' => 1,
        ]);
        $this->assertSame('<div class="foo-bar"><table class="table table-striped table-bordered"><thead><tr><th>1</th><th>2</th><th>3</th></tr></thead><tbody><tr><td class="col-md-4">*a*</td><td class="col-md-4">b</td><td class="col-md-4">c</td></tr></tbody></table></div>', $this->renderFrontendNoSpace());
    }
}

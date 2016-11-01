<?php

namespace cmstests\src\injectors;

use cmstests\CmsFrontendTestCase;
use luya\cms\injectors\ActiveQueryCheckboxInjector;
use cmstests\data\blocks\UnitTestBlock;
use luya\cms\models\NavItem;

class Block extends UnitTestBlock
{
    public function name()
    {
        return 'test';
    }
    
    public function config()
    {
        return [];
    }
}

class ActiveQueryCheckboxInjectorTest extends CmsFrontendTestCase
{
    public function testBasicInjector()
    {
        $block = new Block();
        $injector = new ActiveQueryCheckboxInjector(['query' => NavItem::find(), 'varName' => 'test', 'varLabel' => 'test label', 'context' => $block]);
        $injector->setup();
        
        $vars = $block->getVarsExport();
        
        $v = $vars[0];
        
        $this->assertSame('test', $v['var']);
        $this->assertSame('test label', $v['label']);
        
        $items = $v['options']['items'];
        
        $this->assertNotEmpty(count($items));
        
        $item1 = $v['options']['items'][0];
        
        $this->assertSame('Homepage, homepage', $item1['label']);
    }
    
    public function testFieldSelectionBasicInjector()
    {
        $block = new Block();
        $injector = new ActiveQueryCheckboxInjector(['query' => NavItem::find()->select(['title']), 'varName' => 'test', 'varLabel' => 'test label', 'context' => $block]);
        $injector->setup();
    
        $vars = $block->getVarsExport();
    
        $v = $vars[0];
    
        $this->assertSame('test', $v['var']);
        $this->assertSame('test label', $v['label']);
    
        $items = $v['options']['items'];
    
        $this->assertNotEmpty(count($items));
    
        $item1 = $v['options']['items'][0];
    
        $this->assertSame('Homepage', $item1['label']);
    }
}

<?php

namespace cmstests\src\menu;

use Yii;
use cmstests\CmsFrontendTestCase;
use luya\cms\menu\InjectItem;

class InjectItemTest extends CmsFrontendTestCase
{
    public function testINvalidChildOfInput()
    {
        $this->expectException('luya\cms\Exception');
        $item = new InjectItem(['alias' => 'foo bar', 'childOf' => 0, 'title' => 'Hello Word']);
        $item->toArray();
    }
    
    public function testToArray()
    {
        $item = new InjectItem(['alias' => 'foo bar', 'childOf' => 1, 'title' => 'Hello Word']);
        $a = $item->toArray();
        
        $this->assertSame('homepage/foo-bar', $a['alias']);
        $this->assertSame('homepage/foo-bar', $item->alias);
    }
    
    public function testChainMethodToArray()
    {
        $array = (new InjectItem())->setAlias('bar-foo')->setItem(Yii::$app->menu->home)->setTitle('World Hello')->toArray();
        
        $this->assertSame('homepage/bar-foo', $array['alias']);
    }
    
    public function testSetAliasFromTitle()
    {
        $object = (new InjectItem())->setTitle('Hello ! World!')->setChildOf(1);
        
        $this->assertSame('homepage/hello-world', $object->alias);
        
        $alis = (new InjectItem())->setTitle('Foo Bar')->setAlias('luya-alias')->setChildOf(1);
        
        $this->assertSame('homepage/luya-alias', $alis->alias);
        
        $notoverride = (new InjectItem())->setAlias('luya-io')->setTitle('Hello')->setChildOf(1);
        
        $this->assertSame('homepage/luya-io', $notoverride->alias);
    }
}

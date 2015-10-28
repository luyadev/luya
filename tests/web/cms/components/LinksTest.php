<?php

namespace tests\web\cms\components;

use Yii;

class LinksTest extends \tests\web\Base
{
    public function setUp()
    {
        parent::setUp();
        
        Yii::$app->composition->setKey('langShortCode', 'de');
    }
    
    public function testGetDefaultLinkUrl()
    {
        $this->assertEquals('page-1', Yii::$app->links->getDefaultLink());
    }
    
    public function testGetResolvActiveLink()
    {
        $this->assertEquals('page-1', Yii::$app->links->getResolveActiveUrl());
    }
    
    public function testIsolationsOfLinks()
    {
        $links = Yii::$app->links;
        
        $this->assertEquals('page-1', $links->isolateLinkSuffix('page-1/test'));
        $this->assertEquals('page-2', $links->isolateLinkSuffix('page-2/test'));
        $this->assertEquals(false, $links->isolateLinkSuffix('de/page-1/test'));
        $this->assertEquals(false, $links->isolateLinkSuffix('en/page-1/test'));
        $this->assertEquals(false, $links->isolateLinkSuffix('de/page-1'));
        $this->assertEquals(false, $links->isolateLinkSuffix('en/page-1'));
        
        $this->assertEquals('test', $links->isolateLinkAppendix('page-1/test', $links->isolateLinkSuffix('page-1/test')));
        $this->assertEquals('test/bar', $links->isolateLinkAppendix('page-1/test/bar', $links->isolateLinkSuffix('page-1/test/bar')));
    }
    
    public function testLinkProperties()
    {
        $link = Yii::$app->links->findOneByArguments(['url' => 'page-1']);
        
        $this->assertArrayHasKey('full_url', $link);
        $this->assertEquals('', $link['full_url']);
        
        $this->assertArrayHasKey('url', $link);
        $this->assertEquals('page-1', $link['url']);
        
        $this->assertArrayHasKey('rewrite', $link);
        $this->assertEquals('page-1', $link['rewrite']);
        
        $this->assertArrayHasKey('nav_id', $link);
        $this->assertEquals('1', $link['nav_id']);
        
        $this->assertArrayHasKey('parent_nav_id', $link);
        $this->assertEquals('0', $link['parent_nav_id']);
        
        $this->assertArrayHasKey('id', $link);
        $this->assertEquals('1', $link['id']);
        
        $this->assertArrayHasKey('title', $link);
        $this->assertEquals('Page 1', $link['title']);
        
        $this->assertArrayHasKey('lang', $link);
        $this->assertEquals('de', $link['lang']);
        
        $this->assertArrayHasKey('lang_id', $link);
        $this->assertEquals('1', $link['lang_id']);
        
        $this->assertArrayHasKey('cat', $link);
        $this->assertEquals('default', $link['cat']);
        
        $this->assertArrayHasKey('depth', $link);
        $this->assertEquals('0', $link['depth']);
        
    }
    
    public function testLink2Properties()
    {
        $link = Yii::$app->links->findOneByArguments(['url' => 'page-2']);
    
        $this->assertArrayHasKey('full_url', $link);
        $this->assertEquals('de/page-2', $link['full_url']);
    
        $this->assertArrayHasKey('url', $link);
        $this->assertEquals('page-2', $link['url']);
    
        $this->assertArrayHasKey('rewrite', $link);
        $this->assertEquals('page-2', $link['rewrite']);
    
        $this->assertArrayHasKey('nav_id', $link);
        $this->assertEquals('2', $link['nav_id']);
    
        $this->assertArrayHasKey('parent_nav_id', $link);
        $this->assertEquals('0', $link['parent_nav_id']);
    
        $this->assertArrayHasKey('id', $link);
        $this->assertEquals('2', $link['id']);
    
        $this->assertArrayHasKey('title', $link);
        $this->assertEquals('Page 2', $link['title']);
    
        $this->assertArrayHasKey('lang', $link);
        $this->assertEquals('de', $link['lang']);
    
        $this->assertArrayHasKey('lang_id', $link);
        $this->assertEquals('1', $link['lang_id']);
    
        $this->assertArrayHasKey('cat', $link);
        $this->assertEquals('default', $link['cat']);
    
        $this->assertArrayHasKey('depth', $link);
        $this->assertEquals('0', $link['depth']);
    
    }
    
    public function testLanguageContainers()
    {
        $links = Yii::$app->links->getLinksLanguageContainer('1');
        
        $this->assertEquals(true, is_array($links));
        $this->assertEquals(4, count($links));
        
        $links = Yii::$app->links->getLinksLanguageContainer(1);
        
        $this->assertEquals(true, is_array($links));
        $this->assertEquals(4, count($links));
        
        $links = Yii::$app->links->getLinksLanguageContainer('de');
        
        $this->assertEquals(true, is_array($links));
        $this->assertEquals(4, count($links));
        
        $links = Yii::$app->links->getLinksLanguageContainer('en');
        
        $this->assertEquals(true, is_array($links));
        $this->assertEquals(0, count($links));
        
    }
    
    public function testFindByArguments()
    {
        $links = Yii::$app->links;
        
        $finder = $links->findByArguments(['url' => 'page-1']);
        
        $this->assertEquals(1, count($finder));
        
        $finder = $links->findByArguments(['url' => 'page-1', 'lang' => 'de']);
        
        $this->assertEquals(1, count($finder));
        
        $finder = $links->findByArguments(['url' => 'page-1', 'lang_id' => 1]);
        
        $this->assertEquals(1, count($finder));
        
        $finder = $links->findByArguments(['url' => 'page-1', 'lang' => 'en']);
        
        $this->assertEquals(0, count($finder));
        
        $finder = $links->findByArguments(['url' => 'page-1', 'lang_id' => 2]);
        
        $this->assertEquals(0, count($finder));
        
        $finder = $links->findByArguments([]);
        
        $this->assertEquals(4, count($finder));

        $finder = $links->findByArguments(['lang_id' => 2]);
        
        $this->assertEquals(0, count($finder));
    }
    
    public function testFindAllOneWrapper()
    {
        $links = Yii::$app->links;
        
        // all
        
        $finder = $links->findByArguments(['url' => 'page-1']);
        
        $this->assertEquals(1, count($finder));
        
        $finder = $links->findAll(['url' => 'page-1']);
        
        $this->assertEquals(1, count($finder));
        
        // one
        
        $finder = $links->findOneByArguments(['url' => 'page-1']);
        
        $this->assertEquals('', $finder['full_url']);
        
        $finder = $links->findOne(['url' => 'page-1']);
        
        $this->assertEquals('', $finder['full_url']);
    }
}
<?php

namespace tests\web\cms\menu;


use Yii;
use cms\components\Menu;

class ContainerTest extends \tests\web\Base
{
    public function testComponentExists()
    {
        $this->assertTrue(is_object(Yii::$app->menu));
    }
    
    public function testSelfClass()
    {
        $objectData = new \cms\menu\Container((new \luya\web\Request()));
        $current = $objectData->current;
        $this->assertEquals("Homepage", $current->title);
        $this->assertEquals(Yii::$app->urlManager->prependBaseUrl(''), $current->link);
    }
    
    public function testGetCurrent()
    {
        $current = Yii::$app->menu->current;
        $this->assertEquals("Homepage", $current->title);
        $this->assertEquals(Yii::$app->urlManager->prependBaseUrl(''), $current->link);
    }
    
    public function testGetHome()
    {
        $home = Yii::$app->menu->home;
        $this->assertEquals("Homepage", $home->title);
        $this->assertEquals(Yii::$app->urlManager->prependBaseUrl(''), $home->link);
    }
    
    public function testOffsetArrayAccess()
    {
        $menu = Yii::$app->menu;
        $this->assertEquals(10, count($menu['de']));
        $this->assertEquals(10, count($menu['en']));
    }
    
    public function testCurrentAppendix()
    {
        $this->assertFalse(Yii::$app->menu->currentAppendix);
    }
    
    public function testFind()
    {
        $obj = Yii::$app->menu->find();
        $this->assertTrue($obj instanceof \cms\menu\Query);
    }
    
    public function testFindOne()
    {
        $obj = Yii::$app->menu->findOne(['id' => 1]);
        $this->assertTrue($obj instanceof \cms\menu\Item);
    }
    
    public function testFindOneFalse()
    {
        $obj = Yii::$app->menu->findOne(['id' => 2000]);
        $this->assertFalse($obj);
    }
    
    public function testFindAll()
    {
        $iterator = Yii::$app->menu->findAll(['parent_nav_id' => 0]);
        $this->assertTrue($iterator instanceof \cms\menu\QueryIteratorFilter);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testOffsetLangaugeDoesNotExists()
    {
        Yii::$app->menu['ru'];
    }
}

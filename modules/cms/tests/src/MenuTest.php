<?php


namespace cmstests\src;

use Yii;
use cmstests\CmsFrontendTestCase;
use luya\cms\Menu;
use luya\cms\menu\QueryIteratorFilter;
use luya\cms\menu\Query;
use luya\cms\menu\Item;

class MenuTest extends CmsFrontendTestCase
{
    public function testComponentExists()
    {
        $this->assertTrue(is_object(Yii::$app->menu));
    }
    
    public function testSelfClass()
    {
        $objectData = new Menu((new \luya\web\Request()));
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
        $this->assertEquals(17, count($menu['en']));
    }
    
    public function testCurrentAppendix()
    {
        $this->assertFalse(Yii::$app->menu->currentAppendix);
    }
    
    public function testFind()
    {
        $obj = Yii::$app->menu->find();
        $this->assertTrue($obj instanceof Query);
    }
    
    public function testFindOne()
    {
        $obj = Yii::$app->menu->findOne(['id' => 1]);
        $this->assertTrue($obj instanceof Item);
    }
    
    public function testFindOneFalse()
    {
        $obj = Yii::$app->menu->findOne(['id' => 2000]);
        $this->assertFalse($obj);
    }
    
    public function testFindAll()
    {
        $iterator = Yii::$app->menu->findAll(['parent_nav_id' => 0]);
        $this->assertTrue($iterator instanceof QueryIteratorFilter);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testOffsetLangaugeDoesNotExists()
    {
        Yii::$app->menu['ru'];
    }
}

<?php

namespace tests\web\cms\menu;

use Yii;
use admin\models\User;

class ItemTest extends \tests\web\Base
{
    public function testItemFunctions()
    {
        $obj = Yii::$app->menu->findOne(['id' => 1]);
        
        $this->assertEquals(1, $obj->id);
        $this->assertEquals("default", $obj->container);
        $this->assertEquals(1, $obj->navId);
        $this->assertEquals(0, $obj->parentNavId);
        $this->assertEquals("Homepage", $obj->title);
        $this->assertEquals(1, $obj->type);
        $this->assertEquals("", $obj->description);
        $this->assertEquals("homepage", $obj->alias);
        $this->assertEquals(1452169829, $obj->dateCreated);
        $this->assertEquals(0, $obj->dateUpdated);
        //$user->assertTrue($obj->userCreated instanceof User);
        //$user->assertTrue($obj->userUpdated instanceof User);
        $this->assertEquals("/luya/envs/dev/public_html/", $obj->link);
        $this->assertEquals(true, $obj->isActive);
        $this->assertEquals(1, $obj->depth);
        $this->assertEquals(false, $obj->parent);
        $this->assertEquals(0, count($obj->parents));
        $this->assertEquals(7, count($obj->siblings));
        $this->assertEquals(1, count($obj->teardown));
        $this->assertEquals(0, count($obj->children));
        $this->assertFalse($obj->hasChildren());
    }
}
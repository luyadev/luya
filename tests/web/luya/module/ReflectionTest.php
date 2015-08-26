<?php

namespace tests\web\luya\module;

use Yii;

class ReflectionTest extends \tests\web\Base
{
    public function testShareObject()
    {
        $ref = new \luya\module\Reflection(Yii::$app->getModule('unitmodule'));
        $ref->setInitRun('unit-test', 'index', ['x' => 'y']);
        $content = $ref->responseContent();
        
        $this->assertEquals(5, count($content));
        
        $this->assertEquals("unit-test", $content['id']);
        $this->assertEquals("unitmodule", $content['module']);
        $this->assertEquals("@app/views/unitmodule/unit-test", $content['viewPath']);
        $this->assertEquals("@app/views/unitmodule/", $content['moduleLayoutViewPath']);
        
    }
    
    public function testModuleObject()
    {
        $ref = new \luya\module\Reflection(Yii::$app->getModule('unitmodule'));
        $ref->setInitRun('unit-test-2', 'index', ['x' => 'y']);
        $content = $ref->responseContent();
    
        $this->assertEquals(5, count($content));
    
        $this->assertEquals("unit-test-2", $content['id']);
        $this->assertEquals("unitmodule", $content['module']);
        $this->assertNotEquals("@app/views/unitmodule/unit-test", $content['viewPath']);
        $this->assertEquals("@app/views/unitmodule/", $content['moduleLayoutViewPath']);
    
    }
}
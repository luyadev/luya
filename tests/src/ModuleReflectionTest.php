<?php

namespace tests\src;

use Yii;

class ModuleReflectionTests extends \tests\BaseWebTest
{
    public function testShareObject()
    {
        $ref = new \luya\module\Reflection(Yii::$app->getModule('moduletest'));
        $ref->setInitRun('unit-test', 'index', ['x' => 'y']);
        $content = $ref->responseContent();
        
        $this->assertEquals(5, count($content));
        
        $this->assertEquals("unit-test", $content['id']);
        $this->assertEquals("moduletest", $content['module']);
        $this->assertEquals("@app/views/moduletest/unit-test", $content['viewPath']);
        $this->assertEquals("@app/views/moduletest/", $content['moduleLayoutViewPath']);
        
    }
    
    public function testModuleObject()
    {
        $ref = new \luya\module\Reflection(Yii::$app->getModule('moduletest'));
        $ref->setInitRun('unit-test-2', 'index', ['x' => 'y']);
        $content = $ref->responseContent();
    
        $this->assertEquals(5, count($content));
    
        $this->assertEquals("unit-test-2", $content['id']);
        $this->assertEquals("moduletest", $content['module']);
        $this->assertNotEquals("@app/views/moduletest/unit-test", $content['viewPath']);
        $this->assertEquals("@app/views/moduletest/", $content['moduleLayoutViewPath']);
    
    }
}
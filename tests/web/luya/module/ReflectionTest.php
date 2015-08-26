<?php

namespace tests\web\luya\module;

use Yii;

class ReflectionTest extends \tests\web\Base
{
    public function testShareObject()
    {
        $ref = new \luya\module\Reflection(Yii::$app->getModule('unitmodule'));
        $ref->setInitRun('unit-test', 'index', ['x' => 'y']);
        $reflectionRequest = $ref->getRequestResponse();
        $content = $ref->responseContent($reflectionRequest);
        
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
        $reflectionRequest = $ref->getRequestResponse();
        $content = $ref->responseContent($reflectionRequest);
    
        $this->assertEquals(5, count($content));
    
        $this->assertEquals("unit-test-2", $content['id']);
        $this->assertEquals("unitmodule", $content['module']);
        $this->assertNotEquals("@app/views/unitmodule/unit-test", $content['viewPath']);
        $this->assertEquals("@app/views/unitmodule/", $content['moduleLayoutViewPath']);
    
    }
    
    public function testModuleSuffix()
    {
        $ref = new \luya\module\Reflection(Yii::$app->getModule('urlmodule'));
        $ref->setModuleSuffix('bar');
        $response = $ref->getRequestResponse();
        
        $this->assertArrayHasKey('route', $response);
        $this->assertArrayHasKey('args', $response);
        
        $this->assertEquals('urlmodule/bar/index', $response['route']);
        $this->assertEquals(0, count($response['args']));
        
        $controllerResponse = $ref->responseContent($response);
        
        $this->assertEquals('bar', $controllerResponse);
    }
    
    /**
     * @expectedException Exception
     */
    public function testNotFoundControllerException()
    {
        $ref = new \luya\module\Reflection(Yii::$app->getModule('urlmodule'));
        $ref->setInitRun('foo', 'index');
        $request = $ref->getRequestResponse();
        // throws:  Controller not found. The requested module reflection route 'foo/index' could not be found.
        $resposne = $ref->responseContent($request);
    }
}
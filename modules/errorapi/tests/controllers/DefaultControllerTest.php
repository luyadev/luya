<?php

namespace tests\web\errorapi\controllers;


use Yii;

class DefaultControllerTest extends \tests\web\Base
{
    public function testCreateEmptyData()
    {
        $response = Yii::$app->getModule('errorapi')->runAction('default/create');
        $this->assertEquals(true, is_array($response));
        $this->arrayHasKey('error_json', $response);
    }
    
    public function testCreateMissingData()
    {
        Yii::$app->request->setBodyParams(['error_json' => json_encode(['do' => 'fa'])]);
    
        $response = Yii::$app->getModule('errorapi')->runAction('default/create');
        $this->assertEquals(true, is_array($response));
        $this->arrayHasKey('error_json', $response);
        $this->assertEquals($response['error_json'][0], 'error_json must contain message and serverName keys with values.');
    }
    
    public function testCreateData()
    {
        Yii::$app->request->setBodyParams(['error_json' => json_encode(['information' => ['foo' => 'bar'], 'message' => 'What?', 'serverName' => 'example.com', 'trace' => [['message' => 'yes', 'file' => 'file.php', 'line' => 11], ['message' => 'no', 'fle' => 'otherfile.php', 'line' => 27]]])]);
        
        $response = Yii::$app->getModule('errorapi')->runAction('default/create');
        
        $this->assertTrue($response);
    }
}
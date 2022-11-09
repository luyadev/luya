<?php

namespace luyatests\core\rest;

use luya\rest\Controller;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\base\Model;

class FooModel extends Model
{
    public $firstname;

    public $email;

    public function rules()
    {
        return [
            [['firstname', 'email'], 'required'],
        ];
    }
}

class ControllerTest extends LuyaWebTestCase
{
    public function testSendModelErrorException()
    {
        $ctrl = new Controller('test', Yii::$app);

        $model = new FooModel();

        $this->expectException('yii\base\InvalidParamException');
        $ctrl->sendModelError($model);
    }

    public function testSendModelError()
    {
        $ctrl = new Controller('test', Yii::$app);

        $model = new FooModel();
        $model->validate();

        $response = $ctrl->sendModelError($model);

        $this->assertSame(2, count($response));
        $this->arrayHasKey('field', $response[0]);
        $this->assertSame('firstname', $response[0]['field']);
        $this->arrayHasKey('message', $response[0]);
    }

    public function testSendArrayError()
    {
        $ctrl = new Controller('test', Yii::$app);

        $this->assertSame([
            ['field' => 'field1', 'message' => 'message1'],
            ['field' => 'field2', 'message' => 'message2a'],
            ['field' => 'field2', 'message' => 'message2b'],
        ], $ctrl->sendArrayError([
            'field1' => 'message1',
            'field2' => ['message2a', 'message2b'],
        ]));
    }
}

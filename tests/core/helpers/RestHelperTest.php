<?php

namespace luyatests\core\helpers;

use luyatests\LuyaWebTestCase;
use yii\base\DynamicModel;
use luya\helpers\RestHelper;

class RestHelperTest extends LuyaWebTestCase
{
    public function testSendModelError()
    {
        $model = new DynamicModel(['foo', 'bar']);

        $model->addError('foo', 'error!');

        $this->assertSame([
            [
                'field' => 'foo',
                'message' => 'error!',
            ]
        ], RestHelper::sendModelError($model));
    }

    public function testSendModelWithoutError()
    {
        $model = new DynamicModel(['foo', 'bar']);

        $this->expectException('yii\base\InvalidParamException');
        RestHelper::sendModelError($model);
    }


    public function testSendArrayError()
    {
        $this->assertSame([
            [
                'field' => 'foo',
                'message' => 'error!',
            ]
        ], RestHelper::sendArrayError(['foo' => 'error!']));
    }
}
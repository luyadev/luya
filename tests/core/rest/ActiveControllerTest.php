<?php

namespace luyatests\core\rest;

use luya\rest\ActiveController;
use luyatests\LuyaWebTestCase;
use Yii;

class StubActiveController extends ActiveController
{
    public $modelClass = 'luyatests\data\models\UserModel';
}

class ActiveControllerTest extends LuyaWebTestCase
{
    public function testActionDefinition()
    {
        $ctrl = new StubActiveController('stub', Yii::$app);

        $this->assertArrayHasKey('index', $ctrl->actions());
        $this->assertSame('yii\rest\IndexAction', $ctrl->actions()['index']['class']);
        $this->assertArrayHasKey('delete', $ctrl->actions());
        $this->assertSame('yii\rest\DeleteAction', $ctrl->actions()['delete']['class']);
    }

    public function testActionCheckAccessNullify()
    {
        $ctrl = new StubActiveController('stub', Yii::$app);
        $this->assertEmpty($ctrl->checkAccess('index'));
    }
}

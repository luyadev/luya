<?php

namespace luyatests\core\traits;

use luya\rest\Controller;
use luya\rest\UserBehaviorInterface;
use luyatests\data\models\User;
use luyatests\LuyaWebTestCase;
use Yii;

class RestBehaviorsTraitTestStubWithUserBehaviorFalse extends Controller implements UserBehaviorInterface
{
    public function userAuthClass()
    {
        false;
    }
}

class RestBehaviorsTraitTestStubWithUserBehaviorString extends Controller implements UserBehaviorInterface
{
    public function userAuthClass()
    {
        return 'luyatests\data\models\User';
    }
}

class RestBehaviorsTraitTestStubWithUserBehaviorArray extends Controller implements UserBehaviorInterface
{
    public function userAuthClass()
    {
        return ['class' => 'luyatests\data\models\User'];
    }
}

class RestBehaviorsTraitTestStubWithUserBehaviorObject extends Controller implements UserBehaviorInterface
{
    public function userAuthClass()
    {
        return (new User());
    }
}

class RestBehaviorsTraitTestStubWithoutUser extends Controller
{
}

class RestBehaviorsTraitTest extends LuyaWebTestCase
{
    public function testFalseUserAuthClass()
    {
        $controller = new RestBehaviorsTraitTestStubWithUserBehaviorFalse('controller', Yii::$app);

        $this->assertArrayHasKey('verbFilter', $controller->behaviors());
        $this->assertArrayHasKey('contentNegotiator', $controller->behaviors());
        $this->assertArrayNotHasKey('authenticator', $controller->behaviors());
    }

    public function testWithoutUserAuthClass()
    {
        $controller = new RestBehaviorsTraitTestStubWithoutUser('controller', Yii::$app);

        $this->assertArrayHasKey('verbFilter', $controller->behaviors());
        $this->assertArrayHasKey('contentNegotiator', $controller->behaviors());
        $this->assertArrayNotHasKey('authenticator', $controller->behaviors());
    }

    public function testStringUserAuthClass()
    {
        $controller = new RestBehaviorsTraitTestStubWithUserBehaviorString('controller', Yii::$app);

        $this->assertArrayHasKey('verbFilter', $controller->behaviors());
        $this->assertArrayHasKey('contentNegotiator', $controller->behaviors());
        $this->assertArrayHasKey('authenticator', $controller->behaviors());
        $this->assertInstanceOf('yii\web\User', $controller->behaviors()['authenticator']['user']);
    }

    public function testObjectUserAuthClass()
    {
        $controller = new RestBehaviorsTraitTestStubWithUserBehaviorObject('controller', Yii::$app);

        $this->assertArrayHasKey('verbFilter', $controller->behaviors());
        $this->assertArrayHasKey('contentNegotiator', $controller->behaviors());
        $this->assertArrayHasKey('authenticator', $controller->behaviors());
        $this->assertInstanceOf('yii\web\User', $controller->behaviors()['authenticator']['user']);
    }

    public function testArrayUserAuthClass()
    {
        $controller = new RestBehaviorsTraitTestStubWithUserBehaviorArray('controller', Yii::$app);

        $this->assertArrayHasKey('verbFilter', $controller->behaviors());
        $this->assertArrayHasKey('contentNegotiator', $controller->behaviors());
        $this->assertArrayHasKey('authenticator', $controller->behaviors());
        $this->assertInstanceOf('yii\web\User', $controller->behaviors()['authenticator']['user']);
    }

    public function testCorsConfig()
    {
        $this->app->corsConfig = [
            'class' => 'invalid\cors\class',
        ];
        $ctrl = new RestBehaviorsTraitTestStubWithoutUser('id', $this->app);
        $ctrl->enableCors = true;

        $behaviors = $ctrl->behaviors();

        $this->assertSame(['class' => 'invalid\cors\class'], $behaviors['cors']);
    }
}

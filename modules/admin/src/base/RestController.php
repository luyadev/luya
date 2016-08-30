<?php

namespace luya\admin\base;

use Yii;
use luya\rest\UserBehaviorInterface;
use luya\rest\Controller;

/**
 * provides the basic functionality to access and serialize this controller via rest
 * api. Does not define the method names!
 *
 * ´´´
 * class TestController extends \admin\base\RestController
 * {
 *     public function actionFooBar()
 *     {
 *         return ['foo', 'bar'];
 *     }
 * }
 *
 * @author nadar
 */
class RestController extends Controller implements UserBehaviorInterface
{
    public function userAuthClass()
    {
        return Yii::$app->adminuser;
    }
}

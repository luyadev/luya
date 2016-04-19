<?php

namespace admin\base;

use Yii;

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
 *
 */
class RestController extends \luya\rest\Controller implements \luya\rest\BehaviorInterface
{
    public function userAuthClass()
    {
        return Yii::$app->adminuser;
    }

    public function getUser()
    {
        return $this->userAuthClass()->getIdentity();
    }
}

<?php

namespace luya\admin\base;

use Yii;
use luya\rest\UserBehaviorInterface;
use luya\rest\Controller;

/**
 * Base class for RestControllers.
 *
 * provides the basic functionality to access and serialize this controller via rest
 * api. Does not define the method names!
 *
 *```php
 * class TestController extends \luya\admin\base\RestController
 * {
 *     public function actionFooBar()
 *     {
 *         return ['foo', 'bar'];
 *     }
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RestController extends Controller implements UserBehaviorInterface
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->enableCors = Yii::$app->auth->cors;
    }
    
    /**
     * @inheritdoc
     */
    public function userAuthClass()
    {
        return Yii::$app->adminuser;
    }
}

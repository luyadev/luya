<?php
namespace admin\base;

/*
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
class RestController extends \yii\web\Controller implements \luya\rest\BehaviorInterface
{
    use \luya\rest\BehaviorTrait;
    
    public $serializer = 'yii\rest\Serializer';

    public $enableCsrfValidation = false;

    public function userAuthClass()
    {
        return new \admin\components\User();
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        return $this->serializeData($result);
    }

    protected function serializeData($data)
    {
        return \Yii::createObject($this->serializer)->serialize($data);
    }
}

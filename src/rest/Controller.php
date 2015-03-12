<?php
namespace luya\rest;

/*
 * Basic
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
class Controller extends \yii\web\Controller
{
    use \luya\rest\BehaviorTrait;

    public $serializer = 'yii\rest\Serializer';

    public $enableCsrfValidation = false;

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

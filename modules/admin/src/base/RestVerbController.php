<?php

namespace admin\base;

use Yii;

/**
 * Does allow the implementation of a yii2 rest controller based on the verbs inside the
 * url rules defintions. The allowed methods must base on the yii2 rest controller norm like.
 * Allowed actions:
 * - actionIndex();
 * - actionView($id);
 * - actionUpdate($id);
 * - actionCreate();
 * - actionDelete($id);.
 */
class RestVerbController extends \yii\rest\Controller implements \luya\rest\BehaviorInterface
{
    use \luya\rest\BehaviorTrait;

    public function userAuthClass()
    {
        return Yii::$app->adminuser;
    }

    public function actionIndex()
    {
        $this->throwException(__METHOD__);
    }

    public function actionView($id)
    {
        $this->throwException(__METHOD__);
    }

    public function actionUpdate($id)
    {
        $this->throwException(__METHOD__);
    }

    public function actionCreate()
    {
        $this->throwException(__METHOD__);
    }

    public function actionDelete($id)
    {
        $this->throwException(__METHOD__);
    }

    private function throwException($method)
    {
        throw new \Exception('The action '.$method.' is not yet supported.');
    }
}

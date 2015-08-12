<?php

namespace luya\rest;

abstract class BaseActiveController extends \yii\rest\ActiveController implements \luya\rest\BehaviorInterface
{
    use \luya\rest\BehaviorTrait;

    public $createScenario = 'restcreate';

    public $updateScenario = 'restupdate';

    public function checkAccess($action, $model = null, $params = [])
    {
        // override
        //throw new \yii\web\ForbiddenHttpException();
    }
}

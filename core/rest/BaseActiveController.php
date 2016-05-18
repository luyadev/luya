<?php

namespace luya\rest;

/**
 * Base Class for all Rest ActiveControllers
 * 
 * @author Basil Suter <basil@nadar.io>
 */
abstract class BaseActiveController extends \yii\rest\ActiveController implements \luya\rest\BehaviorInterface
{
    use \luya\rest\BehaviorTrait;

    public $createScenario = 'restcreate';

    public $updateScenario = 'restupdate';

    /**
     * If a user should not get access to the rest api, an ForbittendHttpException
     * must be thrown:.
     * 
     * ```php
     * throw new \yii\web\ForbiddenHttpException
     * ```
     * 
     * To make access restrictions checks in your Rest controller you have to override
     * this method, otherwise there is no access check.
     * 
     * @see \yii\rest\ActiveController::checkAccess()
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // override
    }
}

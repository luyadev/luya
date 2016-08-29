<?php

namespace luya\rest;

use luya\traits\RestBehaviorsTrait;
use yii\rest\ActiveController as BaseActiveController;

/**
 * Base Class for all Rest ActiveControllers
 *
 * This base class extends the yii2 ActiveController by implementing the RestBehaviorsTrait which
 * override all behavior classes by luya behavior class names.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class ActiveController extends BaseActiveController
{
    use RestBehaviorsTrait;
    
    /**
     * @var string The constant for the restcreate scenario
     */
    const SCENARIO_RESTCREATE = 'restcreate';

    /**
     * @var string The constant for the rest update scenario
     */
    const SCENARIO_RESTUPDATE = 'restupdate';

    /**
     * @var string The create scenario name from self::SCENARIO_RESTCREATE
     */
    public $createScenario = self::SCENARIO_RESTCREATE;

    /**
     * @var string The update scenario name from self::SCENARIO_RESTUPDATE
     */
    public $updateScenario = self::SCENARIO_RESTUPDATE;

    /**
     * @var boolean|Pagination Whether the pagination is enabled for this ActiveController or not
     * by default pagination for rest controllers is disabled.
     */
    public $pagination = false;
    
    /**
     * Override the base actions in order to support some enhancements of actions
     * by default for all active controllers.
     * @see \yii\rest\ActiveController::actions()
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = '\luya\rest\actions\IndexAction';
        $actions['delete']['class'] = '\luya\rest\actions\DeleteAction';
        return $actions;
    }
    
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
        // override this method to implement access protections.
    }
}

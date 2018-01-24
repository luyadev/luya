<?php

namespace luya\rest;

use luya\traits\RestBehaviorsTrait;
use yii\rest\ActiveController as BaseActiveController;

/**
 * Active Rest Controller.
 *
 * In order to run a ActiveController a `$modelClass` property must be set.
 *
 * The {{luya\rest\ActiveController}} extends the Yii 2 {{\yii\rest\ActiveController}} by disabled the pagination and provided customized rest actions.
 *
 * See the {{luya\traits\RestBehaviorsTrait}} documentation in order to read more about the default enabled behaviors and protection settings.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
     * @var boolean|array|\yii\data\Pagination Whether the pagination is enabled for this ActiveController or not by default pagination for rest controllers is disabled.
     *
     * An example of activatedpagination by setting it to 100 Records per Page:
     *
     * ```php
     * public $pagination = ['pageSize' => 100];
     * ```
     *
     * Or to turn of the pagination which is be default off just set $pagination to false.
     *
     * @see \yii\data\Pagination
     */
    public $pagination = false;
    
    /**
     * If a user should not get access to the rest api, an ForbiddenHttpException must be thrown:
     *
     * ```php
     * throw new \yii\web\ForbiddenHttpException
     * ```
     *
     * To make access restrictions checks in your Rest controller you have to override this method, otherwise there is no access check.
     * @inheritDoc
     * @see \yii\rest\ActiveController::checkAccess()
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // override this method to implement access protections.
    }
}

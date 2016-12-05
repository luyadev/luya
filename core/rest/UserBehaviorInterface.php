<?php

namespace luya\rest;

/**
 * REST User Behavior Interface.
 *
 * The iplementation of the UserBeavhiorInterface should come along with the {{luya\traits\RestBehaviorsTrait}}.
 * 
 * An example integration:
 * 
 * ```php
 * class MyRestController extends \luya\rest\Controller implements \luya\rest\UserBehaviorInterface
 * {
 *     use \luya\traits\RestBehaviorTrait; // Use is already done by the \luya\rest\Controller class.
 *     
 *     public function userAuthClass()
 *     {
 *         return \app\models\User::class;
 *     }
 *     
 *     // Is action is now secured by the `app\models\User` model.
 *     public function actionIndex()
 *     {
 *         return ['foo' => 'bar'];
 *     }
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface UserBehaviorInterface
{
    /**
     * Returns the class object for the authentication of the rest api. If the return value is false the authentication is disabled for the whole rest controller.
     *
     * return a user object (based on {{yii\web\User}}):
     *
     * ```php
     * return Yii::$app->adminuser;
     * ```
     *
     * return a class string will create a new object from this class string:
     *
     * ```php
     * return \luya\admin\components\AdminUser::class;
     * ```
     *
     * return false will disabled the authentication proccess for this rest controller:
     *
     * ```php
     * return false;
     * ```
     *
     * @return boolean|string|\yii\web\User If `false` is returned the protection is disabled, if a string is provided this will be threated as className to create the User object.
     */
    public function userAuthClass();
}

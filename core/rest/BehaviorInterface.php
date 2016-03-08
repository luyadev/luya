<?php

namespace luya\rest;

interface BehaviorInterface
{
    /**
     * Returns the class object for the authentication of the rest api. If the return value is false the
     * authentication is disabled for the whole rest controller.
     *
     * return a user object:
     * 
     * ´´´
     * return Yii::$app->adminuser;
     * ```
     *
     * return a class string will create a new object from this class string:
     * 
     * ```
     * return \admin\components\User::className();
     * ```
     *
     * return false will disabled the authentication proccess for this rest controller
     * 
     * ```
     * return false;
     * ```
     *
     * @return bool|string|object user object, class name, false to disabled the authentication.
     */
    public function userAuthClass();
}

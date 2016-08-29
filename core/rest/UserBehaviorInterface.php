<?php

namespace luya\rest;

/**
 * REST User Behavior Interface.
 *
 * This interfaces defines the implementation class of the user components which is going to be used if the
 * rest class has the `luya\traits\RestBehaviorsTrait` implemented.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface UserBehaviorInterface
{
    /**
     * Returns the class object for the authentication of the rest api. If the return value is false the
     * authentication is disabled for the whole rest controller.
     *
     * return a user object:
     *
     * ```php
     * return Yii::$app->adminuser;
     * ```
     *
     * return a class string will create a new object from this class string:
     *
     * ```php
     * return \admin\components\User::className();
     * ```
     *
     * return false will disabled the authentication proccess for this rest controller
     *
     * ```php
     * return false;
     * ```
     *
     * @return bool|string|object user object, class name, false to disabled the authentication.
     */
    public function userAuthClass();
}

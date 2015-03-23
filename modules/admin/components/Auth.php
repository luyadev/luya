<?php

namespace admin\components;

class Auth extends \yii\base\Component
{
    /**
     * on luya component registration.
     */
    public function init()
    {
    }

    /**
     * see if the user id matches against the moduleName, controllerName, actionName inside of the rights database.
     *
     * @param string $moduleName     Module Name
     * @param string $controllerName The name of the controller without suffix "Controller"
     * @param string $actionName     The name of the action without prefix "action";
     *
     * @return boolean
     */
    public function match($userId, $moduleName, $controllerName, $actionName)
    {
    }

    /**
     * add a new rule if not exists inside the table.
     */
    public function addRule()
    {
    }
}

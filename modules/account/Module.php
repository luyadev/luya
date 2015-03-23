<?php

namespace account;

class Module extends \luya\base\Module
{
    public static $urlRules = [
        ['pattern' => 'account/einloggen', 'route' => 'account/default/index'],
        ['pattern' => 'account/registration', 'route' => 'account/register/index'],
        ['pattern' => 'account/meinprofil', 'route' => 'account/settings/index'],
    ];

    public $userIdentity = '\account\components\User';

    public $controllerUseModuleViewPath = true;

    public function getUserIdentity()
    {
        $class = $this->userIdentity;

        return new $class();
    }
}

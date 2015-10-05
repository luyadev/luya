<?php

namespace account;

use Yii;

class Module extends \luya\base\Module
{
    public $urlRules = [
        ['pattern' => 'account/einloggen', 'route' => 'account/default/index'],
        ['pattern' => 'account/registration', 'route' => 'account/register/index'],
        ['pattern' => 'account/meinprofil', 'route' => 'account/settings/index'],
    ];

    public $userIdentity = '\account\components\User';

    public $controllerUseModuleViewPath = true;

    public function getUserIdentity()
    {
        return Yii::createObject(['class' => $this->userIdentity]);
    }
}

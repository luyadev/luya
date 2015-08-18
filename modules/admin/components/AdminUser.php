<?php

namespace admin\components;

use Yii;
use \admin\models\UserOnline;

/**
 * use getId() to get the current admin user
 * 
 * @author nadar
 */
class AdminUser extends \yii\web\User
{
    public $identityClass = '\admin\models\User';

    public $loginUrl = ['admin/login'];

    public $identityCookie = ['name' => '_adminIdentity', 'httpOnly' => true];

    public $enableAutoLogin = false;
    
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_LOGOUT, [$this, 'onBeforeLogout']);
    }
    
    public function onBeforeLogout()
    {
        UserOnline::removeUser($this->getId());
    }
}

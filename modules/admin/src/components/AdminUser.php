<?php

namespace luya\admin\components;

use Yii;
use luya\admin\models\UserOnline;

/**
 * Admin-User component contains informations about the identitiy of the Admin-User
 *
 * @author nadar
 */
class AdminUser extends \yii\web\User
{
    public $identityClass = '\luya\admin\models\User';

    public $loginUrl = ['/admin/login/index'];

    public $identityCookie = ['name' => '_adminIdentity', 'httpOnly' => true];

    public $enableAutoLogin = false;

    public $idParam = '__luya_adminId';
    
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_LOGOUT, [$this, 'onBeforeLogout']);
    }

    public function onBeforeLogout()
    {
        UserOnline::removeUser($this->getId());
    }
    
    /**
     * Perform a can api match request for the logged in user if user is logged in, returns false otherwhise.
     *
     * @param string $apiEndpoint
     * @param string $typeVerification
     * @return boolean
     */
    public function canApi($apiEndpoint, $typeVerification = false)
    {
        return !$this->isGuest && Yii::$app->auth->matchApi($this->getId(), $apiEndpoint, $typeVerification);
    }

    /**
     * Perform a can route auth request match for the logged in user if user is logged in, returns false otherwhise.
     *
     * @param string $route
     * @return booelan
     */
    public function canRoute($route)
    {
        return !$this->isGuest && Yii::$app->auth->matchRoute($this->getId(), $route);
    }
}

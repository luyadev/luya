<?php

namespace luya\admin\components;

use Yii;
use yii\web\User;
use luya\admin\models\UserOnline;

/**
 * AdminUser Component.
 *
 * The administration user Identity extends from {{yii\web\User}} in order to configure customized behaviors.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class AdminUser extends User
{
    /**
     * @inheritdoc
     */
    public $identityClass = '\luya\admin\models\User';

    /**
     * @inheritdoc
     */
    public $loginUrl = ['/admin/login/index'];

    /**
     * @inheritdoc
     */
    public $identityCookie = ['name' => '_adminIdentity', 'httpOnly' => true];

    /**
     * @inheritdoc
     */
    public $enableAutoLogin = false;

    /**
     * @inheritdoc
     */
    public $idParam = '__luya_adminId';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_LOGOUT, [$this, 'onBeforeLogout']);
        $this->on(self::EVENT_AFTER_LOGIN, [$this, 'onAfterLogin']);
    }
    
    /**
     * After the login process of the user, set the admin interface language based on the user settings.
     */
    public function onAfterLogin()
    {
        Yii::$app->luyaLanguage = $this->identity->setting->get('luyadminlanguage', Yii::$app->luyaLanguage);
        Yii::$app->language = Yii::$app->luyaLanguage;
    }

    /**
     * After loging out, the useronline status must be refreshed and the current user must be deleted from the user online list.
     */
    public function onBeforeLogout()
    {
        UserOnline::removeUser($this->getId());
    }
    
    /**
     * Perform a can api match request for the logged in user if user is logged in, returns false otherwhise.
     *
     * See the {{luya\admin\components\Auth::matchApi}} for details.
     *
     * @param string $apiEndpoint
     * @param string $typeVerification
     * @return boolean Whether the current user can request the provided api endpoint.
     */
    public function canApi($apiEndpoint, $typeVerification = false)
    {
        return !$this->isGuest && Yii::$app->auth->matchApi($this->getId(), $apiEndpoint, $typeVerification);
    }

    /**
     * Perform a can route auth request match for the logged in user if user is logged in, returns false otherwhise.
     *
     * See the {{luya\admin\components\Auth::matchRoute}} for details.
     *
     * @param string $route
     * @return booelan Whether the current user can request the provided route.
     */
    public function canRoute($route)
    {
        return !$this->isGuest && Yii::$app->auth->matchRoute($this->getId(), $route);
    }
}

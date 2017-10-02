<?php

namespace luya\admin\components;

use Yii;
use yii\web\User;
use luya\admin\models\UserOnline;
use yii\web\UserEvent;
use luya\web\Application;

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
     * @var string Variable to assign the default language from the admin module in order to set default language if not set.
     */
    public $defaultLanguage;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        //$this->idParam = '__luyaAdminId_' . md5(Yii::$app->id);
        $this->idParam = $this->uniqueHostVariable('id');
        
        $this->on(self::EVENT_BEFORE_LOGOUT, [$this, 'onBeforeLogout']);
        $this->on(self::EVENT_AFTER_LOGIN, [$this, 'onAfterLogin']);
    }
    
    public function uniqueHostVariable($key)
    {
    	return '__luyaAdmin_' . md5(Yii::$app->id) . '_' . $key;
    }

    /**
     * After the login process of the user, set the admin interface language based on the user settings.
     * @param UserEvent $event
     */
    public function onAfterLogin(UserEvent $event)
    {
        Yii::$app->language = $this->getInterfaceLanguage();
    }
    
    public function getSecureSessionId()
    {
    	if (Yii::$app->request->isAdmin) {
    		return Yii::$app->session->get($this->uniqueHostVariable('secureSessionId'));
    	}
    }
    
    public function destroySecureSessionId()
    {
    	Yii::$app->session->remove($this->uniqueHostVariable('secureSessionId'));
    }
    
    public function setSecureSessionId($id)
    {
    	if (Yii::$app->request->isAdmin) {
    		Yii::$app->session->set($this->uniqueHostVariable('secureSessionId'), $id);
    	}
    }

    /**
     * Return the interface language for the given logged in user.
     *
     * @return string
     */
    public function getInterfaceLanguage()
    {
        return $this->getIsGuest() ? $this->defaultLanguage : $this->identity->setting->get('luyadminlanguage', $this->defaultLanguage);
    }

    /**
     * After loging out, the useronline status must be refreshed and the current user must be deleted from the user online list.
     */
    public function onBeforeLogout()
    {
        UserOnline::removeUser($this->getId());
        
        $this->identity->updateAttributes([
            'auth_token' => Yii::$app->security->hashData(Yii::$app->security->generateRandomString(), $this->identity->password_salt),
        ]);
        
        $this->destroySecureSessionId();
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
     * @return bool Whether the current user can request the provided route.
     */
    public function canRoute($route)
    {
        return !$this->isGuest && Yii::$app->auth->matchRoute($this->getId(), $route);
    }
}

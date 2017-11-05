<?php

namespace luya\admin\apis;

use Yii;
use luya\admin\ngrest\base\Api;
use luya\admin\models\UserChangePassword;
use luya\admin\models\User;

/**
 * User API, provides ability to manager and list all administration users.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class UserController extends Api
{
    /**
     * @var string Path to the user model class.
     */
    public $modelClass = 'luya\admin\models\User';
    
    public function actionChangePassword()
    {
        $model = new UserChangePassword();
        $model->setUser(Yii::$app->adminuser->identity);
        $model->attributes = Yii::$app->request->bodyParams;
        $model->validate();
        
        return $model;
    }
    
    public function actionSession()
    {
        return [
            'user' => Yii::$app->adminuser->identity->toArray(['title', 'firstname', 'lastname', 'email', 'id']),
            'settings' => Yii::$app->adminuser->identity->setting->getArray([
                User::USER_SETTING_ISDEVELOPER,
                User::USER_SETTING_UILANGUAGE,
            ], [
                User::USER_SETTING_UILANGUAGE => $this->module->interfaceLanguage,
            ]),
        ];
    }

    public function actionSessionUpdate()
    {
        $user = Yii::$app->adminuser->identity;
        $user->attributes = Yii::$app->request->bodyParams;
        $user->update(true, ['title', 'firstname', 'lastname', 'email', 'id']);
        
        return $user;
    }
    
    public function actionChangeSettings()
    {
        $params = Yii::$app->request->bodyParams;
        
        foreach ($params as $param => $value) {
            Yii::$app->adminuser->identity->setting->set($param, $value);
        }
        
        return true;
    }
}

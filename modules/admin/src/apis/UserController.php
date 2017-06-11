<?php

namespace luya\admin\apis;

use Yii;
use luya\admin\ngrest\base\Api;
use luya\admin\models\UserChangePassword;

/**
 * User API, provides ability to manager and list all administration users.
 *
 * @author Basil Suter <basil@nadar.io>
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
        return Yii::$app->adminuser->identity->toArray(['title', 'firstname', 'lastname', 'email', 'id']);
    }

    public function actionSessionUpdate()
    {
        $user = Yii::$app->adminuser->identity;
        $user->attributes = Yii::$app->request->bodyParams;
        $user->update(true, ['title', 'firstname', 'lastname', 'email', 'id']);
        
        return $user;
    }
}

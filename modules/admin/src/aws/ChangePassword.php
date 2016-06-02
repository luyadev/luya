<?php

namespace admin\aws;

use Yii;
use admin\Module;
use luya\Exception;

/**
 * Change Passwort Active Window.
 * 
 * The model class defined by `className` must implement the `\admin\aws\ChangePasswordInterface`.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class ChangePassword extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';

    public $icon = 'vpn_key';
    
    /**
     * @var string The name of the class should be used to change password
     * 
     * ```php
     * $className = 'admin\models\User';
     * ```
     */
    public $className = null;
    
    public function index()
    {
        return $this->render('index', [
            'itemId' => $this->getItemId(),
        ]);
    }

    public function callbackSave($newpass, $newpasswd)
    {
        $object = Yii::createObject($this->className);
        
        if (!$object instanceof ChangePasswordInterface) {
            throw new Exception('The password change class must be instance of ChangePasswordInterface');
        }
        
        $model = $object->findOne($this->getItemId());
        
        if ($model) {
            if ($model->changePassword($newpass, $newpasswd)) {
                return $this->sendSuccess(Module::t('aws_changepassword_succes'));
            }
            
            return $this->sendError($model->getFirstErrors());
        }
        
        return $this->sendError('Global Error');
    }
}

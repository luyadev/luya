<?php

namespace luya\admin\models;

use yii\base\Model;
use luya\admin\Module;

/**
 * User change Password model.
 *
 * @property \luya\admin\models\User $user
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class UserChangePassword extends Model
{
    public $oldpass;
    public $newpass;
    public $newpassrepeat;
    
    private $_user;
    
    public function setUser(User $user)
    {
        $this->_user = $user;
    }
    
    public function getUser()
    {
        return $this->_user;
    }
    
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'checkAndStore']);
    }
    
    public function rules()
    {
        return [
            [['oldpass', 'newpass', 'newpassrepeat'], 'required'],
            [['newpass'], 'string', 'min' => '8'],
            [['newpass'], 'compare', 'compareAttribute' => 'newpassrepeat'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'oldpass' => Module::t('model_user_oldpassword'),
            'newpassrepeat' => Module::t('aws_changepassword_new_pass_retry'),
            'newpass' => Module::t('aws_changepassword_new_pass'),
        ];
    }
    
    public function checkAndStore()
    {
        if (!$this->user->validatePassword($this->oldpass)) {
            return $this->addError('oldpass', 'The previous old password is invalid.');
        }
        
        if (!$this->user->changePassword($this->newpass)) {
            return $this->addErrors($this->user->getErrors());
        }
    }
}

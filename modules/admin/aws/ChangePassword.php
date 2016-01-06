<?php

namespace admin\aws;

use admin\Module;

class ChangePassword extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';

    public $icon = 'vpn_key';
    
    public function index()
    {
        return $this->render('index', [
            'itemId' => $this->getItemId(),
        ]);
    }

    public function callbackSave($newpass, $newpasswd)
    {
        $model = new \admin\models\User();
        $user = $model->findOne($this->getItemId());
        $user->scenario = 'changepassword';
        if ($user->changePassword($newpass, $newpasswd)) {
            return $this->response(true, ['message' => Module::t('aws_changepassword_succes')]);
        } else {
            return $this->response(false, $user->getFirstErrors());
        }
    }
}

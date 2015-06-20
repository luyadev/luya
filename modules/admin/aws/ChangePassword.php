<?php

namespace admin\aws;

class ChangePassword extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';
    
    public function index()
    {
        return $this->render('index', [
            'itemId' => $this->getItemId()
        ]);
    }

    public function callbackSave($newpass, $newpasswd)
    {
        $model = new \admin\models\User();
        $user = $model->findOne($this->getItemId());
        $user->scenario = 'changepassword';
        if ($user->changePassword($newpass, $newpasswd)) {
            return $this->response(true, ['message' => 'we have successfully changed your password!']);
        } else {
            return $this->response(false, $user->getFirstErrors());
        }
    }
}

<?php
namespace admin\straps;

use admin\ngrest\StrapAbstract;

class ChangePassword extends StrapAbstract
{
    public function render()
    {
        return $this->getView()->render("@admin/views/strap/changePassword", array(
            "itemId" => $this->getItemId(),
            "strap" => $this,
        ));
    }

    public function callbackChangeAsync($newpass, $newpasswd)
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

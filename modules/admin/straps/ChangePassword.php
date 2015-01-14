<?php
namespace admin\straps;

use luya\ngrest\StrapAbstract;
use luya\ngrest\StrapInterface;

class ChangePassword extends StrapAbstract implements StrapInterface
{
    public function render()
    {
        return $this->view->render("@admin/views/strap/changePassword", array(
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

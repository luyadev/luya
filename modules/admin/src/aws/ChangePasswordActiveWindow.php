<?php

namespace luya\admin\aws;

use luya\Exception;
use luya\admin\Module;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Change Passwort Active Window.
 *
 * This Change Password ActiveWindow allows you to enter a new password and a password repetition which is going to call the {{\luya\admin\aws\ChangePasswordInterface::changePassword()}} in order to change the password of an user or other models.
 *
 * The model where you apply the ChangePassword ActiveWindow must implement the {{\luya\admin\aws\ChangePasswordInterface}}.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ChangePasswordActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = 'admin';
    
    /**
     * @var integer The minimum length of the password.
     */
    public $minCharLength = 8;
    
    /**
     * The default action which is going to be requested when clicking the active window.
     *
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index');
    }

    /**
     * @inheritdoc
     */
    public function defaultIcon()
    {
        return 'vpn_key';
    }
    
    /**
     * The method which is going to change the password on the current model.
     *
     * The implementation of this must make sure if the $newPassword and $newPasswordRepetition are equals!
     *
     * @param string $newpass The new password which must be set.
     * @param string $newpasswd The repeation in order to check whether does inputs are equal or not.
     * @return array
     * @throws \luya\Exception
     */
    public function callbackSave($newpass, $newpasswd)
    {
        if (!$this->model || !$this->model instanceof  ChangePasswordInterface) {
            throw new Exception("Unable to find related model object or the model does not implemented the \luya\admin\aws\ChangePasswordInterface.");
        }
        
        if (strlen($newpass) < $this->minCharLength) {
            return $this->sendError(Module::t('aws_changeapssword_minchar', ['min' => $this->minCharLength]));
        }
        
        if ($newpass !== $newpasswd) {
            return $this->sendError(Module::t('aws_changepassword_notequal'));
        }
        
        if ($this->model->changePassword($newpass)) {
            return $this->sendSuccess(Module::t('aws_changepassword_succes'));
        }
        
        return $this->sendError(current($this->model->getFirstError()));
    }
}

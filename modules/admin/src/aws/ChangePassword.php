<?php

namespace luya\admin\aws;

use Yii;
use luya\Exception;
use luya\admin\Module;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Change Passwort Active Window.
 *
 * The model class defined by `className` must implement the {{\luya\admin\aws\ChangePasswordInterface}}.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ChangePassword extends ActiveWindow
{
    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = 'admin';

    /**
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public $icon = 'vpn_key';
    
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
        return $this->render('index', [
            'itemId' => $this->getItemId(),
        ]);
    }

    /**
     * The method which is going to change the password on the current model.
     * 
     * The implementation of this must make sure if the $newPassword and $newPasswordRepetition are equals!
     * 
     * @param string $newPassword The new password which must be set.
     * @param string $newPasswordRepetition The repeation in order to check whether does inputs are equal or not.
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
        
        if ($this->model->changePassword($newpass, $newpasswd)) {
            return $this->sendSuccess(Module::t('aws_changepassword_succes'));
        }
        
        return $this->sendError(current($this->model->getFirstError()));
    }
}

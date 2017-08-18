<?php

namespace luya\admin\aws;

/**
 * Change Password Active Window Interface.
 *
 * Each {{luya\admin\aws\ChangePasswordActiveWindow}} must implemented this interface
 *
 * ```php
 * class User extends \luya\admin\ngrest\base\NgRestModel implements \luya\admin\aws\ChangePasswordInterface
 * {
 *    public function changePassword($newPassword, $newPasswordRepetition)
 *    {
 *        return $this->updateAttribute('password', Yii::$app->security->generatePasswordHash($newPassword));
 *    }
 * }
 * ```
 *
 * The changePassword method must return whether the password change was successfull or not.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface ChangePasswordInterface
{
    /**
     * The method which is going to change the password on the current model.
     *
     * The implementation of this must make sure if the $newPassword and $newPasswordRepetition are equals!
     *
     * @param string $newPassword The new password which must be set.
     * @param string $newPasswordRepetition The repeation in order to check whether does inputs are equal or not.
     */
    public function changePassword($newPassword, $newPasswordRepetition);
}

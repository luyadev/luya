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
 *        if ($newPassword !== $newPasswordRepetition) {
 *            $this->addError('password', 'The new password as not equals the old.');
 *        }
 *
 *        $this->updateAttribute('password', sha1($newPassword));
 *    }
 * }
 * ```
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

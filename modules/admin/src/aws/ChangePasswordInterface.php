<?php

namespace admin\aws;

/**
 * Change Password Active Window Interface
 * 
 * @author Basil Suter <basil@nadar.io>
 */
interface ChangePasswordInterface
{
    public function changePassword($newPassword, $newPasswordRepetition);
}

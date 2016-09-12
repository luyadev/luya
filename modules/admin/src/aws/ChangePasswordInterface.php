<?php

namespace luya\admin\aws;

/**
 * Change Password Active Window Interface
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface ChangePasswordInterface
{
    public static function findOne($condition);
    
    public function changePassword($newPassword, $newPasswordRepetition);
}

<?php

namespace admin\aws;

interface ChangePasswordInterface
{
    public function changePassword($newPassword, $newPasswordRepetition);
}

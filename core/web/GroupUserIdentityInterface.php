<?php

namespace luya\web;

use yii\web\IdentityInterface;

interface GroupUserIdentityInterface extends IdentityInterface
{
    /**
     * Returns an array with croup alias allowed for the current user. Example implementation
     * could look like this.
     * 
     * ```php
     * public function authGroups()
     * {
     *     return [
     *         'group-a', 'group-c',
     *     ];
     * }
     * ```
     * 
     * @return array An array contains the allowed groups for this user.
     */
    public function authGroups();
}

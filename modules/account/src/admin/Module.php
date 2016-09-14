<?php

namespace luya\account\admin;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-account-user' => 'luya\account\admin\apis\UserController',
    ];
    
    public function getMenu()
    {
        return $this->node('Accounts', 'supervisor_account')
        ->group('Übersicht')
        ->itemApi('Benutzer', 'accountadmin-user-index', 'account_circle', 'api-account-user')
        ->menu();
    }
}

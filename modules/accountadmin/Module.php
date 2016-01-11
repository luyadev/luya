<?php

namespace accountadmin;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-account-user' => 'accountadmin\apis\UserController',
    ];
    
    public function getMenu()
    {
        return $this->node('Accounts', 'supervisor_account')
        ->group('Übersicht')
        ->itemApi('Benutzer', 'accountadmin-user-index', 'account_circle', 'api-account-user')
        ->menu();
    }
}

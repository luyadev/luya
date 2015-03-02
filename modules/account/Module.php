<?php 

namespace account;

class Module extends \luya\base\Module
{
    public static $urlRules = [];
    
    public $userIdentity = '\account\components\User';
    
    public function getUserIdentitiy()
    {
        return $this->userIdentity;
    }
}
<?php

namespace luyatests\core\web;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\web\GroupUser;
use luya\web\GroupUserIdentityInterface;
use yii\base\Model;
use luyatests\data\models\UserIdentity;

class GroupAUserIdentity extends Model implements GroupUserIdentityInterface
{
    public $id = 1;
    
    public function authGroups()
    {
        return [
            'group-a',
        ];
    }
    
    public static function findIdentity($id)
    {
        return (new self);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }
    
    public function getId()
    {
        return 1;
    }
    
    public function getAuthKey()
    {
        return false;
    }
    
    public function validateAuthKey($authKey)
    {
        return false;
    }
}

class GroupUserTest extends LuyaWebTestCase
{
    public function testInGroupButIsGuest()
    {
        $user = new GroupUser(['identityClass' => 'GroupAUserIdentity']);
        $this->assertTrue($user->isGuest);
        $this->assertFalse($user->inGroup('group-a'));
    }
    
    public function testIsGuestInGroup()
    {
        $user = new GroupUser(['identityClass' => 'GroupAUserIdentity']);
        $user->login(GroupAUserIdentity::findIdentity(1));
        $this->assertFalse($user->isGuest);
        $this->assertFalse($user->inGroup('group-b'));
        $this->assertFalse($user->inGroup(['group-b', 'group-c']));
        $this->assertTrue($user->inGroup('group-a'));
        $this->assertTrue($user->inGroup(['group-a', 'group-c']));
        $this->assertTrue($user->inGroup(['group-c', 'group-b', 'group-a']));
    }
    
    public function testIsGuestInGroupButNoInterface()
    {
        $user = new GroupUser(['identityClass' => 'luyatests\data\models\UserIdentity']);
        $user->login(UserIdentity::findIdentity(1));
        $this->assertFalse($user->isGuest);
        $this->expectException('yii\base\InvalidConfigException');
        $user->inGroup('group-a');
    }
}

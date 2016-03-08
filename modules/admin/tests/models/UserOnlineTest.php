<?php

namespace tests\web\admin\models;

use admin\models\UserOnline;

class UserOnlineTest extends \tests\web\Base
{
    public function testAddUser()
    {
        UserOnline::clearList(0);
        $this->assertEquals(0, UserOnline::getCount());
        UserOnline::refreshUser(1, 'my/test'); // create
        UserOnline::refreshUser(1, 'my/test'); // refresh
        $this->assertEquals(1, UserOnline::getCount());
        $list = UserOnline::getList();
        $this->assertArrayHasKey(0, $list);
        UserOnline::clearList(0);
        $this->assertEquals(true, is_array(UserOnline::getList()));
        $this->assertEquals(0, count(UserOnline::getList()));

        UserOnline::refreshUser(1, 'my/test'); // create
        UserOnline::removeUser(1);
    }
}

<?php

namespace admintests\models;

use admintests\AdminTestCase;
use admintests\data\fixtures\UserFixture;

class UserTest extends AdminTestCase
{
    public function testUser()
    {
        $model = new UserFixture();
        $model->load();
        
        $this->assertInstanceOf('luya\admin\models\User', $model->getModel('user1'));
    }
}

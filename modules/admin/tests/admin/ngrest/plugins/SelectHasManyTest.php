<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;
use luya\admin\ngrest\plugins\Link;
use yii\base\Model;
use yii\base\Event;
use admintests\data\fixtures\UserFixture;
use luya\admin\ngrest\plugins\SelectHasMany;

class SelectHasManyTest extends AdminTestCase
{
    public function testExternalLink()
    {
        $model = new UserFixture();
        $model->load();
        
        $user = $model->getModel('user1');
        
        $event = new Event();
        $event->sender = $user;

        $plugin = new SelectHasMany([
            'alias' => 'alias',
            'name' => 'firstname',
            'i18n' => false,
        ]);

        $this->assertArrayNotHasKey('afterFind', $plugin->events());
    }
}

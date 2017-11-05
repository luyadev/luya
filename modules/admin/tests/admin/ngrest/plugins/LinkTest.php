<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;
use luya\admin\ngrest\plugins\Link;

use yii\base\Event;
use admintests\data\fixtures\UserFixture;

class LinkTest extends AdminTestCase
{
    public function testExternalLink()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->firstname = '{"type": 2, "value": "link"}';
        $event->sender = $user;

        $plugin = new Link([
            'alias' => 'alias',
            'name' => 'firstname',
            'i18n' => false,
        ]);

        $plugin->onFind($event);

        $this->assertInstanceOf('luya\web\WebsiteLink', $user->firstname);
    }
    
    public function testExternalLinkI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->firstname = '{"en": {"type": 2, "value": "link"}}';
        $event->sender = $user;
    
        $plugin = new Link([
            'alias' => 'alias',
            'name' => 'firstname',
            'i18n' => true,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertInstanceOf('luya\web\WebsiteLink', $user->firstname);
    }
}

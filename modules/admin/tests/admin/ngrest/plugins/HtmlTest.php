<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;
use yii\base\Event;
use admintests\data\fixtures\UserFixture;
use luya\admin\ngrest\plugins\Html;

class HtmlTest extends AdminTestCase
{
    public function testHtmlNewLine()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        
        $user->firstname = 'Hello
World';
        
        $event->sender = $user;
        
        $plugin = new Html([
            'alias' => 'firstname',
            'name' => 'firstname',
            'i18n' => false,
        ]);
        
        $plugin->onFind($event);
        
        $this->assertSame('Hello<br />
World', $user->firstname);
    }
}

<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;
use yii\base\Event;
use admintests\data\fixtures\UserFixture;
use luya\admin\ngrest\plugins\CheckboxList;

class CheckboxListTest extends AdminTestCase
{
    public function testSaveEvent()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        
        $user->id = ['value' => 1];

        $event->sender = $user;

        $plugin = new CheckboxList([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'data' => [1 => 'Mr', 2 => 'Mrs'],
        ]);

        $plugin->onSave($event);

        $this->assertSame('[{"value":1}]', $user->id);
    }
    
    public function testSaveEventI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
    
        $user->id = ['de' => [['value' => 1]]];
    
        $event->sender = $user;
    
        $plugin = new CheckboxList([
                'alias' => 'alias',
                'name' => 'id',
                'i18n' => true,
                'data' => [1 => 'Mr', 2 => 'Mrs'],
        ]);
    
        $plugin->onSave($event);
    
        $this->assertSame('{"de":[{"value":1}]}', $user->id);
    }
    
    public function testSaveEventArrayFrontendInput()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
    
        $user->id = [1,2];
    
        $event->sender = $user;
    
        $plugin = new CheckboxList([
                'alias' => 'alias',
                'name' => 'id',
                'i18n' => false,
                'data' => [1 => 'Mr', 2 => 'Mrs'],
        ]);
    
        $plugin->onSave($event);
    
        $this->assertSame('[{"value":1},{"value":2}]', $user->id);
    }
}

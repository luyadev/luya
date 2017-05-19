<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;

use yii\base\Event;
use admintests\data\fixtures\UserFixture;
use luya\admin\ngrest\plugins\Image;

class ImageTest extends AdminTestCase
{
    public function testFileObject()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        
        $event->sender = $user;
        
        $plugin = new Image([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'imageItem' => true,
        ]);
        
        $plugin->onFind($event);
        
        $this->assertNotEquals('1', $user->id);
    }
    
    public function testNotFileObject()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
    
        $event->sender = $user;
    
        $plugin = new Image([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'imageItem' => false,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertEquals('1', $user->id);
    }
    
    public function testFileObjectI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '{"en": 1, "de": 2}';
        $event->sender = $user;
    
        $plugin = new Image([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => true,
            'imageItem' => true,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertNotEquals('1', $user->id);
    }
    
    public function testNoFileObjectI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '{"en": 1, "de": 2}';
        $event->sender = $user;
    
        $plugin = new Image([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => true,
            'imageItem' => false,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertEquals("1", $user->id);
    }
}

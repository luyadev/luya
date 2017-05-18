<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;

use yii\base\Event;
use admintests\data\fixtures\UserFixture;
use luya\admin\ngrest\plugins\ImageArray;

class ImageArrayTest extends AdminTestCase
{
    public function testimageIteratorObject()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '{"en":[{"imageId":"70","caption":"A"},{"imageId":"69","caption":"B"}],"de":[],"fr":[]}';
        $event->sender = $user;
        $plugin = new ImageArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => true,
            'imageIterator' => true,
        ]);
        
        $plugin->onFind($event);
        
        $this->assertInstanceOf('\luya\admin\image\Iterator', $user->id);
    }
    
    
    public function testNotimageIteratorObject()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '{"en":[{"imageId":"70","caption":"A"},{"imageId":"69","caption":"B"}],"de":[],"fr":[]}';
        $event->sender = $user;
        $plugin = new ImageArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => true,
            'imageIterator' => false,
        ]);
        
        $plugin->onFind($event);
        
        $this->assertTrue(is_array($user->id));
    }
    
    
    public function testimageIteratorObjectNotI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '[{"imageId":"70","caption":"A"},{"imageId":"69","caption":"B"}]';
        $event->sender = $user;
        $plugin = new ImageArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'imageIterator' => true,
        ]);
    
        $plugin->onFind($event);
        
        $this->assertInstanceOf('\luya\admin\image\Iterator', $user->id);
    }
    
    public function testimageIteratorObjectNotI18nEmptyValue()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '[]';
        $event->sender = $user;
        $plugin = new ImageArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'imageIterator' => true,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertSame([], $user->id);
    }
    
    public function testNotimageIteratorObjectNotI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '[{"imageId":"70","caption":"A"},{"imageId":"69","caption":"B"}]';
        $event->sender = $user;
        $plugin = new ImageArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'imageIterator' => false,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertTrue(is_array($user->id));
    }
}

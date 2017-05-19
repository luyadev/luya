<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;

use yii\base\Event;
use admintests\data\fixtures\UserFixture;
use luya\admin\ngrest\plugins\FileArray;

class FileArrayTest extends AdminTestCase
{
    public function testFileIteratorObject()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '{"en":[{"fileId":"70","caption":"A"},{"fileId":"69","caption":"B"}],"de":[],"fr":[]}';
        $event->sender = $user;
        $plugin = new FileArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => true,
            'fileIterator' => true,
        ]);
        
        $plugin->onFind($event);
        
        $this->assertInstanceOf('\luya\admin\file\Iterator', $user->id);
    }
    
    
    public function testNotFileIteratorObject()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '{"en":[{"fileId":"70","caption":"A"},{"fileId":"69","caption":"B"}],"de":[],"fr":[]}';
        $event->sender = $user;
        $plugin = new FileArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => true,
            'fileIterator' => false,
        ]);
        
        $plugin->onFind($event);
        
        $this->assertTrue(is_array($user->id));
    }
    
    
    public function testFileIteratorObjectNotI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '[{"fileId":"70","caption":"A"},{"fileId":"69","caption":"B"}]';
        $event->sender = $user;
        $plugin = new FileArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'fileIterator' => true,
        ]);
    
        $plugin->onFind($event);
        
        $this->assertInstanceOf('\luya\admin\file\Iterator', $user->id);
    }
    
    public function testFileIteratorObjectNotI18nEmptyValue()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '[]';
        $event->sender = $user;
        $plugin = new FileArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'fileIterator' => true,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertSame([], $user->id);
    }
    
    public function testNotFileIteratorObjectNotI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        $user->id = '[{"fileId":"70","caption":"A"},{"fileId":"69","caption":"B"}]';
        $event->sender = $user;
        $plugin = new FileArray([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'fileIterator' => false,
        ]);
    
        $plugin->onFind($event);
    
        $this->assertTrue(is_array($user->id));
    }
}

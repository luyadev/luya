<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;
use admintests\data\fixtures\UserFixture;
use luya\admin\models\User;
use luya\admin\ngrest\plugins\SelectModel;
use yii\base\Event;

class SelectModelTest extends AdminTestCase
{
    public function testBasicConfigGetData()
    {
        $model = new UserFixture();
        $model->load();
        $plugin = new SelectModel([
            'name' => 'test',
            'alias' => 'test',
            'i18n' => false,
            'modelClass' => User::class,
            'valueField' => 'id',
            'labelField' => 'email',
        ]);
        
        $this->assertSame([
            0 => ['value' => 2, 'label' => 'jane@luya.io'],
            1 => ['value' => 1, 'label' => 'john@luya.io'],
        ], $plugin->getData());
        
        unset($plugin);
    }
    
    public function testArrayLabelConfigGetData()
    {
        $model = new UserFixture();
        $model->load();
        $plugin = new SelectModel([
            'name' => 'test',
            'alias' => 'test',
            'i18n' => false,
            'modelClass' => User::class,
            'valueField' => 'id',
            'labelField' => ['lastname', 'firstname'],
        ]);
    
        $this->assertSame([
            0 => ['value' => 2, 'label' => 'Doe Jane'],
            1 => ['value' => 1, 'label' => 'Doe John'],
        ], $plugin->getData());
        
        unset($plugin);
    }
    
    public function testArrayLabelWithTemplateConfigGetData()
    {
        $model = new UserFixture();
        $model->load();
        $plugin = new SelectModel([
            'name' => 'test',
            'alias' => 'test',
            'i18n' => false,
            'modelClass' => User::class,
            'valueField' => 'id',
            'labelField' => ['lastname', 'firstname'],
            'labelTemplate' => '%s:%s',
        ]);
    
        $this->assertSame([
            0 => ['value' => 2, 'label' => 'Doe:Jane'],
            1 => ['value' => 1, 'label' => 'Doe:John'],
        ], $plugin->getData());
        
        unset($plugin);
    }
    
    public function testWhereConfigGetData()
    {
        $model = new UserFixture();
        $model->load();
        $plugin = new SelectModel([
            'name' => 'test',
            'alias' => 'test',
            'i18n' => false,
            'modelClass' => User::class,
            'valueField' => 'id',
            'labelField' => 'email',
            'where' => ['email' => 'jane@luya.io'],
        ]);
    
        $this->assertSame([
            0 => ['value' => 2, 'label' => 'jane@luya.io'],
        ], $plugin->getData());
        
        unset($plugin);
    }
    
    /**
     * @see https://github.com/luyadev/luya/issues/1133
     */
    public function testGetterMethodAttributeForLabelField()
    {
        $model = new UserFixture();
        $model->load();
        $plugin = new SelectModel([
            'name' => 'test',
            'alias' => 'test',
            'i18n' => false,
            'modelClass' => User::class,
            'valueField' => 'id',
            'labelField' => 'titleNamed',
        ]);
    
        
        $this->assertSame([
            0 => ['value' => 1, 'label' => 'Mr.'],
            1 => ['value' => 2, 'label' => 'Ms.'],
        ], $plugin->getData());
        
        unset($plugin);
    }
    
    /**
     * @see https://github.com/luyadev/luya/issues/1133
     */
    public function testCallableLabelField()
    {
        $model = new UserFixture();
        $model->load();
        $plugin = new SelectModel([
            'name' => 'test',
            'alias' => 'test',
            'i18n' => false,
            'modelClass' => User::class,
            'valueField' => 'id',
            'labelField' => function ($model) {
                return $model->firstname . '@' . $model->lastname;
            }
        ]);
    
    
        $this->assertSame([
            0 => ['value' => 2, 'label' => 'Jane@Doe'],
            1 => ['value' => 1, 'label' => 'John@Doe'],
        ], $plugin->getData());
    
        unset($plugin);
    }
    
    /**
     * Test relating with i18n casted select fields:
     *
     * @see https://github.com/luyadev/luya/issues/1125#issuecomment-269737028
     */
    public function testAfterFindEventWithI18n()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        
        $user = $model->getModel('user1');
        $event->sender = $user;
        
        $plugin = new SelectModel([
            'name' => 'id',
            'alias' => 'test',
            'i18n' => true,
            'modelClass' => User::class,
            'valueField' => 'id',
            'labelField' => 'email',
        ]);
    
        $plugin->onFind($event);
        
        $this->assertSame("", $user->id);
    
        unset($plugin);
    }
    
    public function testFindSelfPrimaryKey()
    {
        $model = new UserFixture();
        $model->load();
        $plugin = new SelectModel([
            'name' => 'test',
            'alias' => 'test',
            'i18n' => false,
            'modelClass' => User::class,
            'labelField' => function ($model) {
                return $model->firstname . '@' . $model->lastname;
            }
        ]);
        
        $this->assertSame('id', $plugin->valueField);
    }
}

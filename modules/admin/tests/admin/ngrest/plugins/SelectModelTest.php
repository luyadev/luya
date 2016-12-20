<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;
use admintests\data\fixtures\UserFixture;
use luya\admin\models\User;
use luya\admin\ngrest\plugins\SelectModel;

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
}
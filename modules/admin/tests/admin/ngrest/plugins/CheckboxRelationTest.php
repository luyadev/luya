<?php

namespace admintests\admin\ngrest\plugins;

use admintests\AdminTestCase;
use yii\base\Event;
use admintests\data\fixtures\UserFixture;
use luya\admin\ngrest\plugins\CheckboxRelation;
use luya\admin\models\User;

class CheckboxRelationTest extends AdminTestCase
{
    public function testGetServiceDataConfiguration()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
        
        $user->id = ['value' => 1];

        $event->sender = $user;

        $plugin = new CheckboxRelation([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'model' => User::className(),
            'refJoinTable' => 'admin_user_group',
            'refModelPkId' => 'group_id',
            'refJoinPkId' => 'user_id',
            'labelField' => ['firstname', 'lastname', 'email'],
            'labelTemplate' =>  '%s %s (%s)'
        ]);

        $this->assertSame([
            0 => ['value' => 1, 'label' => 'John Doe (john@luya.io)'],
            1 => ['value' => 2, 'label' => 'Jane Doe (jane@luya.io)']
        ], $plugin->serviceData($event)['relationdata']['items']);
    }
    
    public function testGetServiceDataNoTemplateConfiguration()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
    
        $user->id = ['value' => 1];
    
        $event->sender = $user;
    
        $plugin = new CheckboxRelation([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'model' => User::className(),
            'refJoinTable' => 'admin_user_group',
            'refModelPkId' => 'group_id',
            'refJoinPkId' => 'user_id',
            'labelField' => ['firstname', 'lastname'],
        ]);
    
        $this->assertSame([
            0 => ['value' => 1, 'label' => 'John, Doe'],
            1 => ['value' => 2, 'label' => 'Jane, Doe']
        ], $plugin->serviceData($event)['relationdata']['items']);
    }
    
    public function testGetServiceDataCallablaeConfiguration()
    {
        $event = new Event();
        $model = new UserFixture();
        $model->load();
        $user = $model->getModel('user1');
    
        $user->id = ['value' => 1];
    
        $event->sender = $user;
    
        $plugin = new CheckboxRelation([
            'alias' => 'alias',
            'name' => 'id',
            'i18n' => false,
            'model' => User::className(),
            'refJoinTable' => 'admin_user_group',
            'refModelPkId' => 'group_id',
            'refJoinPkId' => 'user_id',
            'labelField' => function ($model) {
                return $model['firstname'] . "|". $model['lastname'];
            }
        ]);
    
        $this->assertSame([
            0 => ['value' => 1, 'label' => 'John|Doe'],
            1 => ['value' => 2, 'label' => 'Jane|Doe']
        ], $plugin->serviceData($event)['relationdata']['items']);
    }
}

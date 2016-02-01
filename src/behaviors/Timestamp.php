<?php

namespace luya\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Very basic behavior implementation of unix time() set for defined insert and/or update fields.
 * 
 * @author nadar
 * @since 1.0.0-beta5
 */
class Timestamp extends Behavior
{
    public $insert = [];
    
    public $update = [];
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }
    
    public function beforeInsert($event)
    {
        foreach ($this->insert as $field) {
            $event->sender->$field = time();
        }
    }
    
    public function beforeUpdate($event)
    {
        foreach ($this->update as $field) {
            $event->sender->$field = time();
        }
    }
}

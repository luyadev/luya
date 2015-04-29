<?php

namespace admin\ngrest\base;

use \yii\db\ActiveRecord;

class EventBehavior extends \yii\base\Behavior
{
    public $ngRestConfig = null;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'eventBeforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'eventBeforeUpdate',
            ActiveRecord::EVENT_AFTER_FIND => 'eventAfterFind',
        ];
    }
    
    public function eventBeforeInsert($event)
    {
        $events = $this->ngRestConfig->getEvents('create'); // ngCrud is create not insert
        
        foreach ($events as $field => $plugins) {
            foreach ($plugins as $plugin) {
                $class = $plugin['class'];
                $response = $class::onBeforeCreate($event->sender->$field);
                if ($response !== false) {
                    $event->sender->$field = $response;
                }
            }
        }
    }
    
    public function eventBeforeUpdate($event)
    {
        $events = $this->ngRestConfig->getEvents('update');
    
        foreach ($events as $field => $plugins) {
            foreach ($plugins as $plugin) {
                $class = $plugin['class'];
                $response = $class::onBeforeUpdate($event->sender->$field, $event->sender->getOldAttribute($field));
                if ($response !== false) {
                    $event->sender->$field = $response;
                }
            }
        }
    }
    
    public function eventAfterFind($event)
    {
        $events = $this->ngRestConfig->getEvents('list'); // ngCrud ist list not find
    
        foreach ($events as $field => $plugins) {
            foreach ($plugins as $plugin) {
                $class = $plugin['class'];
                $response = $class::onAfterList($event->sender->$field);
                if ($response !== false) {
                    $event->sender->$field = $response;
                }
            }
        }
    }
}
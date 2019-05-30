<?php

namespace luya\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Timestamp Behavior.
 *
 * Set the unix timestamp for given update and/or insert fields.
 *
 * ```php
 * 'timestamp' => [
 *     'class' => \luya\behaviors\TimestampBehavior::class,
 *     'insert' => ['last_update'],
 *     'update' => ['last_update'],
 * ]
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.9
 */
class TimestampBehavior extends Behavior
{
    /**
     * @var array An array with all fields where the timestamp should be applied to on insert.
     */
    public $insert = [];
    
    /**
     * @var array An array with all fields where the timestamp should be applied to on update.
     */
    public $update = [];
    
    /**
     * Register event handlers before insert and update.
     *
     * @see \yii\base\Behavior::events()
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }
    
    /**
     * Insert the timestamp for all provided fields.
     *
     * @param \yii\base\Event $event Event object from Active Record.
     */
    public function beforeInsert($event)
    {
        foreach ($this->insert as $field) {
            $event->sender->$field = time();
        }
    }
    
    /**
     * Update the timestamp for all provided fields.
     *
     * @param \yii\base\Event $event Event object from Active Record.
     */
    public function beforeUpdate($event)
    {
        foreach ($this->update as $field) {
            $event->sender->$field = time();
        }
    }
}

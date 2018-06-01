<?php

namespace luya\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use luya\helpers\Json;

/**
 * Json Behavior.
 *
 * Provides auto encoding for array values after validation in order to store in the database.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.9
 */
class JsonBehavior extends Behavior
{
    public $attributes = [];
    
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'autoEncodeAttributes',
        ];
    }
    
    /**
     * Encode attributes.
     */
    public function autoEncodeAttributes()
    {
        foreach ($this->attributes as $name) {
            if (!isset($this->owner->getDirtyAttributes()[$name])) {
                continue;
            }
            
            $value = $this->owner->{$name};
            
            if (is_array($value)) {
                $this->owner->{$name} = $this->jsonEncode($name);
            }
        }
    }
    
    /**
     * Encodes the given value into a JSON string.
     *
     * @param mixed $value This is commonly an array.
     * @return string
     */
    public function jsonEncode($value)
    {
        return Json::encode($value);
    }
    
    /**
     * Decodes the given JSON string into a PHP data structure.
     *
     * @param string $value
     * @return array
     */
    public function jsonDecode($value)
    {
        return Json::decode($value);
    }
}

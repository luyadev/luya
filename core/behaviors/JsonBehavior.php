<?php

namespace luya\behaviors;

use luya\helpers\Json;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * Json Behavior.
 *
 * Provides auto encoding for array values after validation in order to store in the database.
 * 
 * In order to work only with arrayable json values use:
 * 
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'json' => [
 *             'class' => JsonBehavior:class,
 *             'attributes' => ['json_field'],
 *             'encodeBeforeValidate' => true,
 *             'decodeAfterFind' => true,
 *         ]
 *     ];
 * }
 * 
 * public function rules()
 * {
 *     return [
 *         [['json_field', 'each', 'rule' => ['safe']]]
 *     ]
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.9
 */
class JsonBehavior extends Behavior
{
    public $attributes = [];

    /**
     * @var boolean If enabled, the data will be encoded before validating, this means the validation rule should be `array` otherwise the validation must be `string`.
     * This might also differ based on how the data is passed to the model. Data passed to the model will be encoded from string to array (if not already).
     * @since 1.2.0 
     */
    public $encodeBeforeValidate = true;

    /**
     * @var boolean If enabled the data will be encoded from json to array after populating the active record data.
     * @since 1.2.0
     */
    public $decodeAfterFind = false;
    
    /**
     * @inheritdoc
     */
    public function events()
    {
        $events = [];
        if ($this->encodeBeforeValidate) {
            $events[ActiveRecord::EVENT_BEFORE_VALIDATE] = 'encodeAttributes';
        } else {
            $events[ActiveRecord::EVENT_AFTER_VALIDATE] = 'encodeAttributes';
        }

        if ($this->decodeAfterFind) {
            $events[ActiveRecord::EVENT_AFTER_FIND] = 'decodeAttributes';
        }

        return $events;
    }
    
    /**
     * Encode all attributes from json to php.
     */
    public function encodeAttributes()
    {
        foreach ($this->attributes as $name) {

            $value = $this->owner->{$name};
            
            if (is_array($value)) {
                $this->owner->{$name} = $this->jsonEncode($value);
            }
        }
    }
    
    /**
     * Decode all attributes from php to json.
     */
    public function decodeAttributes()
    {
        foreach ($this->attributes as $name) {
            $value = $this->owner->{$name};
            
            $this->owner->{$name} = $this->jsonDecode($value);
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
        // if value is already a json, skip encoding and return result
        // ensure data is not doulble encoded or throws exception
        if (Json::isJson($value)) {
            return $value;
        }

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
        // data is already passed by array
        if (is_array($value)) {
            return $value;
        }

        return Json::decode($value);
    }
}

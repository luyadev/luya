<?php

namespace admin\traits;

/**
 * Trait to enable Soft Deletion for NgRest and ActiveRecord models.
 * 
 * To override a match your custom field desribers (describers which is deleted and find state) you
 * can override the static `FieldStateDescriber()` method as described in the description of the method.
 * 
 * @author nadar
 */
trait SoftDeleteTrait
{
    /**
     * 
     * @return array Returns an array with a key which desribes what field should be updated on delete and observed on find,
     * the value for the corresponding field can be an array or a string/numeric
     * 
     * - array: The first value is the value for the delete command, the second for the find where
     * - string/nummeric: The value will be inverted with "!" opposite operator, this can lead into problems
     * 
     * Examples:
     * 
     * ```
     * [
     *     'is_deleted' => [1, 0], // on delete sets `is_deleted = 1`; on find add where `where(['is_deleted' => 0]);`.
     *     'is_inactive' => true, // on delete sets `is_inactive = true`; on find add where `where([is_inactive' => !true]);`.
     * ]
     * ```
     * 
     * if you want to override the default implemenation to match your custom models you should always use the former type of state description.
     */
    public static function FieldStateDescriber()
    {
        return [
            'is_deleted' => [1, 0]
        ];
    }

    private static function internalAndWhere()
    {
        $query = [];
        
        foreach (static::FieldStateDescriber() as $field => $value) {
            $query[$field] = (is_array($value)) ? $value[1] : !$value;
        }
        
        return $query;
    }

    private static function internalUpdateValues()
    {
        $update = [];
        foreach (static::FieldStateDescriber() as $field => $value) {
            $update[$field] = (is_array($value)) ? $value[0] : $value;
        }
        return $update;
    }
    
    public static function ngRestFind()
    {
        return parent::ngRestFind()->andWhere(static::internalAndWhere());
    }
    
    public static function find()
    {
        return parent::find()->andWhere(static::internalAndWhere());
    }

    public function delete()
    {
        $this->updateAttributes(static::internalUpdateValues());
        return true;
    }
}

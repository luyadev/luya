<?php

namespace luya\admin\traits;

/**
 * Trait to enable Soft Deletion for NgRest and ActiveRecord models.
 *
 * To override a match your custom field desribers (describers which is deleted and find state) you
 * can override the static `FieldStateDescriber()` method as described in the description of the method.
 *
 * @author Basil Suter <basil@nadar.io>
 */
trait SoftDeleteTrait
{
    /**
     * Describes the fields shoudl be used to the perform the soft deleteion tasks.
     *
     * Examples value of the method:
     *
     * ```php
     * return [
     *     'is_deleted' => [1, 0], // on delete sets `is_deleted = 1`; on find add where `where(['is_deleted' => 0]);`.
     *     'is_inactive' => true, // on delete sets `is_inactive = true`; on find add where `where([is_inactive' => !true]);`.
     * ];
     * ```
     *
     * @todo rename to fieldStateDescriber!
     * @return array Returns an array with a key which desribes what field should be updated on delete and observed on find,
     * the value for the corresponding field can be an array or a string/numeric
     *
     * - array: The first value is the value for the delete command, the second for the find where
     * - string/nummeric: The value will be inverted with "!" opposite operator, this can lead into problems
     *
     * if you want to override the default implemenation to match your custom models you should always use the former type of state description.
     */
    public static function FieldStateDescriber()
    {
        return [
            'is_deleted' => [1, 0]
        ];
    }

    /**
     * This method will be used to performe the where querys of `ngrestFind()` and `find()` of the ActiveRecord.
     *
     * @return array Returns an array where the key is the field and value the correspoinding value for there where statments.
     */
    public static function internalAndWhere()
    {
        $query = [];
        
        foreach (static::FieldStateDescriber() as $field => $value) {
            $query[$field] = (is_array($value)) ? $value[1] : !$value;
        }
        
        return $query;
    }

    /**
     * Overrides the ngRestFind() method of the ActiveRecord
     */
    public static function ngRestFind()
    {
        $where = static::internalAndWhere();
        return (empty($where)) ? parent::ngrestFind() : parent::ngRestFind()->andWhere($where);
    }
    
    /**
     * Overrides the find() method of the ActiveRecord
     */
    public static function find()
    {
        $where = static::internalAndWhere();
        return (empty($where)) ? parent::find() : parent::find()->andWhere($where);
    }

    public function delete()
    {
        $this->updateAttributes(static::internalUpdateValues());
        return true;
    }
    
    private static function internalUpdateValues()
    {
        $update = [];
        foreach (static::FieldStateDescriber() as $field => $value) {
            $update[$field] = (is_array($value)) ? $value[0] : $value;
        }
        return $update;
    }
}

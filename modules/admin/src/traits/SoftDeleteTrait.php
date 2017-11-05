<?php

namespace luya\admin\traits;

/**
 * Trait to enable Soft Deletion for NgRest and ActiveRecord models.
 *
 * To override a match your custom field desribers (describers which is deleted and find state) you
 * can override the static `fieldStateDescriber()` method as described in the description of the method.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
     *     'is_deleted' => [true, false], // on delete sets `is_deleted = true`; on find add where `where(['is_deleted' => false]);`.
     *     'is_inactive' => true, // on delete sets `is_inactive = true`; on find add where `where([is_inactive' => !true]);`.
     * ];
     * ```
     *
     * @return array Returns an array with a key which desribes what field should be updated on delete and observed on find,
     * the value for the corresponding field can be an array or a string/numeric
     *
     * - array: The first value is the value for the delete command, the second for the find where
     * - string/nummeric: The value will be inverted with "!" opposite operator, this can lead into problems
     *
     * if you want to override the default implemenation to match your custom models you should always use the former type of state description.
     */
    public static function fieldStateDescriber()
    {
        return [
            'is_deleted' => [true, false]
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
        
        foreach (static::fieldStateDescriber() as $field => $value) {
            $query[$field] = (is_array($value)) ? $value[1] : !$value;
        }
        
        return $query;
    }

    /**
     * Overrides the ngRestFind() method of the ActiveRecord
     * @return \yii\db\ActiveQuery
     */
    public static function ngRestFind()
    {
        $where = static::internalAndWhere();
        return empty($where) ? parent::ngRestFind() : parent::ngRestFind()->andWhere($where);
    }
    
    /**
     * Overrides the find() method of the ActiveRecord
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        $where = static::internalAndWhere();
        return (empty($where)) ? parent::find() : parent::find()->andWhere($where);
    }

    /**
     * Overrides the {{yii\db\ActiveRecord::delete}} method.
     *
     * @return boolean
     */
    public function delete()
    {
        $result = false;
        
        if ($this->beforeDelete()) {
            $this->updateAttributes(static::internalUpdateValues());
            $result = true;
        }
        
        return $result;
    }
    
    /**
     * Evalate the values to update.
     *
     * @return array
     */
    private static function internalUpdateValues()
    {
        $update = [];
        foreach (static::fieldStateDescriber() as $field => $value) {
            $update[$field] = (is_array($value)) ? $value[0] : $value;
        }
        return $update;
    }
}

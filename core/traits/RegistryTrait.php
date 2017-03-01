<?php

namespace luya\traits;

/**
 * Registry Trait.
 * 
 * Can be attached to ActiveRecords with a `name` and `value` property where name is an unique identifier.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait RegistryTrait
{
    /**
     * Check whether a config value exists or not
     *
     * @param string $name
     * @return boolean
     */
    public static function has($name)
    {
        return (self::find()->where(['name' => $name])->one()) ? true : false;
    }
    
    /**
     * Get the value of a config value
     *
     * @param string $name
     * @return string|null
     */
    public static function get($name, $defaultValue = null)
    {
        $model = self::find()->where(['name' => $name])->asArray()->one();
    
        if ($model) {
            return $model['value'];
        }
    
        return $defaultValue;
    }
    
    /**
     * Store or Update an existing/new config value.
     *
     * @param string $name
     * @param string $value
     */
    public static function set($name, $value)
    {
        $model = self::find()->where(['name' => $name])->one();
    
        if ($model) {
            return (bool) $model->updateAttributes([
                'value' => $value,
            ]);
        }
    
        $model = new self();
        $model->value = $value;
        $model->name = $name;
        return $model->save();
    }
    
    /**
     * Remove an existing config value
     *
     * @param string $name
     */
    public static function remove($name)
    {
        $model = self::find()->where(['name' => $name])->one();
    
        if ($model) {
            return (bool) $model->delete();
        }
    
        return false;
    }
}
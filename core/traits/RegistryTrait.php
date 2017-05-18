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
	 * Determines what attribute field in the corresponding model table should be used to find the identifier key.
	 * 
	 * @return string The name attribute field defaults to `name`.
	 */
	public static function getNameAttribute()
	{
		return 'name';
	}
	
	/**
	 * Determines what attribute field in the corresponding model table should be used to store the identifier key and retrieve its data.
	 * 
	 * @return string The value attribute field defaults to `value`.
	 */
	public static function getValueAttribute()
	{
		return 'value';
	}
	
    /**
     * Check whether a config value exists or not
     *
     * @param string $name
     * @return boolean
     */
    public static function has($name)
    {
        return (self::find()->where([self::getNameAttribute() => $name])->one()) ? true : false;
    }
    
    /**
     * Get the value of a config value
     *
     * @param string $name
     * @return string|null
     */
    public static function get($name, $defaultValue = null)
    {
        $model = self::find()->where([self::getNameAttribute() => $name])->asArray()->one();
    
        if ($model) {
            return $model[self::getValueAttribute()];
        }
    
        return $defaultValue;
    }
    
    /**
     * Store or Update an existing/new config value.
     *
     * @param string $name
     * @param string $value
     * @return boolean
     */
    public static function set($name, $value)
    {
        $model = self::find()->where([self::getNameAttribute() => $name])->one();
    
        if ($model) {
            return (bool) $model->updateAttributes([
                self::getValueAttribute() => $value,
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
     * @return bool
     */
    public static function remove($name)
    {
        $model = self::find()->where([self::getNameAttribute() => $name])->one();
    
        if ($model) {
            return (bool) $model->delete();
        }
    
        return false;
    }
}

<?php

namespace luya\traits;

/**
 * Registry Trait.
 *
 * The RegistryTrait helps to handle set(), get(), has() and remove() operations for a key value based storage.
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

    private static $_data;

    /**
     * Loads all config data into an array.
     *
     * @return array
     * @since 1.3.0
     */
    protected static function getData()
    {
        if (self::$_data === null) {
            self::$_data = self::find()
                ->select([self::getValueAttribute(), self::getNameAttribute()])
                ->indexBy(self::getNameAttribute())
                ->column();
        }

        return self::$_data;
    }

    /**
     * Clear data array.
     * 
     * @since 1.3.0
     */
    protected static function clearData()
    {
        self::$_data = null;
    }
    
    /**
     * Check whether a config value exists or not.
     * 
     * If a value exists but is empty, has will return false.
     *
     * @param string $name The key to lookup. If not found false is returned.
     * @return boolean Whether the key exists or not.
     */
    public static function has($name)
    {
        return array_key_exists($name, self::getData());
    }
    
    /**
     * Get the value of a config value.
     * 
     * Returns the value from the registry for the given $name, if not found the defaultValue is returned.  
     *
     * @param string $name The key to lookup. 
     * @param mixed $defaultValue The default value to return if the key does not exist.
     * @return mixed
     */
    public static function get($name, $defaultValue = null)
    {
        if (self::has($name)) {
            return self::getData()[$name];
        }
    
        return $defaultValue;
    }
    
    /**
     * Store or Update an existing/new config value.
     * 
     * If the config value is not found, a new record will be created.
     *
     * @param string $name They config key
     * @param string $value They config value. When working with array data, encode the data first with Json::encode.
     * @return boolean Whether saving was successfull or not.
     */
    public static function set($name, $value)
    {
        $model = self::find()->where([self::getNameAttribute() => $name])->one();
        self::clearData();
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
     * Remove an existing config value.
     * 
     * If the value is not found in the config, false is returned.
     *
     * @param string $name The key to remove.
     * @return bool If element was found and deleting was successfull true is returned, otherwise false.
     */
    public static function remove($name)
    {
        $model = self::find()->where([self::getNameAttribute() => $name])->one();
    
        if ($model) {
            self::clearData();
            return (bool) $model->delete();
        }
    
        return false;
    }
}

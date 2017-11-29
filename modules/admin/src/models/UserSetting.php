<?php

namespace luya\admin\models;

use yii\db\ActiveRecordInterface;
use yii\base\BaseObject;

/**
 * Store and read user settings.
 *
 * UserSettins allows you to store values a user specific inside the database. For example
 * the last state of the cms page tree.
 *
 * Store a value for a key
 *
 * ```php
 * Yii::$app->adminuser->identity->setting->set('lastPage', '.../url/to/last/page');
 * ```
 *
 * `null`, `true` and `false` are also valid values to store. To remove a settings entry call the `remove()` method:
 *
 * ```php
 * Yii::$app->adminuser->identity->setting->remove('lastPage');
 * ```
 *
 * In order to set arrayable values use dot notation, for example.
 *
 * ```php
 * Yii::$app->adminuser->identity->setting->set('menutree.id1', true);
 * Yii::$app->adminuser->identity->setting->set('menutree.id2', false);
 * ```
 *
 * The same works to get and delete array keys:
 *
 * ```php
 * Yii::$app->adminuser->identity->setting->get('menutree.id1');
 * ```
 *
 * If the key does not exists, null will be returned by default.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class UserSetting extends BaseObject implements \ArrayAccess
{
    const SEPERATOR = '.';

    public $data = [];

    public $sender;

    private function save()
    {
        if ($this->sender !== null && $this->sender instanceof ActiveRecordInterface) {
            $this->sender->updateSettings($this->data);
        }
    }

    /**
     * Get a key of the user settings, dot notation is allowed to return a key of an array.
     *
     * @param string $key
     * @param string|bool|null $default
     * @return string|array|null
     */
    public function get($key, $default = null)
    {
        $array = $this->data;
        foreach (explode(self::SEPERATOR, $key) as $item) {
            if (is_array($array) && array_key_exists($item, $array)) {
                $array = $array[$item];
            } else {
                return $default;
            }
        }

        return $array;
    }
    
    /**
     * Returns multiple array keys from the user settings table.
     *
     * Example usage:
     *
     * ```php
     * getArray(['key1', 'key2', [
     *     'key1' => false,
     *     'key2' => true,
     * ]);
     * ```
     *
     * The above example would return the default value true for `key2` if this element is not found inside the
     * user settings.
     *
     * @param array $keys Provide an array of keys you to select.
     * @param array $defaultMapping In order to define a default value for a given key, just use the variable name
     * as array key.`
     * @return array
     */
    public function getArray(array $keys, array $defaultMapping = [])
    {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $this->get($key, array_key_exists($key, $defaultMapping) ? $defaultMapping[$key] : null);
        }
        
        return $data;
    }

    /**
     * Check if an element existing inside the user settings or not.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        $array = $this->data;
        foreach (explode(self::SEPERATOR, $key) as $item) {
            if (is_array($array) && array_key_exists($item, $array)) {
                $array = $array[$item];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove an element from the user settings data array.
     *
     * @param string $key
     * @return bool
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            $array = &$this->data;
            foreach (explode(self::SEPERATOR, $key) as $item) {
                if (array_key_exists($item, $array)) {
                    $lastArray = &$array;
                    $array = &$array[$item];
                }
            }
            
            unset($lastArray[$item]);
            if (empty($lastArray)) {
                unset($lastArray);
            }
            $this->save();
            return true;
        }
        
        return false;
    }

    /**
     * Add a new element to the user settings array.
     *
     * @param string $key
     * @param array|string|boolean $value
     * @return bool
     */
    public function set($key, $value)
    {
        $array = &$this->data;
        $keys = explode(self::SEPERATOR, $key);
        $i = 1;
        foreach ($keys as $item) {
            if (is_array($array) && array_key_exists($item, $array) && !is_array($array[$item]) && $i !== count($keys)) {
                return false;
            }
            $array = &$array[$item];
            $i++;
        }
        $array = $value;
        $this->save();
        return true;
    }

    // ArrayAccess

    /**
     * Exists method for ArrayAccess.
     *
     * @param string $offset The offset key
     * @return boolean Whether the offset key exists in the array or not.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Setter method for ArrayAccess.
     *
     * @param string $offset The offset key
     * @param mixed $value The offset value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Unset method for ArrayAccess.
     *
     * @param string $offset The offset key
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Getter method for ArrayAccess.
     *
     * @param string $offset The offset key
     * @return mixed The value when accessing the array.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
}

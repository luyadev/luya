<?php

namespace luya\admin\models;

use yii\base\Object;
use yii\db\ActiveRecordInterface;

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
 * @since 1.0.0-beta8
 */
class UserSetting extends Object implements \ArrayAccess
{
    const SEPERATOR = '.';

    public $data = [];

    public $sender = null;

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
     * @param string|booelan|null $default
     * @return string|array|null
     */
    public function get($key, $default = null)
    {
        $array = $this->data;
        foreach (explode(self::SEPERATOR, $key) as $key) {
            if (is_array($array) && array_key_exists($key, $array)) {
                $array = $array[$key];
            } else {
                return $default;
            }
        }

        return $array;
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
        foreach (explode(self::SEPERATOR, $key) as $key) {
            if (is_array($array) && array_key_exists($key, $array)) {
                $array = $array[$key];
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
     * @return void
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            $array = &$this->data;
            foreach (explode(self::SEPERATOR, $key) as $key) {
                if (array_key_exists($key, $array)) {
                    $lastArray = &$array;
                    $array = &$array[$key];
                }
            }
            
            if (isset($lastArray) && $lastArray[$key]);
            unset($lastArray[$key]);
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
     * @return booelan
     */
    public function set($key, $value)
    {
        $array = &$this->data;
        $keys = explode(self::SEPERATOR, $key);
        $i = 1;
        foreach ($keys as $key) {
            if (is_array($array) && array_key_exists($key, $array) && !is_array($array[$key]) && $i !== count($keys)) {
                return false;
            }
            $array = &$array[$key];
            $i++;
        }
        $array = $value;
        $this->save();
        return true;
    }

    // ArrayAccess

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     *
     * {@inheritDoc}
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
}

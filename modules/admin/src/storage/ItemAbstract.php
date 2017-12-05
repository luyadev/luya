<?php

namespace luya\admin\storage;

use Yii;
use yii\base\ArrayableTrait;
use yii\base\Arrayable;
use luya\Exception;
use yii\base\BaseObject;

/**
 * Base class for file, image and folder Items.
 *
 * @property $itemArray array An array with all elements assigned for this element.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class ItemAbstract extends BaseObject implements Arrayable
{
    use ArrayableTrait;
    
    private $_itemArray = [];
    
    /**
     * Setter method for itemArray property.
     * @param array $item
     */
    public function setItemArray(array $item)
    {
        $this->_itemArray = $item;
    }
    
    /**
     * Returns the whole item array.
     *
     * @return array An array with all keys for the given item.
     */
    public function getItemArray()
    {
        return $this->_itemArray;
    }
    
    /**
     * Returns a value for a given key inside the itemArray.
     *
     * @param string $key The requested key.
     * @throws Exception If the key is not found inside the array an exception is trhown.
     */
    public function getKey($key)
    {
        if (!array_key_exists($key, $this->_itemArray)) {
            throw new Exception("Unable to find the requested item key '$key' in item " . var_export($this->_itemArray, true));
        }
        
        return $this->_itemArray[$key];
    }

    /**
     * Method to construct/build the item from Iterator or Query class.
     *
     * @param array $itemArray The array data
     * @return object Returns the specific item object (file, folder, image).
     */
    public static function create(array $itemArray)
    {
        return Yii::createObject(['class' => self::className(), 'itemArray' => $itemArray]);
    }
}

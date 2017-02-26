<?php

namespace luya\admin\storage;

use Yii;
use yii\base\Object;
use yii\base\ArrayableTrait;
use yii\base\Arrayable;

/**
 * @property $itemArray array An array with all elements assigned for this element.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class ItemAbstract extends Object implements Arrayable
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
     * @deprecated Remove.
     * @return unknown
     */
    public function getItemArray()
    {
        return $this->_itemArray;
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

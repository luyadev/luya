<?php

namespace luya\admin\storage;

use Yii;

trait ItemTrait
{
    /**
     * @var array The array containing all data for the current item.
     */
    public $itemArray = [];

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
    
    /**
     * Convert the current Object methods to an array whether the key is the property and value the method
     * response for the given key.
     *
     * @return array
     */
    abstract public function toArray();
}

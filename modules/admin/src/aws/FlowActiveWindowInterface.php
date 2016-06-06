<?php

namespace admin\aws;

use admin\image\Item;

/**
 * This interface must be implement by the model class provided in the FlowActiveWindow modelClass property.
 * 
 * @since 1.0.0-beta7
 * @author Basil Suter <basil@nadar.io>
 */
interface FlowActiveWindowInterface
{
    /**
     * Active Record findOne method to retrieve the model row by the itemId.
     * 
     * @param mixed $condition
     */
    public static function findOne($condition);

    /**
     * This method will be called when the storage item is created, so you can perform the database save action
     * by implementing this method.
     * 
     * @param \admin\image\Item $image The storage image item object which has been generated from active window.
     */
    public function flowSaveImage(Item $image);
    
    /**
     * Get an array with all ids for the storage component.
     */
    public function flowListImages();
}
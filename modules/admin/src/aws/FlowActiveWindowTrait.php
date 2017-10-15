<?php

namespace luya\admin\aws;

use Yii;
use yii\db\Query;
use yii\base\InvalidConfigException;
use luya\admin\image\Item;
use luya\helpers\ArrayHelper;

/**
 * Helper Trait to enable FlowActiveWindowInterface functions by define the relation table informations.
 *
 * ```php
 * use FlowActiveWindowTrait;
 *
 * public function flowConfig()
 * {
 *     return [
 *         'table' => 'relation_table_name', // the table which contains the relation data between model/item and image.
 *         'itemField' => 'group_id', // the field defined on where the window is attached
 *         'imageField' => 'image_id', // the value of the image id can be stored in.
 *     ];
 * }
 * ```
 *
 * This trait allows you also to easy get all images from the storage system by using the `flowGetImages()` method.
 *
 * @since 1.0.0
 * @author Basil Suter <basil@nadar.io>
 */
trait FlowActiveWindowTrait
{
    /**
     * An array which defines the configuration for this flow uploader active window.
     *
     * ```php
     * return [
     *     'table' => 'relation_table_name', // the table which contains the relation data between model/item and image.
     *     'itemField' => 'group_id', // the field defined on where the window is attached
     *     'imageField' => 'image_id', // the value of the image id can be stored in.
     * ];
     */
    abstract public function flowConfig();
    
    /**
     * Get a specific value from the `fowConfig()` method.
     *
     * @param string $key The requested key from the config
     * @return string The value for the $key
     * @throws InvalidConfigException
     */
    protected function getConfigValue($key)
    {
        if (!isset($this->flowConfig()[$key])) {
            throw new InvalidConfigException("The flowConfig() method must return an array with a field named '$key'.");
        }
        
        return $this->flowConfig()[$key];
    }
    
    /**
     * This method will be called when the storage item is created, so you can perform the database save action
     * by implementing this method.
     *
     * @param \admin\image\Item $image The storage image item object which has been generated from active window.
     */
    public function flowSaveImage(Item $image)
    {
        Yii::$app->db->createCommand()->insert($this->getConfigValue('table'), [
            $this->getConfigValue('itemField') => $this->id,
            $this->getConfigValue('imageField') => $image->id,
        ])->execute();
    }
    
    /**
     * This method will be called when the delete button will be triggered for an uploaded image. Now you should removed
     * the corresponding reference item in your database table. The image objec deletion will be trigger by the active window.
     *
     * @param \admin\image\Item $image
     */
    public function flowDeleteImage(Item $image)
    {
        Yii::$app->db->createCommand()->delete($this->getConfigValue('table'), [$this->getConfigValue('imageField') => $image->id])->execute();
    }
    
    /**
     * Get an array with all ids for the storage component. Only the image ids for the current
     * model/item id should be returned:
     *
     * ```php
     * return [1,2,3]; // where 1,2,3 are ids of the image from the storage component
     * ```
     *
     * @return array An array where only the images are returned.
     */
    public function flowListImages()
    {
        return ArrayHelper::getColumn((new Query())->select([$this->getConfigValue('imageField')])->from($this->getConfigValue('table'))->where([$this->getConfigValue('itemField') => $this->id])->indexBy($this->getConfigValue('imageField'))->all(), $this->getConfigValue('imageField'));
    }
    
    /**
     * Get all images for the current item/model directly from the Storage Components `findImages` method. This helper method
     * allows you to easy foreach all images in your frontend implemenation and create the gallery collection.
     *
     * @return \admin\image\Iterator An iterator object with all images of the current modeL/item.
     */
    public function flowGetImages()
    {
        return Yii::$app->storage->findImages(['in', 'id', $this->flowListImages()]);
    }
}

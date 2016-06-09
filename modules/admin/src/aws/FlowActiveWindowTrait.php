<?php

namespace admin\aws;

use admin\image\Item;
use luya\helpers\ArrayHelper;
use yii\db\Query;
use yii\base\InvalidConfigException;

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
 * @since 1.0.0-beta7
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
    
    protected function getConfigValue($key)
    {
        if (!isset($this->flowConfig()[$key])) {
            throw new InvalidConfigException("The flowConfig() method must return an array with a field named '$key'.");
        }
        
        return $this->flowConfig()[$key];
    }
    
    /**
     * 
     * @param Item $image
     */
    public function flowSaveImage(Item $image)
    {
        Yii::$app->db->createCommand()->insert($this->getConfigValue('table'), [
            $this->getConfigValue('itemField') => $this->id,
            $this->getConfigValue('imageField') => $image->id,
        ])->execute();
    }
    
    /**
     * 
     * @param Item $image
     */
    public function flowDeleteImage(Item $image)
    {
        Yii::$app->db->createCommand()->delete($this->getConfigValue('table'), [$this->getConfigValue('imageField') => $image->id])->execute();
    }
    
    /**
     * 
     */
    public function flowListImage()
    {
        return ArrayHelper::getColumn((new Query())->select([$this->getConfigValue('imageField')])->from($this->getConfigValue('table'))->where([$this->getConfigValue('itemField') => $this->id])->indexBy($this->getConfigValue('imageField'))->all(), $this->getConfigValue('imageFiled'));
    }
}
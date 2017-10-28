<?php

namespace luya\admin\aws;

use luya\admin\image\Item;

/**
 * This interface must be implement by the model class provided in the FlowActiveWindow modelClass property.
 *
 * Example implementations for FlowActiveWindowInterface on a NgRest or ActiveRecord Model:
 *
 * ```php
 * public function flowSaveImage(Item $image)
 * {
 *     Yii::$app->db->createCommand()->insert('flow_gallery', [
 *         'model_id' => $this->id,
 *         'image_id' => $image->id,
 *     ])->execute();
 * }
 *
 * public function flowDeleteImage(Item $image)
 * {
 * 	Yii::$app->db->createCommand()->delete('flow_gallery', ['image_id' => $image->id])->execute();
 * }
 *
 * public function flowListImages()
 * {
 *     return ArrayHelper::getColumn((new Query())->select(['image_id'])->from('flow_gallery')->where(['model_id' => $this->id])->indexBy('image_id')->all(), 'image_id');
 * }
 * ```
 *
 * You can **aslo** use the [[admin\aws\FlowActiveWindowTrait]] which enables those methods and you only have to configure
 * the relation table between the model/item and the image.
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
 * @since 1.0.0
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
     * @return void
     */
    public function flowSaveImage(Item $image);
    
    /**
     * This method will be called when the delete button will be triggered for an uploaded image. Now you should removed
     * the corresponding reference item in your database table. The image objec deletion will be trigger by the active window.
     *
     * @param \admin\image\Item $image
     * @return void
     */
    public function flowDeleteImage(Item $image);
    
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
    public function flowListImages();
}

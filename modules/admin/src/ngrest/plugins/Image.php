<?php

namespace luya\admin\ngrest\plugins;

use Yii;
use luya\admin\ngrest\base\Plugin;

/**
 * Type Image Upload.
 * 
 * Usage example inside your {{luya\admin\ngrest\base\NgRestModel::ngRestAttributeTypes}} method:
 * 
 * ```php
 * return [
 *     'myimage' => 'image',
 * ];
 * ```
 * 
 * If you like to get the {{luya\admin\image\Item}} object directly from the {{luya\admin\components\StorageContainer}} component just enable `$imageItem`.
 * 
 * ```php
 * return [
 *     'myimage' => ['image', 'imageItem' => true],
 * ];
 * ```
 * 
 * Now when accessing the `$myimage` variabled defined from above the {{luya\admin\image\Item}} will be returned ottherwise false.
 * 
 * If the user should not have the ability to selecte a filter enable `$noFilters`.
 * 
 * ```php
 * return [
 *     'myimage' => ['noFilters' => true],
 * ];
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Image extends Plugin
{
    /**
     * @var boolean Whether the user can choose a filter or not.
     */
    public $noFilters = false;

    /**
     * @var boolean Whether to return a {{luya\admin\image\Item}} instead of the numeric image id value from the database.
     */
    public $imageItem = false;
    
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createTag('storage-image-thumbnail-display', null, ['image-id' => "{{{$ngModel}}}"]);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-image-upload', $id, $ngModel, ['options' => json_encode(['no_filter' => $this->noFilters])]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    /**
     * @inheritDoc
     */
    public function onAfterFind($event)
    {
        if ($this->imageItem) {
            $event->sender->setAttribute($this->name, Yii::$app->storage->getImage($event->sender->getAttribute($this->name)));
        }
    }
}

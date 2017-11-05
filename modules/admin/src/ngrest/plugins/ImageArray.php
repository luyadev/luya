<?php

namespace luya\admin\ngrest\plugins;

use yii\helpers\Json;
use luya\admin\ngrest\base\Plugin;
use luya\admin\image\Query;
use luya\helpers\ArrayHelper;

/**
 * Type Multiple Image Upload.
 *
 * Usage example inside your {{luya\admin\ngrest\base\NgRestModel::ngRestAttributeTypes}} method:
 *
 * ```php
 * return [
 *     'myimages' => 'imageArray',
 * ];
 * ```
 *
 * If you like to get the {{luya\admin\image\Iterator}} object directly from the {{luya\admin\storage\BaseFileSystemStorage}} component just enable `$imageIterator`.
 *
 * ```php
 * return [
 *     'myimages' => ['imageArray', 'imageIterator' => true],
 * ];
 * ```
 *
 * Now when accessing the `$myimages` variabled defined from above the {{luya\admin\image\Iterator}} will be returned ottherwise false.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ImageArray extends Plugin
{
    /**
     * @inheritdoc
     */
    public $i18nEmptyValue = [];
    
    /**
     * @var boolean Whether to return a {{luya\admin\image\Iterator}} instead of an array with image ids value from the database.
     */
    public $imageIterator = false;
    
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-image-array-upload', $id, $ngModel);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }

    /**
     * @inheritdoc
     */
    public function onBeforeSave($event)
    {
        // if its not i18n casted field we have to serialize the the image array as json and abort further event excution.
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, Json::encode($event->sender->getAttribute($this->name)));
            return false;
        }
    
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeExpandFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
            return false;
        }
        
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
            if ($this->imageIterator) {
                $event->sender->setAttribute($this->name, $this->parseImageIteration($event->sender->getAttribute($this->name)));
            }
            return false;
        }
        
        return true;
    }
    
    /**
     * @inheritDoc
     */
    public function onAfterFind($event)
    {
        if ($this->imageIterator) {
            $event->sender->setAttribute($this->name, $this->parseImageIteration($event->sender->getAttribute($this->name)));
        }
    }
    
    /**
     * Parse an array with imageId and caption into an \luya\admin\image\Iterator object.
     *
     * @param array $values The array with key 'imageId' like `[['imageId' => 1, 'caption' => 'test']]`.
     * @return \luya\admin\image\Iterator The iterator object from the parsed values or an empty array if empty.
     */
    protected function parseImageIteration(array $values)
    {
        if (empty($values)) {
            return [];
        }
        return (new Query())->where(['in', 'id', ArrayHelper::getColumn($values, 'imageId')])->all();
    }
}

<?php

namespace luya\admin\ngrest\plugins;

use Yii;
use luya\admin\ngrest\base\Plugin;

/**
 * Type File Upload.
 *
 * Usage example inside your {{luya\admin\ngrest\base\NgRestModel::ngRestAttributeTypes}} method:
 *
 * ```php
 * return [
 *     'myfile' => 'file',
 * ];
 * ```
 *
 * If you like to get the {{luya\admin\file\Item}} object directly from the {{luya\admin\storage\BaseFileSystemStorage}} component just enable `$fileItem`.
 *
 * ```php
 * return [
 *     'myfile' => ['file', 'fileItem' => true],
 * ];
 * ```
 *
 * Now when accessing the `$myfile` variabled defined from above the {{luya\admin\file\Item}} will be returned ottherwise false.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class File extends Plugin
{
    /**
     * @var boolean Whether to return a {{luya\admin\file\Item}} instead of the numeric file id value from the database.
     */
    public $fileItem = false;
    
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createTag('storage-file-display', null, ['file-id' => "{{{$ngModel}}}"]);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-file-upload', $id, $ngModel);
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
        if ($this->fileItem) {
            $event->sender->setAttribute($this->name, Yii::$app->storage->getFile($event->sender->getAttribute($this->name)));
        }
    }
}

<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;
use luya\helpers\ArrayHelper;
use luya\admin\file\Query;

/**
 * Type Multiple Files Upload.
 *
 * Usage example inside your {{luya\admin\ngrest\base\NgRestModel::ngRestAttributeTypes}} method:
 *
 * ```php
 * return [
 *     'myfiles' => 'fileArray',
 * ];
 * ```
 *
 * If you like to get the {{luya\admin\file\Iterator}} object directly from the {{luya\admin\storage\BaseFileSystemStorage}} component just enable `$fileIterator`.
 *
 * ```php
 * return [
 *     'myfiles' => ['fileArray', 'fileIterator' => true],
 * ];
 * ```
 *
 * Now when accessing the `$myfiles` variabled defined from above the {{luya\admin\file\Iterator}} will be returned ottherwise false.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class FileArray extends Plugin
{
    /**
     * @inheritdoc
     */
    public $i18nEmptyValue = [];
    
    /**
     * @var boolean Whether to return a {{luya\admin\file\Iterator}} instead of an array with file ids value from the database.
     */
    public $fileIterator = false;
    
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
        return $this->createFormTag('zaa-file-array-upload', $id, $ngModel);
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
        // if its not i18n casted field we have to serialize the the file array as json and abort further event excution.
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
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
            if ($this->fileIterator) {
                $event->sender->setAttribute($this->name, $this->parseFileIteration($event->sender->getAttribute($this->name)));
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
        if ($this->fileIterator) {
            $event->sender->setAttribute($this->name, $this->parseFileIteration($event->sender->getAttribute($this->name)));
        }
    }
    
    /**
     * Parse an array with fileId and caption into an {{\luya\admin\file\Iterator}} object.
     *
     * @param array $values The array with key 'fileId' like `[['fileId' => 1, 'caption' => 'test']]`.
     * @return \luya\admin\file\Iterator The iterator object from the parsed values or an empty array if empty.
     */
    protected function parseFileIteration(array $values)
    {
        if (empty($values)) {
            return [];
        }
        return (new Query())->where(['in', 'id', ArrayHelper::getColumn($values, 'fileId')])->all();
    }
}

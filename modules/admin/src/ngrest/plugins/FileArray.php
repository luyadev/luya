<?php

namespace luya\admin\ngrest\plugins;

use yii\helpers\Json;
use luya\admin\ngrest\base\Plugin;

/**
 * Multi File-Upload selector
 *
 * @author nadar
 */
class FileArray extends Plugin
{
    public $i18nEmptyValue = [];
    
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-file-array-upload', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    public function onBeforeSave($event)
    {
        // if its not i18n casted field we have to serialize the the file array as json and abort further event excution.
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            return false;
        }
        
        return true;
    }
    
    public function onBeforeExpandFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
            return false;
        }
         
        return true;
    }
    
    public function onBeforeFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
            return false;
        }
        
        return true;
    }
}

<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Create a list element with self adding text inputs and responses as array.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TextArray extends Plugin
{
    public $i18nEmptyValue = [];
    
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-list-array', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    
    private function transformList($listArrayValue)
    {
        if (empty($listArrayValue)) {
            return [];
        }
        
        $data = [];
        foreach ($listArrayValue as $item) {
            if (isset($item['value'])) {
                $data[] = $item['value'];
            }
        }
        return $data;
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
            $event->sender->setAttribute($this->name, $this->transformList($this->jsonDecode($event->sender->getAttribute($this->name))));
            return false;
        }
        
        return true;
    }
    
    public function onAfterFind($event)
    {
        $event->sender->setAttribute($this->name, $this->transformList($event->sender->getAttribute($this->name)));
    }
}

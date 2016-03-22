<?php

namespace admin\ngrest\plugins;

use yii\helpers\Json;

/**
 * @author nadar
 */
class ImageArray extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-image-array-upload', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }

    public function onBeforeSave($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            return false;
        }
    
        return true;
    }
    
    /*
    public function onAfterNgRestFind($fieldValue)
    {
        return Json::decode($fieldValue);
    }

    public function onAfterFind($fieldValue)
    {
        return Json::decode($fieldValue);
    }

    public function onBeforeCreate($value)
    {
        if (empty($value) || !is_array($value)) {
            $value = [];
        }
        
        return Json::encode($value);
    }

    public function onBeforeUpdate($value, $oldValue)
    {
        return $this->onBeforeCreate($value);
    }
    */
}

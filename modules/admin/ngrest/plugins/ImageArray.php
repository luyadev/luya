<?php

namespace admin\ngrest\plugins;

use yii\helpers\Json;

/**
 * @author nadar
 */
class ImageArray extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '[Bilder-Liste]');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-image-array-upload');
        // append to document
        $doc->appendChild($elmn);
        // return DomDocument
        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

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
}

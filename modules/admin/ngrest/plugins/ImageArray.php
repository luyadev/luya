<?php

namespace admin\ngrest\plugins;

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

    //

    public function onAfterNgRestFind($fieldValue)
    {
        return json_decode($fieldValue, true);
    }
    
    public function onAfterFind($fieldValue)
    {
        return json_decode($fieldValue, true);
    }

    public function onBeforeCreate($value)
    {
        if (empty($value) || !is_array($value)) {
            return json_encode([]);
        }
        $data = [];
        foreach ($value as $key => $item) {
            $data[$key] = [
                'imageId' => $item['imageId'],
                'caption' => $item['caption'],
            ];
        }

        return json_encode($data);
    }

    public function onBeforeUpdate($value, $oldValue)
    {
        return $this->onBeforeCreate($value);
    }
}

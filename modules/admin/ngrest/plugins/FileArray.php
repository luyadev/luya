<?php

namespace admin\ngrest\plugins;

/**
 * @author nadar
 */
class FileArray extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '[Datei-Liste]');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement('zaa-file-array-upload');
        $elmn->setAttribute('id', $this->id);
        $elmn->setIdAttribute('id', true);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('label', $this->alias);
        $elmn->setAttribute('grid', $this->gridCols);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

    //

    public function onAfterFind($value)
    {
        return json_decode($value, true);
    }

    public function onBeforeCreate($value)
    {
        if (empty($value) || !is_array($value)) {
            return json_encode([]);
        }
        $data = [];
        foreach ($value as $key => $item) {
            $data[$key] = [
                'fileId' => $item['fileId'],
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

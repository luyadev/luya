<?php
namespace admin\ngrest\plugins;

/**
 * @author nadar
 */
class FileArray extends \admin\ngrest\PluginAbstract
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement("span", "[Datei-Liste]");
        $doc->appendChild($elmn);
        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("zaa-file-array-upload");
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("model", $this->ngModel);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
    
    public static function onAfterList($value)
    {
        return json_decode($value);
    }
    
    public static function onBeforeCreate($value)
    {
        if (empty($value) || !is_array($value)) {
            return json_encode([]);
        }
        $data = [];
        foreach($value as $key => $item) {
            $data[$key] = [
                "fileId" => $item['fileId'],
                "caption" => $item['caption'],
            ];
        }
        
        return json_encode($data);
    }
    
    public static function onBeforeUpdate($value)
    {
        return static::onBeforeCreate($value);
    }
}

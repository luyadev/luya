<?php
namespace admin\ngrest\plugins;

/**
 * @todo check if the plugin is opened by an extraField, cause its not working on casual fields
 * @author nadar
 *
 */
class CheckboxReleation extends \admin\ngrest\PluginAbstract
{
    use \admin\ngrest\PluginTrait;

    public $options = [
        "model" => "",
    ];

    public function renderCreate($doc)
    {
        $className = $this->getOption('model');
        $data = $className::find()->all();
        
        foreach ($data as $item) {
            $newItem = $item->toArray();
            //$newItem['label'] = $newItem['title'];
            $newItem['label'] = $newItem[$this->getOption('labelField')];
            $x[] = $newItem;
        }
        
        $options = [
            "items" => $x
        ];
        
        $elmn = $doc->createElement("zaa-input-checkbox", "");
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("model", $this->ngModel);
        $elmn->setAttribute("options", json_encode($options));
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

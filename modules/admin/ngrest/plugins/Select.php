<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

/**
 * create a select dropdown box with option list:
 * 
 * Thee following propertys are provided:
 * - select(['array' => [ 'key' => 'label', 'key2' => 'label2' ]]);
 * - select(['model' => ['class' => '\path\to\model\class', 'value' => 'ValueFieldKeyName', 'label' => 'LabelFieldKeyName']]);
 * 
 * @author nadar
 */
class Select extends PluginAbstract
{
    use \admin\ngrest\PluginTrait;
    
    private $_values = [];

    public function init()
    {
        if ($this->hasOption('array')) {
            foreach ($this->getOption('array') as $key => $value) {
                $this->_values[] = [
                    "value" => $key,
                    "label" => $value,
                ];
            }
        }
        
        if (($modelClass = $this->getOption('model')) !== false) {
            $className = $modelClass['class'];
            foreach ($className::find()->all() as $item) {
                $this->_values[] = [
                    "value" => $item->$modelClass['value'],
                    "label" => $item->$modelClass['label'],
                ];
            }
        }
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("zaa-input-select");
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("model", $this->ngModel);
        $elmn->setAttribute("options", json_encode($this->_values));
        $elmn->setAttribute("class", "form__input");
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

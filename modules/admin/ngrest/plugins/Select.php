<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

/**
 * create a select dropdown box with option list:
 * 
 * Thee following propertys are provided:
 * - select(['assocArray' => [ 'key' => 'label', 'key2' => 'label2' ]]);
 * 
 * @author nadar
 */
class Select extends PluginAbstract
{
    use \admin\ngrest\PluginTrait;
    
    private $_values = [];
    
    public $options = [
        'assocArray' => [],
    ];

    public function init()
    {
        foreach ($this->getOption('assocArray') as $key => $value) {
            $this->_values[] = [
                "id" => $key,
                "label" => $value,
            ];
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

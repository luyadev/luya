<?php

namespace admin\ngrest\plugins;

/**
 * create a select dropdown box with option list:.
 *
 * Thee following propertys are provided:
 * - select(['array' => [ 'key' => 'label', 'key2' => 'label2' ]]);
 * - select(['model' => ['class' => '\path\to\model\class', 'value' => 'ValueFieldKeyName', 'label' => 'LabelFieldKeyName']]);
 *
 * @author nadar
 */
abstract class Select extends \admin\ngrest\base\Plugin
{
    use \admin\ngrest\PluginTrait;

    public $initValue = null;
    
    public $data = [];

    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '{{item.'.$this->name.'}}');
        $doc->appendChild($elmn);
        
        return $doc;
    }
    
    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-select');
        $elmn->setAttribute('initvalue', $this->initValue);
        $elmn->setAttribute('options', $this->getServiceName('selectdata'));
        // append to document
        $doc->appendChild($elmn);
        // return DomDocument
        return $doc;
    }
    
    public function serviceData()
    {
        return ['selectdata' => $this->data];
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
    
    public function onAfterNgRestList($fieldValue)
    {
        foreach($this->data as $item) {
            if ($item['value'] == $fieldValue) {
                return $item['label'];
            }
        }
        
        return $fieldValue;
    }
}

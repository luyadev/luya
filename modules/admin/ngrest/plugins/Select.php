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

    public $data = [];

    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '{{item.'.$this->name.'}}');
        $doc->appendChild($elmn);
        
        return $doc;
    }
    
    public function renderCreate($doc)
    {
        $elmn = $doc->createElement('zaa-select');
        $elmn->setAttribute('id', $this->id);
        $elmn->setIdAttribute('id', true);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('options', json_encode($this->data));
        $elmn->setAttribute('label', $this->alias);
        $elmn->setAttribute('grid', $this->gridCols);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

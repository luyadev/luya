<?php

namespace admin\ngrest\plugins;

/**
 * @todo Put the __construct and getOption methods into the PluginAbstract method and leave the options array with default values in private $options = []
 *
 * @author nadar
 */
class Image extends \admin\ngrest\base\Plugin
{
    public $noFilters = false;
    
    public function __construct($noFilters = false)
    {
        $this->noFilters = $noFilters;
    }
    
    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '{{item.'.$this->name.'}}');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-image-upload');
        $elmn->setAttribute('options', json_encode(['no_filter' => $this->noFilters ]));
        // append to document
        $doc->appendChild($elmn);
        // return DomDocument
        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

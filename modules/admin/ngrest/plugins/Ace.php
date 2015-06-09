<?php

namespace admin\ngrest\plugins;

/**
 * @todo Put the __construct and getOption methods into the PluginAbstract method and leave the options array with default values in private $options = []
 *
 * @author nadar
 */
class Ace extends \admin\ngrest\base\Plugin
{
    use \admin\ngrest\PluginTrait;

    public $theme = null;

    public $mode = null;

    public function __construct($theme = 'chrome', $mode = 'json')
    {
        $this->theme = $theme;
        $this->mode = $mode;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement('div');
        $elmn->setAttribute('ui-ace', "{useWrapMode : true,  showGutter: true, theme:'".$this->theme."', mode: '".$this->mode."'}");
        $elmn->setAttribute('ng-model', $this->ngModel);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

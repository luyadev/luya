<?php
namespace admin\ngrest\plugins;

/**
 * @todo Put the __construct and getOption methods into the PluginAbstract method and leave the options array with default values in private $options = []
 * @author nadar
 *
 */
class Ace extends \admin\ngrest\PluginAbstract
{
    use \admin\ngrest\PluginTrait;

    public $options = [
        "theme" => "chrome",
        "mode" => "json",
    ];

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("div");
        $elmn->setAttribute("ui-ace", "{useWrapMode : true,  showGutter: true, theme:'".$this->getOption('theme')."', mode: '".$this->getOption('mode')."'}");
        $elmn->setAttribute("ng-model", $this->ngModel);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

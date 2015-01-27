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

    private $options = [
        "theme" => "chrome",
        "mode" => "json",
    ];

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }
    }

    private function getOption($key)
    {
        return (isset($this->options[$key])) ? $this->options[$key] : false;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("div");
        $elmn->setAttribute("ui-ace", "{useWrapMode : true,  showGutter: true, theme:'".$this->getOption('theme')."', mode: '".$this->getOption('mode')."'}");
        $elmn->setAttribute("ng-model", $this->config['ngModel']);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

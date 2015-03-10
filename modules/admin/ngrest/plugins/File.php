<?php
namespace admin\ngrest\plugins;

/**
 * @todo Put the __construct and getOption methods into the PluginAbstract method and leave the options array with default values in private $options = []
 * @author nadar
 *
 */
class File extends \admin\ngrest\PluginAbstract
{
    use \admin\ngrest\PluginTrait;

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("storage-file-upload");
        $elmn->setAttribute("ng-model", $this->ngModel);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}

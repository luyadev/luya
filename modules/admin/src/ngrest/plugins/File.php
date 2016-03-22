<?php

namespace admin\ngrest\plugins;

/**
 * @todo Put the __construct and getOption methods into the PluginAbstract method and leave the options array with default values in private $options = []
 *
 * @author nadar
 */
class File extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-file-upload', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}

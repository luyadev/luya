<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Create a text input select for a given field.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Text extends Plugin
{
    /**
     * @var string Define a HTML placeholder attribute.
     */
    public $placeholder;
    
    /**
     * @var array An array with options can be passed to the createListTag.
     */
    public $listOptions = [];

    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel, $this->listOptions);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-text', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}

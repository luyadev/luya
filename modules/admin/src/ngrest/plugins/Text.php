<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Create a text input select for a given field.
 *
 * @author nadar
 */
class Text extends Plugin
{
    /**
     * @var string Define a HTML placeholder attribute.
     */
    public $placeholder = null;
    
    /**
     * @var array An array with options can be passed to the createListTag.
     */
    public $listOptions = [];

    /**
     *
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderList()
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel, $this->listOptions);
    }

    /**
     *
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderCreate()
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-text', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderUpdate()
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}

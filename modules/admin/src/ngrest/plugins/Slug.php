<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Create a HTML5 number-tag.
 *
 * You can optional set a placeholder value to guide your users, or an init value which will be assigned
 * to the angular model if nothing is set.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Slug extends Plugin
{
    /**
     * @var integer Html field placeholder
     */
    public $placeholder;

    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-slug', $id, $ngModel, ['placeholder' => $this->placeholder]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}

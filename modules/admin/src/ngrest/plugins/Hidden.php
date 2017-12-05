<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Hidden Field Plugin.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Hidden extends Plugin
{
    /**
     * @var string|integer This value will be stored on create and update actions as a hidden field.
     */
    public $value;
    
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createTag('input', null, ['ng-model' => $ngModel, 'type' => 'hidden', 'name' => $id, 'id' => $id, 'value' => $this->value, 'ng-init' => "{$ngModel}={$this->value}"]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}

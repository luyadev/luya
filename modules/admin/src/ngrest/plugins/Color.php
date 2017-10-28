<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Color Wheel Plugin.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Color extends Plugin
{
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return [
            $this->createTag('span', null, ['style' => 'background-color: {{' . $ngModel .' }}; margin-right:5px; border-radius: 60%; padding:0px 8px;']),
            $this->createListTag($ngModel),
        ];
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-color', $id, $ngModel);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}

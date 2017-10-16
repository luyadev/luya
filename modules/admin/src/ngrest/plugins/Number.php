<?php

namespace luya\admin\ngrest\plugins;

use luya\helpers\ArrayHelper;
use luya\admin\ngrest\base\Plugin;

/**
 * Create a HTML5 number-tag.
 *
 * You can optional set a placeholder value to guide your users, or an init value which will be assigned
 * to the angular model if nothing is set.
 *
 * Example for default init Value
 *
 * ```php
 * 'sort_index' => ['number', 'initValue' => 1000],
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Number extends Plugin
{
    /**
     * @var integer The default init value for this field
     */
    public $initValue = 0;
    
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
        return $this->createFormTag('zaa-number', $id, $ngModel, ['placeholder' => $this->placeholder, 'initvalue' => $this->initValue]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    public function onAfterExpandFind($event)
    {
        $fieldValue = $event->sender->getAttribute($this->name);
        
        if (is_array($fieldValue)) {
            $event->sender->setAttribute($this->name, ArrayHelper::typeCast($fieldValue));
        } else {
            $event->sender->setAttribute($this->name, (int) $fieldValue);
        }
    }
    
    public function onAfterFind($event)
    {
        $event->sender->setAttribute($this->name, (int) $event->sender->getAttribute($this->name));
    }
}

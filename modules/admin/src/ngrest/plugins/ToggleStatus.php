<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Create toggle checkbox for a given field.
 *
 * You can change the value for true/false state by using the `trueValue` and `falseValue` porperties while confiure
 * the plugin for the given field.
 *
 * Example of using init Value preselected
 *
 * ```php
 * 'is_downloadable' => ['toggleStatus', 'initValue' => 1],
 * ```
 *
 * Now the checkbox is set the 1 by default (which is equals to $trueValue).
 *
 * @author nadar
 */
class ToggleStatus extends Plugin
{
    /**
     * @var string|integer The value which shoud be picked for angular true state
     */
    public $trueValue = 1;
    
    /**
     * @var string|integer The value which shoud be picked for angular false state
     */
    public $falseValue = 0;
    
    /**
     * @var string|integer The default value which should be assigned to the field on creation
     */
    public $initValue = 0;
    
    public function renderList($id, $ngModel)
    {
        return [
            $this->createTag('i', 'check', ['ng-if' => "$ngModel == $this->trueValue", 'class' => 'material-icons']),
            $this->createTag('i', 'close', ['ng-if' => "$ngModel == $this->falseValue", 'class' => 'material-icons']),
        ];
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-checkbox', $id, $ngModel, ['options' => json_encode(['true-value' => $this->trueValue, 'false-value' => $this->falseValue]), 'initvalue' => $this->initValue]);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}

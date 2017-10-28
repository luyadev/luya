<?php

namespace luya\admin\ngrest\plugins;

use luya\helpers\ArrayHelper;
use luya\admin\ngrest\base\Plugin;

/**
 * Decimal Input-Form field.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Decimal extends Plugin
{
    public $steps = 0.01;

    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-decimal', $id, $ngModel, ['options' => json_encode(['steps' => $this->steps ])]);
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
            $event->sender->setAttribute($this->name, (float) $fieldValue);
        }
    }
    
    public function onAfterFind($event)
    {
        $event->sender->setAttribute($this->name, (float) $event->sender->getAttribute($this->name));
    }
}

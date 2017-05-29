<?php

namespace luya\admin\ngrest\plugins;

use luya\helpers\StringHelper;
use luya\admin\ngrest\base\Plugin;

/**
 * Base class for select dropdowns via Array or Model.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Select extends Plugin
{
    public $initValue = 0;

    /**
     * Getter method for data array.
     * 
     * @return array
     */
    abstract public function getData();

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
        return $this->createFormTag('zaa-select', $id, $ngModel, ['initvalue' => $this->initValue, 'options' => $this->getServiceName('selectdata')]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }

    /**
     * @inheritdoc
     */
    public function serviceData($event)
    {
        return ['selectdata' => $this->data];
    }
    
    /**
     * @inheritdoc
     */
    public function onAfterListFind($event)
    {
        $value = StringHelper::typeCast($event->sender->getAttribute($this->name));
        foreach ($this->data as $item) {
            if (StringHelper::typeCast($item['value']) === $value) {
                $event->sender->setAttribute($this->name, $item['label']);
            }
        }
    }
}

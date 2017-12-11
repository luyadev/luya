<?php

namespace luya\admin\ngrest\plugins;

use luya\helpers\StringHelper;
use luya\admin\ngrest\base\Plugin;

/**
 * Base class for select dropdowns via Array or Model.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Select extends Plugin
{
    /**
     * @var integer|string If an init value is available which is matching with the select data, you can not reset the model to null. So initvalue ensures
     * that a value must be selected, or selects your initvalue by default.
     */
    public $initValue = 0;
    
    /**
     * @var string This value will be displayed in the ngrest list overview if the given value is empty(). In order to turn off this behavior set `emptyListValue` to false.
     */
    public $emptyListValue = "-";

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
        return ['selectdata' => $this->getData()];
    }
    
    /**
     * @inheritdoc
     */
    public function onAfterListFind($event)
    {
        $value = StringHelper::typeCast($event->sender->getAttribute($this->name));
        
        if ($this->emptyListValue && empty($value)) {
            $event->sender->setAttribute($this->name, $this->emptyListValue);
        } else {
            foreach ($this->getData() as $item) {
                if (StringHelper::typeCast($item['value']) === $value) {
                    $event->sender->setAttribute($this->name, $item['label']);
                }
            }
        }
    }
}

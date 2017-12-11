<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;
use luya\admin\base\TypesInterface;

/**
 * Sort Relation Plugin.
 *
 * The SortRelation provides the abilitie to select **multiple** items and to **sort** them. This plugin
 * does NOT work with a relation table, the selected data will be stored as json in a text field.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class SortRelation extends Plugin
{
    /**
     * Provide an array with data where key is the value and value the label.
     *
     * @return array
     */
    abstract public function getData();
    
    /**
     * @inheritdoc
     */
    public $i18nEmptyValue = [];
    
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
        return $this->createFormTag(TypesInterface::TYPE_SORT_RELATION_ARRAY, $id, $ngModel, ['options' => $this->getServiceName('sortrelationdata')]);
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
        return [
            'sortrelationdata' => $this->getData(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeSave($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            return false;
        }
    
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
        }
        
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeExpandFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
        }
        
        return true;
    }
}

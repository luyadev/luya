<?php

namespace admin\ngrest\base;

abstract class Plugin
{
    protected $id = null;

    protected $name = null;

    protected $alias = null;

    protected $ngModel = null;

    protected $i18n = null;

    private $_model = null;

    public function setModel($model)
    {
        $this->_model = $model;
    }

    public function getModel()
    {
        return $this->_model;
    }

    protected function createBaseElement($doc, $type)
    {
        $elmn = $doc->createElement($type);
        $elmn->setAttribute('fieldid', $this->id);
        $elmn->setAttribute('fieldname', $this->name);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('label', $this->alias);
        $elmn->setAttribute('i18n', $this->i18n);

        return $elmn;
    }

    public function setConfig($id, $name, $ngModel, $alias, $i18n)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ngModel = $ngModel;
        $this->alias = $alias;
        $this->i18n = $i18n;
    }

    public function getServiceName($name)
    {
        return 'service.'.$this->name.'.'.$name;
    }

    public function serviceData()
    {
        return false;
    }

    public function onBeforeCreate($fieldValue)
    {
        return false;
    }

    public function onAfterCreate($fieldValue)
    {
        return false;
    }

    public function onBeforeUpdate($fieldValue, $oldValue)
    {
        return false;
    }

    public function onAfterFind($fieldValue)
    {
        return false;
    }

    public function onAfterNgRestFind($fieldValue)
    {
        return false;
    }

    abstract public function renderList($doc);

    abstract public function renderCreate($doc);

    abstract public function renderUpdate($doc);
}

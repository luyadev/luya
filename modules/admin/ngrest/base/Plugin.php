<?php

namespace admin\ngrest\base;

abstract class Plugin
{
    protected $id = null;

    protected $name = null;

    protected $alias = null;

    protected $ngModel = null;

    protected $gridCols = null;
    
    private $_model = null;

    public function setModel($model)
    {
        $this->_model = $model;
    }

    public function getModel()
    {
        return $this->_model;
    }

    public function setConfig($id, $name, $ngModel, $alias, $gridCols)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ngModel = $ngModel;
        $this->alias = $alias;
        $this->gridCols = $gridCols;
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

    public function onAfterList($fieldValue)
    {
        return false;
    }
    
    public function onAfterNgRestList($fieldValue)
    {
        return false;
    }

    abstract public function renderList($doc);

    abstract public function renderCreate($doc);

    abstract public function renderUpdate($doc);
}

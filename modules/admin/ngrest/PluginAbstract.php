<?php
namespace admin\ngrest;

abstract class PluginAbstract
{
    protected $id = null;

    protected $name = null;

    protected $alias = null;

    protected $ngModel = null;

    public function setConfig($id, $name, $ngModel, $alias)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ngModel = $ngModel;
        $this->alias = $alias;
    }

    abstract public function renderList($doc);

    abstract public function renderCreate($doc);

    abstract public function renderUpdate($doc);
}

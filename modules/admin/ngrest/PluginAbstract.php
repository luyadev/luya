<?php
namespace admin\ngrest;

abstract class PluginAbstract
{
    protected $config = [];

    protected $id = null;

    protected $name = null;

    protected $alias = null;

    protected $ngModel = null;

    public function setConfig($config)
    {
        $this->id = $config['id'];
        $this->name = $config['name'];
        $this->ngModel = $config['ngModel'];
        $this->alias = $config['alias'];
        $this->config = $config;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    abstract public function renderList($doc);

    abstract public function renderCreate($doc);

    abstract public function renderUpdate($doc);
}

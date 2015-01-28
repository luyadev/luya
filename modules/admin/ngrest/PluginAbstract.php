<?php
namespace admin\ngrest;

abstract class PluginAbstract
{
    protected $id = null;

    protected $name = null;

    protected $alias = null;

    protected $ngModel = null;

    public $options = [];

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }

        $this->init();
    }

    public function init()
    {
    }

    public function getOption($key)
    {
        return (isset($this->options[$key])) ? $this->options[$key] : false;
    }

    public function setOption($key, $value)
    {
        if (!$this->getOption($key)) {
            throw new \Exception("The requested set key does not exists in options list");
        }

        $this->options[$key] = $value;
    }

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

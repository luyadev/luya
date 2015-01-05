<?php
namespace luya\ngrest\plugins;

use luya\ngrest\PluginAbstract;

class Datepicker extends PluginAbstract
{
    protected $time = null;

    public function __construct($time)
    {
        $this->time = $time;
    }
}

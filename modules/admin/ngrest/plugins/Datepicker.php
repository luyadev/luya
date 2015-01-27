<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

class Datepicker extends PluginAbstract
{
    protected $time = null;

    public function __construct($time)
    {
        $this->time = $time;
    }
}

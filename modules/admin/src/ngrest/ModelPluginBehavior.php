<?php

namespace admin\ngrest;

use yii\base\Behavior;
use admin\ngrest\base\Model;

class ModelPluginBehavior extends Behavior
{
    public function events()
    {
        return [
            Model::EVENT_INIT => 'attachPluginEvents',
        ];
    }
    
    public function attachPluginEvents($event)
    {
        foreach ($this->owner->getNgRestConfig()->getPlugins() as $field => $plugin) {
            $plugin = NgRest::createPluginObject($plugin['type']['class'], 'NO-ID', $plugin['name'], $plugin['alias'], 'no-ng-model', $plugin['i18n'], $plugin['type']['args']);
            foreach ($plugin->events() as $on => $method) {
                $this->owner->on($on, [$plugin, $method]);
            }
        }
    }
}
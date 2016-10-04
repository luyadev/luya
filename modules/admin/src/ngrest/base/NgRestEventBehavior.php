<?php

namespace luya\admin\ngrest\base;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use luya\admin\ngrest\NgRest;

/**
 * NgRest Event Behavior which is attached to all NgRest Models
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NgRestEventBehavior extends Behavior
{
    public $plugins = null;
    
    private static $_pluginInstances = [];
    
    public function init()
    {
        parent::init();
        
        if ($this->plugins === null) {
            throw new InvalidConfigException("plugins property can not be empty.");
        }
    }
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'bindPluginEvents',
        ];
    }
    
    public function bindPluginEvents($event)
    {
        foreach ($this->plugins as $field => $plugin) {
            $plugin = self::findPluginInstance($field, $plugin, $event->sender->tableName());
            foreach ($plugin->events() as $on => $handler) {
                $event->sender->on($on, is_string($handler) ? [$plugin, $handler] : $handler);
            }
        }
    }
    
    private static function findPluginInstance($field, array $plugin, $tableName)
    {
        if (!isset(self::$_pluginInstances[$tableName][$field])) {
            self::$_pluginInstances[$tableName][$field] = NgRest::createPluginObject($plugin['type']['class'], $plugin['name'], $plugin['alias'], $plugin['i18n'], $plugin['type']['args']);
        }
    
        return self::$_pluginInstances[$tableName][$field];
    }
}

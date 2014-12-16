<?php
namespace luya\collection;

use yii\base\Component;
use yii\base\Event;

class Factory extends Component
{
    public static $instance = null;
    
    public static $objects = [];
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
    
        return self::$instance;
    }
    
    public static function instance($class)
    {
        $instance = self::getInstance();
    
        return $instance->setObject($class, $instance);
    }
    
    private function setObject($class, $instance)
    {    
        if ($this->hasObject($class)) {
            return $this->getObject($class);
        }
        $object = new $class($instance);

        $object->init();
        
        static::$objects[$class] = $object;
    
        return $object;
    }
    
    public function hasObject($class)
    {
        return (isset(static::$objects[$class]));
    }
    
    public function getObject($class)
    {
        return ($this->hasObject($class)) ? static::$objects[$class] : false;
    }
}
<?php
namespace luya\components;

/**
 * allow the ability to register different services of luya.
 *
 * @todo allow overriding object propertys?
 * @author nadar
 */
class LuyaComponents extends \yii\base\Component
{
    private $_components = [];
    
    public function has($componentName)
    {
        return array_key_exists($componentName, $this->_components);   
    }
    
    public function get($componentName)
    {
        if (!$this->has($componentName)) {
            throw new \Exception("the luya component '$componentName' is not registered yet.");
        }
        return $this->_components[$componentName];
    }
    
    public function set($componentName, $object)
    {
        if ($this->has($componentName)) {
            throw new \Exception("the luya componenent '$componentName' have been registered already.");
        }
        
        $this->_components[$componentName] = $object;
    }
    
    public function getStorage()
    {
        return $this->get('storage');
    }

    /**
     * @todo add instanceof interface
     * @param object $storage
     * @throws \Exception
     */
    public function setStorage($storage)
    {
        $this->set('storage', $storage);
    }
    
    /**
     * @todo add isntance of interface
     * @param object $auth
     */
    public function setAuth($auth)
    {
        $this->set('auth', $auth);
    }
    
    public function getAuth()
    {
        return $this->get('auth');
    }
}

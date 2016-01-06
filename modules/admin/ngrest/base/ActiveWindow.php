<?php

namespace admin\ngrest\base;

use luya\Exception;

/**
 * Base class for all ActiveWindow classes.
 * 
 * An ActiveWindow is basically a custom view which renders your data attached to a row in the CRUD grid table.
 * 
 * @author nadar
 */
abstract class ActiveWindow extends \yii\base\Object implements \admin\ngrest\interfaces\ActiveWindow
{
    public $config = null;

    public $module = null;

    private $_itemId = false;

    private $_view = null;

    private $_name = null;
    
    public function init()
    {
        parent::init();
        
        if ($this->module === null) {
            throw new Exception('The ActiveWindow property \'module\' of '.get_called_class().' can not be null. You have to defined the module in where the ActiveWindow is defined. For example `public $module = \'@admin\';`');
        }
    }
    
    public function getName()
    {
        if ($this->_name === null) {
            $this->_name = ((new \ReflectionClass($this))->getShortName());
        }
        
        return $this->_name;
    }
    
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new \admin\ngrest\base\View();
            $this->_view->id = strtolower($this->getName());
            $this->_view->module = $this->module;
        }

        return $this->_view;
    }

    public function render($name, array $params = [])
    {
        return $this->getView()->render($name, $params);
    }

    public function setItemId($itemId)
    {
        $this->_itemId = $itemId;
    }

    public function getItemId()
    {
        return $this->_itemId;
    }

    public function setConfig(array $activeWindowConfig)
    {
        $this->config = $activeWindowConfig;
    }

    public function response($success = true, $transport)
    {
        return ['error' => !$success, 'transport' => $transport];
    }
}

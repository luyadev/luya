<?php

namespace admin\ngrest\base;

use Yii;
use luya\Exception;
use admin\ngrest\base\ActiveWindowView;
use yii\helpers\StringHelper;

/**
 * Base class for all ActiveWindow classes.
 * 
 * An ActiveWindow is basically a custom view which renders your data attached to a row in the CRUD grid table.
 * 
 * @author nadar
 */
abstract class ActiveWindow extends \yii\base\Object implements \yii\base\ViewContextInterface
{
    private $_itemId = null;
    
    private $_view = null;
    
    private $_name = null;
    
    private $_hashName = null;
    
    protected $suffix = 'ActiveWindow';
    
    public $module = null;
    
    public $icon = 'extension';
    
    public $alias = false;
    
    public function init()
    {
        parent::init();
        
        if ($this->module === null) {
            throw new Exception('The ActiveWindow property \'module\' of '.get_called_class().' can not be null. You have to defined the module in where the ActiveWindow is defined. For example `public $module = \'@admin\';`');
        }
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
    
    public function getIcon()
    {
        return $this->icon;
    }
    
    public function getName()
    {
        if ($this->_name === null) {
            $this->_name = ((new \ReflectionClass($this))->getShortName());
        }
        
        return $this->_name;
    }
    
    public function getViewFolderName()
    {
        $name = $this->getName();
        
        if (StringHelper::endsWith($name, $this->suffix, false)) {
            $name = substr($name, 0, -(strlen($this->suffix)));
        }
        
        return strtolower($name);
    }
    
    public function getHashName()
    {
        if ($this->_hashName === null) {
            $this->_hashName = sha1($this->getName() . $this->icon . $this->alias);
        }
        
        return $this->_hashName;
    }
    
    public function getViewPath()
    {
        $module = $this->module;
        
        if (substr($module, 0, 1) !== '@') {
            $module = '@'.$module;
        }
        
        return implode(DIRECTORY_SEPARATOR, [Yii::getAlias($module), 'views', 'aws', $this->getViewFolderName()]);
    }
    
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new ActiveWindowView();
        }

        return $this->_view;
    }

    public function render($name, array $params = [])
    {
        return $this->getView()->render($name, $params, $this);
    }

    public function setItemId($itemId)
    {
        if (is_int($itemId)) {
            return $this->_itemId = $itemId;
        }
        
        throw new Exception("Unable to set active window item id, item id value must be integer.");
    }

    public function getItemId()
    {
        return $this->_itemId;
    }
    
    public function sendError($message)
    {
        return ['error' => true, 'message' => $message];
    }
    
    public function sendSuccess($message)
    {
        return ['error' => false, 'message' => $message];
    }
    
    /**
     * @todo remove
     * @param string $success
     * @param unknown $transport
     * @return multitype:boolean unknown
     */
    public function response($success = true, $transport)
    {
        return ['error' => !$success, 'transport' => $transport];
    }
}

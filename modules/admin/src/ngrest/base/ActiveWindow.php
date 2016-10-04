<?php

namespace luya\admin\ngrest\base;

use Yii;
use luya\Exception;
use yii\helpers\StringHelper;
use yii\base\ViewContextInterface;
use yii\base\Object;
use luya\admin\ngrest\base\ActiveWindowView;

/**
 * Base class for all ActiveWindow classes.
 *
 * An ActiveWindow is basically a custom view which renders your data attached to a row in the CRUD grid table.
 *
 * @property integer $itemId The Id of the item
 * @property \admin\ngrest\base\ActiveWindowView $view The view object
 * @property string $name Get the current Active Window Name
 * @property string $hashName Get an unique hased Active Window config name
 * @property \yii\db\ActiveRecordInterface $model The model evaluated by the `findOne` of the called ng rest model ActiveRecord.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
abstract class ActiveWindow extends Object implements ViewContextInterface
{
    /**
     * @var string $suffix The suffix to use for all classes
     */
    protected $suffix = 'ActiveWindow';
    
    /**
     * @var string The class name of the called class where the actice window is bound to.
     */
    public $ngRestModelClass = null;
    
    /**
     * @var the module name in where the active window context is loaded, in order to find view files.
     */
    public $module = null;
    
    /**
     * @var string Google-Icon name
     */
    public $icon = 'extension';
    
    /**
     * @var string Optional alias name for the ActiveWindow which renders the Crud-list-Button.
     */
    public $alias = false;

    private $_model = null;
    
    /**
     * @return \yii\db\ActiveRecordInterface Get the model of the called ngrest model ActiveRecord by it's itemId.
     */
    public function getModel()
    {
        if ($this->_model === null && $this->ngRestModelClass !== null) {
            $this->_model = call_user_func_array([$this->ngRestModelClass, 'findOne'], [$this->itemId]);
        }
        
        return $this->_model;
    }
    
    /**
     * Initliazier
     *
     * {@inheritDoc}
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        parent::init();
        
        if ($this->module === null) {
            throw new Exception('The ActiveWindow property \'module\' of '.get_called_class().' can not be null. You have to defined the module in where the ActiveWindow is defined. For example `public $module = \'@admin\';`');
        }
    }
    
    /**
     * Get the alias for this ActiveWIndow
     *
     * @return boolean|string
     */
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * Get the Google-Icons name for the current Active Window
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
    
    private $_name = null;
    
    /**
     * Get the ActiveWindow name based on its class short name.
     *
     * @return string
     */
    public function getName()
    {
        if ($this->_name === null) {
            $this->_name = ((new \ReflectionClass($this))->getShortName());
        }
        
        return $this->_name;
    }
    
    private $_viewFolderName = null;
    
    /**
     * Get the folder name where the views for this ActiveWindow should be stored.
     *
     * @return string
     */
    public function getViewFolderName()
    {
        if ($this->_viewFolderName === null) {
            $name = $this->getName();
            
            if (StringHelper::endsWith($name, $this->suffix, false)) {
                $name = substr($name, 0, -(strlen($this->suffix)));
            }
            
            $this->_viewFolderName = strtolower($name);
        }

        return $this->_viewFolderName;
    }
    
    private $_hashName = null;
    
    /**
     * Get a unique identifier hash based on the name and config values like icon and alias.
     *
     * @return string
     */
    public function getHashName()
    {
        if ($this->_hashName === null) {
            $this->_hashName = sha1($this->getName() . $this->icon . $this->alias);
        }
        
        return $this->_hashName;
    }
    
    /**
     * Return the view path for view context.
     *
     * {@inheritDoc}
     * @see \yii\base\ViewContextInterface::getViewPath()
     */
    public function getViewPath()
    {
        $module = $this->module;
        
        if (substr($module, 0, 1) !== '@') {
            $module = '@'.$module;
        }
        
        return implode(DIRECTORY_SEPARATOR, [Yii::getAlias($module), 'views', 'aws', $this->getViewFolderName()]);
    }
    
    private $_view = null;
    
    /**
     * Get the view object to render templates.
     *
     * @return \admin\ngrest\base\ActiveWindowView
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new ActiveWindowView();
        }

        return $this->_view;
    }

    /**
     * Render a template with its name and params based on the the view folder path.
     *
     * @param string $name The view file to render
     * @param array $params Optional params to assign into the view
     */
    public function render($name, array $params = [])
    {
        return $this->getView()->render($name, $params, $this);
    }

    private $_itemId = null;
    
    /**
     * Set the value of the item Id in where the active window context is initialized.
     *
     * @param intger $itemId The item id context
     * @throws Exception
     * @return intger
     */
    public function setItemId($itemId)
    {
        if (is_int($itemId)) {
            return $this->_itemId = $itemId;
        }
        
        throw new Exception("Unable to set active window item id, item id value must be integer.");
    }

    /**
     * Get the item id of the current active window context.
     *
     * @return intger|mixed
     */
    public function getItemId()
    {
        return $this->_itemId;
    }
    
    /**
     * Send an error message based on an array configuration for ajax responses.
     *
     * @param string $message The error Message
     * @param array $data Optional response data
     * @return array
     */
    public function sendError($message, array $data = [])
    {
        return ['error' => true, 'message' => $message, 'responseData' => $data];
    }
    
    /**
     * Send an success message based on an array configuration for ajax responses.
     *
     * @param string $message The success
     * @param array $data Optional response data
     * @return array
     */
    public function sendSuccess($message, array $data = [])
    {
        return ['error' => false, 'message' => $message, 'responseData' => $data];
    }
}

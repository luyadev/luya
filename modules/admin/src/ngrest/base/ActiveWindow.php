<?php

namespace luya\admin\ngrest\base;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\base\ViewContextInterface;
use luya\Exception;
use luya\helpers\Url;
use luya\helpers\FileHelper;
use yii\base\BaseObject;

/**
 * Base class for all ActiveWindow classes.
 *
 * An ActiveWindow is basically a custom view which renders your data attached to a row in the CRUD grid table.
 *
 * @property integer $itemId The Id of the item
 * @property \luya\admin\ngrest\base\ActiveWindowView $view The view object
 * @property string $name Get the current Active Window Name
 * @property string $hashName Get an unique hased Active Window config name
 * @property \luya\admin\ngrest\base\NgRestModel $model The model evaluated by the `findOne` of the called ng rest model ActiveRecord.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class ActiveWindow extends BaseObject implements ViewContextInterface, ActiveWindowInterface
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
     * @var string the module name in where the active window context is loaded, in order to find view files.
     */
    public $module;
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->module === null) {
            throw new Exception('The ActiveWindow property \'module\' of '.get_called_class().' can not be null. You have to defined the module in where the ActiveWindow is defined. For example `public $module = \'@admin\';`');
        }
    }
    
    private $_model;
    
    /**
     * Get the model object from where the Active Window is attached to.
     *
     * @return \luya\admin\ngrest\base\NgRestModel Get the model of the called ngrest model ActiveRecord by it's itemId.
     */
    public function getModel()
    {
        if ($this->_model === null && $this->ngRestModelClass !== null) {
            $this->_model = call_user_func_array([$this->ngRestModelClass, 'findOne'], $this->itemIds);
        }
        
        return $this->_model;
    }
    
    private $_configHash;
    
    /**
     * @inheritdoc
     */
    public function setConfigHash($hash)
    {
        $this->_configHash = $hash;
    }
    
    /**
     * Return the config hash name from the setter method.
     *
     * @return string
     */
    public function getConfigHash()
    {
        return $this->_configHash;
    }
    
    private $_activeWindowHash;
    
    /**
     * @inheritdoc
     */
    public function setActiveWindowHash($hash)
    {
        $this->_activeWindowHash = $hash;
    }
    
    /**
     * Get the active window hash from the setter method.
     * @return string
     */
    public function getActiveWindowHash()
    {
        return $this->_activeWindowHash;
    }
    
    /**
     * Create an absolute link to a callback.
     *
     * This method is commonly used when returing data directly to the browser, there for the abolute url to a callback is required. Only logged in
     * users can view the callback url, but there is no other security about callbacks.
     *
     * @param string $callback The name of the callback without the callback prefix exmaple `createPdf` if the callback is `callbackCreatePdf()`.
     * @return string The absolute url to the callback.
     */
    public function createCallbackUrl($callback)
    {
        return Url::to([
            '/admin/'.$this->model->ngRestApiEndpoint().'/active-window-callback',
            'activeWindowCallback' => Inflector::camel2id($callback),
            'ngrestConfigHash' => $this->getConfigHash(),
            'activeWindowHash' => $this->getActiveWindowHash(),
        ], true);
    }
    
    /**
     *
     * MIME: https://wiki.selfhtml.org/wiki/Referenz:MIME-Typen
     * @param string $fileName
     * @param string $mimeType
     * @param string $content
     * @return string
     */
    public function createDownloadableFileUrl($fileName, $mimeType, $content)
    {
        $key = uniqid(microtime().Inflector::slug($fileName), true);
        
        $store = FileHelper::writeFile('@runtime/'.$key.'.tmp', $content);
        
        $menu = Yii::$app->adminmenu->getApiDetail($this->model->ngRestApiEndpoint());
        
        $route = $menu['route'];
        $route = str_replace("/index", "/export-download", $route);
        
        if ($store) {
            Yii::$app->session->set('tempNgRestFileName', $fileName);
            Yii::$app->session->set('tempNgRestFileKey', $key);
            Yii::$app->session->set('tempNgRestFileMime', $mimeType);
            return Url::toRoute(['/'.$route, 'key' => base64_encode($key), 'time' => time()], true);
        }
        
        return false;
    }
    
    /**
     * If no label value is provided via getter/setter, this value is used.
     *
     * You can override this method in order to provide a default label for your Active Window.
     *
     * @return boolean|string
     */
    public function defaultLabel()
    {
        return false;
    }
    
    private $_label;
    
    /**
     * Setter method for the Label.
     *
     * @param string $label The active window label.
     */
    public function setLabel($label)
    {
        $this->_label = $label;
    }
    
    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return empty($this->_label) ? $this->defaultLabel() : $this->_label;
    }
    
    /**
     * If no extenion is set, this value is used.
     *
     * You can override this method in order to provide a default icon for your Active Window.
     *
     * @return string
     */
    public function defaultIcon()
    {
        return 'extension';
    }
    
    private $_icon;
    
    /**
     * Setter method for the icon
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->_icon = $icon;
    }
    
    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return empty($this->_icon) ? $this->defaultIcon() : $this->_icon;
    }
    
    private $_name;
    
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
    
    private $_viewFolderName;
    
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
    
    private $_hashName;
    
    /**
     * Get a unique identifier hash based on the name and config values like icon and label.
     *
     * @return string
     */
    public function getHashName()
    {
        if ($this->_hashName === null) {
            $this->_hashName = sha1(get_called_class());
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
    
    private $_view;
    
    /**
     * Get the view object to render templates.
     *
     * @return \luya\admin\ngrest\base\ActiveWindowView
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
     * @return string
     */
    public function render($name, array $params = [])
    {
        return $this->getView()->render($name, $params, $this);
    }

    private $_itemId;
    
    /**
     * @inheritdoc
     */
    public function setItemId($id)
    {
        $this->_itemId = $id;
    }

    /**
     * @inheritdoc
     */
    public function getItemId()
    {
        return $this->getIsCompositeItem() ? $this->getItemIds() : $this->getItemIds()[0];
    }
    
    /**
     * @inheritdoc
     */
    public function getIsCompositeItem()
    {
        return count($this->_itemId) > 1 ? true : false;
    }
    
    /**
     * @inheritdoc
     */
    public function getItemIds()
    {
        return explode(",", $this->_itemId);
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

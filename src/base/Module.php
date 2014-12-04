<?php
namespace luya\base;

use \Yii;
use \Exception;

/**
 * 
 * @author nadar
 */
class Module extends \yii\base\Module
{
    /**
     * 
     * @var array
     */
    public $requiredComponents = [];
    
    /**
     * 
     * @var array
     */
    public $assets = [];
    
    /**
     * Contains the apis for each module to provided them in the admin module. 
     * They represents the name of the api and the value represents the class.
     * 
     * ```php
     * [
     *     'api-admin-user' => 'admin\apis\UserController',
     *     'api-cms-cat' => 'admin\apis\CatController'
     * ]
     * ```
     * 
     * @var array
     */
    public static $apis = [];
    
    /**
     * 
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        // verify all the components
        foreach ($this->requiredComponents as $component) {
            if (!Yii::$app->has($component)) {
                throw new Exception(sprintf('The required component "%s" is not registered in the configuration file', $component));
            }
        }
    }
    
    /**
     * @todo [verify, 3.12.2014] can be removed, cause changed to alias autoloading in bootstrap
     */
    public function getModuleNamespace()
    {
        return str_replace("\Module", "", get_class($this));
    }
}

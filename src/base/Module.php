<?php

namespace luya\base;

use yii;
use Exception;

/**
 * @author nadar
 */
class Module extends \yii\base\Module
{
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
     * Contains all urlRules for this module. Can't provided in key value pairing for pattern<=>route. must be array containing
     * class name or array with pattern, route informations.
     *
     * @var array
     */
    public static $urlRules = [];

    /**
     * @var array
     */
    public $requiredComponents = [];

    /**
     * This variable is only available if your not in a context call. A context call would be if the cms renders the module.
     *
     * @var bool
     */
    public $useAppLayoutPath = true;

    /**
     * This variable can enable the view path defintion for all controllers inside this module.
     *
     * @var bool true = the view path inside this module will be used, false = the view path of the projects app view will be used.
     */
    public $controllerUseModuleViewPath = null;

    /**
     * each module can have assets, all module controllers will register those assets in the view.
     *
     * @var array Valid class name to the asset e.g. \app\assets\TestAsset
     */
    public $assets = [];

    /**
     * if this/the module is included via another module (parent module), the parent module will write its name inside the child modules
     * $context variable. For example the cms includes the news module, the context variable of news would have the value "cms".
     *
     * @var string
     */
    public $context = null;

    /**
     * If a module is set via context it can store context options inside the child modules via an array.
     *
     * @var array
     */
    public $contextOptions = [];

    /**
     * @var unknown_type
     */
    public $moduleLayout = 'layout';

    /**
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

    public function getLayoutPath()
    {
        if ($this->useAppLayoutPath) {
            $this->setLayoutPath('@app/views/'.$this->id.'/layouts');
        }

        return parent::getLayoutPath();
    }

    /**
     * @todo rename the resolveControllerRoute
     * 
     * @param unknown $route
     * @return string
     */
    public function findControllerRoute($route)
    {
        $xp = explode('/', $route);
        foreach ($xp as $k => $v) {
            if ($k == 0 && $v == $this->id) {
                unset($xp[$k]);
            }
            if (empty($v)) {
                unset($xp[$k]);
            }
        }

        if (empty($xp)) {
            $xp[] = $this->defaultRoute;
        }

        return implode('/', $xp);
    }

    public function setContext($name)
    {
        $this->context = $name;
    }

    /*
    public function getContext()
    {
        return $this->context;
    }
    */

    public function setContextOptions(array $options)
    {
        $this->contextOptions = $options;
    }

    public function getContextOptions()
    {
        return $this->contextOptions;
    }

    /**
     * Returns the luya componenets config.
     *
     * ```
     * return [
     *     'storage' => new \admin\components\Storage();
     * ];
     * ```
     */
    public function getLuyaComponents()
    {
        return [];
    }

    /**
     * The import method will be called from exec/import command.
     *
     * @return void|string
     */
    public function import(\luya\commands\ExecutableController $exec)
    {
        return false;
    }

    /**
     * returns "luya\base" for example.
     *
     * @return string
     */
    public function getNamespace()
    {
        return implode('\\', array_slice(explode('\\', get_class($this)), 0, -1));
    }
}

<?php

namespace luya\base;

use yii;
use Exception;
use luya\helpers\FileHelper;
use yii\helpers\Inflector;
use luya\console\interfaces\ImportControllerInterface;
use yii\base\InvalidParamException;

/**
 * Base Module class for all LUYA Modules.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Module extends \yii\base\Module
{
    /**
     * @var array Contains the apis for each module to provided them in the admin module. They represents
     *            the name of the api and the value represents the class. Example value:
     *
     * ```php
     * [
     *     'api-admin-user' => 'admin\apis\UserController',
     *     'api-cms-navcontainer' => 'admin\apis\NavContainerController'
     * ]
     * ```
     */
    public $apis = [];

    /**
     * @var array An array with Tag class names to inject into the tag parser on luya boot, where key is the identifier and value the create object conifg:
     * 
     * ```php
     * [
     *     'link' => 'luya\cms\tags\LinkTag',
     *     'file' => ['class' => 'luya\admin\tags\FileTag'],
     * ]
     * ```
     * 
     * As by default the yii2 configurable object you can also pass properties to your tag object in order to configure them.
     */
    public $tags = [];
    
    /**
     * @var array Contains all urlRules for this module. Can't provided in key value pairing for pattern<=>route
     *            must be array containing class name or array with pattern, route informations.
     */
    public $urlRules = [];

    /**
     * @var array An array containing all components which should be registered for the current module. If
     *            the component does not exists an Exception will be thrown.
     */
    public $requiredComponents = [];

    /**
     * @var bool Defines the location of the layout file whether in the @app namespace or a module:
     *
     * - true = looking for layout file in `@app/views/<ID>/layouts`.
     * - false = looking for layout file in `@module/views/layouts/`.
     *
     * This variable is only available if your not in a context call. A context call would be if the cms renders the module.
     */
    public $useAppLayoutPath = true;
    
    /**
     * @var bool Define the location of the view files inside the controller actions
     *
     * - true = the view path of the @app/views
     * - false = the view path of the @modulename/views
     *
     */
    public $useAppViewPath = false;
    
    /**
     * @var string if this/the module is included via another module (parent module), the parent module will write its
     * name inside the child modules $context variable. For example the cms includes the news module, the context variable
     * of news would have the value "cms".
     */
    public $context = null;

    /**
     * @var string The default name of the moduleLayout
     */
    public $moduleLayout = 'layout';
    
    /**
     * @var array Add translations for your module, all translation array must have the keys "prefix", "basePath" and "fileMap"
     * For example:
     *
     * ```php
     * $this->translations = [
     *     ['prefix' => 'luya*', 'basePath' => '@luya/messages', 'fileMap' => ['luya/admin' => 'admin.php']],
     * ],
     * ```
     *
     * To use this translation run or createa a static helper method in your module.php
     *
     * ```php
     * Yii::t('luya/admin', 'MyVariableInAdminPhp');
     * ```
     * @since 1.0.0-beta3
     */
    public $translations = [];

    /**
     * The Luya-Module initializer is looking for defined requiredComponents.
     *
     * @throws \Exception
     *
     * @see \yii\base\Module::init()
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
        $this->registerTranslations();
    }
    
    /**
     * register the translation service for luya
     */
    private function registerTranslations()
    {
        foreach ($this->translations as $translation) {
            Yii::$app->i18n->translations[$translation['prefix']] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => $translation['basePath'],
                'fileMap' => $translation['fileMap'],
            ];
        }
    }

    /**
     * Override the default implementation of Yii's getLayoutPath(). If the property `$useAppLayoutPath` is true,.
     *
     * the *@app* namespace views will be looked up for view files
     *
     * @return string;
     *
     * @see \yii\base\Module::getLayoutPath()
     */
    public function getLayoutPath()
    {
        if ($this->useAppLayoutPath) {
            $this->setLayoutPath('@app/views/'.$this->id.'/layouts');
        }

        return parent::getLayoutPath();
    }

    /**
     * Extract the current module from the route and return the new resolved route.
     *
     * @param string $route Route to resolve, e.g. `admin/default/index`
     *
     * @return string
     */
    public function resolveRoute($route)
    {
        $routeParts = explode('/', $route);
        foreach ($routeParts as $k => $v) {
            if (($k == 0 && $v == $this->id) || (empty($v))) {
                unset($routeParts[$k]);
            }
        }
        if (count($routeParts) == 0) {
            return $this->defaultRoute;
        }

        return implode('/', $routeParts);
    }

    /**
     * register a component to the application. id => definition. All components will be registered during bootstrap process.
     *
     * @return array:
     */
    public function registerComponents()
    {
        return [];
    }

    /**
     * Define a last of importer class with an array or run code directily with the import() method.
     *
     * @param ImportControllerInterface $importer
     * @return boolean|array
     */
    public function import(ImportControllerInterface $importer)
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
    
    /**
     * Returns all controller files of this module from the `getControllerPath()` folder, where the key is the reusable
     * id of this controller and value the file on the server.
     *
     * @return array Returns an array where the key is the controller id and value the original file.
     * @since 1.0.0-beta5
     */
    public function getControllerFiles()
    {
        try { // https://github.com/yiisoft/yii2/blob/master/framework/base/Module.php#L233
            $files = [];
            foreach (FileHelper::findFiles($this->controllerPath) as $file) {
                $value = ltrim(str_replace([$this->controllerPath, 'Controller.php'], '', $file), '/');
                $files[Inflector::camel2id($value)] = $file;
            }
            return $files;
        } catch (InvalidParamException $e) {
            return [];
        };
    }
}

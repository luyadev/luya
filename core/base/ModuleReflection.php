<?php

namespace luya\base;

use Yii;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;
use yii\base\Object;
use luya\web\Request;
use luya\web\UrlManager;

/**
 * Run any route inside the provided module.
 *
 * In order to run a module reflection route You have to instantiate the module via the Yii::createObject method
 *
 * ```php
 * $reflection = Yii::createObject(['class' => ModuleReflection::className(), 'module' => $module]);
 * ```
 *
 * Now you can pass optional parameters before the run process, for example to define what controller action you may run:
 *
 * ```php
 * $reflection->defaultRoute("my-controller", "the-action", ['param1' => 'foo']);
 * ```
 *
 * Now in order to return the content of the modules route execute the run method:
 *
 * ```php
 * $content = $reflection->run();
 * ```
 *
 * @property \luya\base\Module $module The module where the route should be run from.
 * @property string $suffix The suffix which should be used to attach to the url rules.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ModuleReflection extends Object
{
    /**
     * @var \luya\web\Request Request object from DI-Container.
     */
    public $request = null;

    /**
     * @var \luya\web\UrlManager UrlManager object from DI-Container.
     */
    public $urlManager = null;
    
    /**
     * @var \yii\base\Controller|null The controller paramter is null until the [[run()]] method has been applied.
     */
    public $controller = null;

    private $_defaultRoute = null;

    /**
     * Class constructor in order to consum from DI Container.
     *
     * @param Request $request
     * @param UrlManager $urlManager
     * @param array $config
     */
    public function __construct(Request $request, UrlManager $urlManager, array $config = [])
    {
        $this->request = $request;
        $this->urlManager = $urlManager;
        parent::__construct($config);
    }

    /**
     *
     * {@inheritDoc}
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        if ($this->module === null) {
            throw new InvalidConfigException('The module attribute is required and can not be null.');
        }
        
        // add the module specific url rules to the url manager
        $this->urlManager->addRules($this->module->urlRules, true);
    }

    private $_module = null;
    
    /**
     * Setter for the module property.
     *
     * @param Module $module
     */
    public function setModule(Module $module)
    {
        $this->_module = $module;
    }
    
    /**
     * Getter for the module property.
     *
     * @return \luya\base\Module
     */
    public function getModule()
    {
        return $this->_module;
    }
    
    private $_suffix = null;
    
    /**
     * Setter for the suffix property.
     *
     * @param string $suffix
     */
    public function setSuffix($suffix)
    {
        $this->_suffix = $suffix;
        $this->request->setPathInfo(implode('/', [$this->module->id, $suffix]));
    }

    /**
     * Getter for the suffix property.
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->_suffix;
    }

    /**
     * Determine the default route based on current defaultRoutes or parsedRequested by the UrlManager.
     *
     * @return array
     */
    public function getRequestRoute()
    {
        if ($this->_defaultRoute !== null && empty($this->getSuffix())) {
            $array = $this->_defaultRoute;
        } else {
            // parse request against urlManager
            $route = $this->urlManager->parseRequest($this->request);
            // return human readable array
            $array = [
                'route' => $route[0],
                'args' => $route[1],
            ];
        }
        // resolve the current route by the module
        $array['route'] = $this->module->resolveRoute($array['route']);
        // overload args if none defined with massiv get assigment
        if (count($array['args']) === 0) {
            /**
             * issue: https://github.com/zephir/luya/issues/754
             *
             * 01.02.2016: we have to remove the get param overloading, otherwhise we can not guarnte
             * to re generate the current url rule. Have to verify why in which case this was needed.
             *
             * original: $array['args'] = $this->request->get();
             * new: do not overload: $array['args'] = [];
             */
            $array['args'] = [];
        }

        return $array;
    }

    /**
     * Inject a defaultRoute.
     *
     * @param string $controller
     * @param string $action
     * @param array $args
     */
    public function defaultRoute($controller, $action = null, array $args = [])
    {
        $this->_defaultRoute = [
            'route' => implode('/', [$this->module->id, $controller, (empty($action)) ? 'index' : $action]),
            'args' => $args,
        ];
    }
    
    /**
     * Returns the url rule parameters which are taken from the requested route.
     *
     * @return array
     */
    public function getUrlRule()
    {
        $request = $this->getRequestRoute();
        
        return [
            'module' => $this->module->id,
            'route' => $this->module->id . '/' . $request['route'],
            'params' => $request['args'],
        ];
    }

    /**
     * Run the route based on the values.
     *
     * @return string|\yii\web\Response The response of the action, can be either a string or an object from response.
     * @throws NotFoundHttpException
     */
    public function run()
    {
        // request route
        $requestRoute = $this->getRequestRoute();
        // create controller object
        $controller = $this->module->createController($requestRoute['route']);
        // throw error if the requests request does not returns a valid controller object
        if (!isset($controller[0]) && !is_object($controller[0])) {
            throw new NotFoundHttpException(sprintf("Unable to create controller '%s' for module '%s'.", $requestRoute['route'], $this->module->id));
        }
        
        Yii::info('LUYA module run module "'.$this->module->id.'" route ' . $requestRoute['route'], __METHOD__);
        
        /**
         * issue: https://github.com/zephir/luya/issues/754
         *
         * As the route resolving should not contain empty argument list we overload the $requertRoute['args'] if they are empty
         * with the whole get params
         */
        if (empty($requestRoute['args'])) {
            $requestRoute['args'] = $this->request->get();
        }
        
        $this->controller = $controller[0];
        
        // run the action on the provided controller object
        return $this->controller->runAction($controller[1], $requestRoute['args']);
    }
}

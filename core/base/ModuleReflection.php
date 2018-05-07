<?php

namespace luya\base;

use Yii;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;
use luya\web\Request;
use luya\web\UrlManager;
use yii\base\BaseObject;
use luya\web\Controller;

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
 * @since 1.0.0
 */
class ModuleReflection extends BaseObject
{
    /**
     * @var \luya\web\Request Request object from DI-Container.
     */
    public $request;

    /**
     * @var \luya\web\UrlManager UrlManager object from DI-Container.
     */
    public $urlManager;
    
    /**
     * @var \yii\base\Controller|null The controller paramter is null until the [[run()]] method has been applied.
     */
    public $controller;

    private $_defaultRoute;

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
     * @inheritdoc
     */
    public function init()
    {
        if ($this->module === null) {
            throw new InvalidConfigException('The module attribute is required and can not be null.');
        }
        
        // add the module specific url rules to the url manager
        $this->urlManager->addRules($this->module->urlRules, true);
    }

    private $_module;
    
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
    
    private $_suffix;
    
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
    
    private $_requestRoute;

    /**
     * Determine the default route based on current defaultRoutes or parsedRequested by the UrlManager.
     *
     * @return array
     */
    public function getRequestRoute()
    {
        if ($this->_requestRoute !== null) {
            return $this->_requestRoute;
        }
        
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
             * issue: https://github.com/luyadev/luya/issues/754
             *
             * 01.02.2016: we have to remove the get param overloading, otherwhise we can not guarnte
             * to re generate the current url rule. Have to verify why in which case this was needed.
             *
             * original: $array['args'] = $this->request->get();
             * new: do not overload: $array['args'] = [];
             */
            $array['args'] = [];
        }
        
        /**
         * issue: https://github.com/luyadev/luya/issues/754
         *
         * As the route resolving should not contain empty argument list we overload the $requertRoute['args'] if they are empty
         * with the whole get params
         */
        if (empty($array['args'])) {
            $array['args'] = $this->request->get();
        }
        
        // @see https://github.com/luyadev/luya/issues/1267
        if ($this->_defaultRoute !== null) {
            $array['args'] = array_merge($this->_defaultRoute['args'], $array['args']);
        }

        $this->_requestRoute = $array;
        
        return $array;
    }

    /**
     * Setter method for the requested route
     * @param string $route
     * @param array $args
     */
    public function setRequestRoute($route, array $args = [])
    {
        $this->_requestRoute = ['route' => $route, 'args' => $args];
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
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $requestRoute = $this->getRequestRoute();
        // create controller object
        $controller = $this->module->createController($requestRoute['route']);
        // throw error if the requests request does not returns a valid controller object
        if (!isset($controller[0]) && !is_object($controller[0])) {
            throw new NotFoundHttpException(sprintf("Unable to create controller '%s' for module '%s'.", $requestRoute['route'], $this->module->id));
        }
        
        Yii::info('LUYA module run module "'.$this->module->id.'" route ' . $requestRoute['route'], __METHOD__);
        
        $this->controller = $controller[0];
        $originalController = Yii::$app->controller;
        
        /**
         * Override the current application controller in order to ensure current() url handling which is used
         * for relativ urls/rules.
         *
         * @see https://github.com/luyadev/luya/issues/1730
         */
        $this->controller->on(Controller::EVENT_BEFORE_ACTION, function ($event) {
            Yii::$app->controller = $this->controller;
        });
        /**
         * Restore the original controller instance after rendering.
         *
         * @see https://github.com/luyadev/luya/issues/1768
         */
        $this->controller->on(Controller::EVENT_AFTER_ACTION, function ($event) use ($originalController) {
            Yii::$app->controller = $originalController;
        });
        
        // run the action on the provided controller object
        return $this->controller->runAction($controller[1], $requestRoute['args']);
    }
}

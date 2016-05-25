<?php

namespace luya\base;

use Yii;
use Exception;
use yii\base\InvalidConfigException;

/**
 * Run any route inside the provided module.
 * 
 * @author nadar
 */
class ModuleReflection extends \yii\base\Object
{
    public $module = null;

    public $request = null;

    public $urlManager = null;
    
    public $controller = null;

    private $_defaultRoute = null;

    private $_suffix = null;

    public function __construct(\luya\web\Request $request, \luya\web\UrlManager $urlManager, array $config = [])
    {
        $this->request = $request;
        $this->urlManager = $urlManager;
        // parent object 
        parent::__construct($config);
    }

    public function init()
    {
        if ($this->module === null) {
            throw new Exception('Error, no module object has been provided.');
        }
        // add the module specific url rules to the url manager
        $this->urlManager->addRules($this->module->urlRules, true);
    }

    public function setSuffix($suffix)
    {
        $this->_suffix = $suffix;
        $this->request->setPathInfo(implode('/', [$this->module->id, $suffix]));
    }

    public function getSuffix()
    {
        return $this->_suffix;
    }

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

    public function defaultRoute($controller, $action = null, array $args = [])
    {
        $this->_defaultRoute = [
            'route' => implode('/', [$this->module->id, $controller, (empty($action)) ? 'index' : $action]),
            'args' => $args,
        ];
    }
    
    public function getUrlRule()
    {
        $request = $this->getRequestRoute();
        
        return [
            'module' => $this->module->id,
            'route' => $this->module->id . '/' . $request['route'],
            'params' => $request['args'],
        ];
    }

    public function run()
    {
        // request route
        $requestRoute = $this->getRequestRoute();
        // create controller object
        $controller = $this->module->createController($requestRoute['route']);
        // throw error if the requests request does not returns a valid controller object
        if (!isset($controller[0]) && !is_object($controller[0])) {
            throw new InvalidConfigException(sprintf("Unable to create controller '%s' for module '%s'.", $requestRoute['route'], $this->module->id));
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

<?php

namespace luya\base;

use Yii;
use Exception;

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
            throw new Exception("Error, no module object has been provided.");
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
        if ($this->_defaultRoute !== null && empty($this->suffix)) {
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
            $array['args'] = $this->request->get();
        }
        return $array;
    }
    
    public function defaultRoute($controller, $action = 'index', array $args = [])
    {
        $this->_defaultRoute = [
            'route' => implode('/', [$this->module->id, $controller, $action]),
            'args' => $args,
        ];
    }
    
    public function run()
    {
        // request route
        $requestRoute = $this->requestRoute;
        // see if request array is correct
        if (!isset($requestRoute['route']) || !isset($requestRoute['args'])) {
            throw new Exception('The provide request array does not contain route or arg keys.');
        }
        // create controller object
        $controller = $this->module->createController($requestRoute['route']);
        // throw error if the requests request does not returns a valid controller object
        if (!isset($controller[0]) && !is_object($controller[0])) {
            throw new Exception(sprintf("Unable to create controller for route '%s' and  arguments '%s'", $requestRoute['route'], print_r($requestRoute['args'], true)));
        }
        // run the action on the provided controller object
        return $controller[0]->runAction($controller[1], $requestRoute['args']);
    }
}

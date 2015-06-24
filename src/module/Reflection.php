<?php

namespace luya\module;

use luya\base\Module;

/**
 * @author nadar
 */
class Reflection 
{
    public $module = null;
    
    private $_request = null;
    
    private $_urlManager = null;
    
    private $_context = [];
    
    private $_suffix = null;
    
    private $_initRun = null;
    
    /**
	 * @todo use  \yii::$app->request or create new request object? (bugs?)
	 */
    public function __construct(Module $module)
    {
        $this->module = $module;
        $this->_request = new \yii\web\Request();
        $this->_urlManager = new \luya\components\UrlManager();
        $this->_urlManager->addRules($module->urlRules, true);
    }
    
    public function setModuleSuffix($suffix)
    {
        $this->_suffix = $suffix;
        $this->_request->setPathInfo(implode("/", [$this->module->id, $suffix]));
    }
    
    public function setInitRun($controller, $action, array $args = [])
    {
        $this->_initRun = [
            "controller" => $controller,
            "action" => $action,
            "args" => $args
        ];
    }
    
    public function getRequestResponse()
    {
        if ($this->_initRun !== null && empty($this->_suffix)) {
            return [
                'route' => implode("/", [$this->module->id, $this->_initRun['controller'], $this->_initRun['action']]),
                'args' => $this->_initRun['args']
            ];
        }
        $array = $this->_urlManager->parseRequest($this->_request);
        
        return [
            'route' => $array[0],
            'args' => $array[1],
        ];
    }
    
    public function getContext()
    {
        return $this->_context;
    }
    
    public function responseContent()
    {
        $request = $this->getRequestResponse();
        
        $request['route'] = $this->module->findControllerRoute($request['route']);
        
        $controller = $this->module->createController($request['route']);

        $controllerObject = $controller[0];
        
        $action = $controllerObject->runAction($controller[1], $request['args']);
        
        foreach($controllerObject->propertyMap as $prop) {
            $this->context[$prop] = $controllerObject->$prop;
        }
        
        return $action;
    }
}
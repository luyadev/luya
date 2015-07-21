<?php

namespace cmsadmin\models;

class NavItemModule extends \cmsadmin\base\NavItemType
{
    public static function tableName()
    {
        return 'cms_nav_item_module';
    }

    public function rules()
    {
        return [
            [['module_name'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'updatetype' => ['module_name']
        ];
    }
    
    private $_module = null;

    private function getModule()
    {
        if ($this->_module !== null) {
            return $this->_module;
        }

        $module = $this->module_name;

        $this->_module = \yii::$app->getModule($module);
        $this->_module->setContext('cms');
        $this->_module->setContextOptions($this->getOptions());

        return $this->_module;
    }
    
    public function attributeLabels()
    {
        return [
            'module_name' => 'Modul Name',
        ];
    }

    /**
     * @todo: see if $pathAfterRoute could be available in the urlRules, otherwise display default
     * (non-PHPdoc)
     *
     * @see cmsadmin\base.NavItemType::getContent()
     */
    
    public function getContent()
    {
        $module = $this->getModule();
        
        $reflection = new \luya\module\Reflection($module);
        $reflection->setModuleSuffix($this->getOption('restString'));
        
        $response = $reflection->responseContent();
        
        return $response;
    }
    
    /*
    
    public function getContent()
    {
        // get the module name
        $module = $this->getModule();
        // class context restString (from outside)
        $pathAfterRoute = $this->getOption('restString');
        // fake the pathInfo based on the current request
        \yii::$app->request->setPathInfo($this->module_name.'/'.$pathAfterRoute);
        // create url manager
        $mgr = new \luya\components\UrlManager();
        // add all module urlRules
        $mgr->addRules($module::$urlRules, true);
        // parse request based on the fake pathInfo
        $rq = $mgr->parseRequest(\yii::$app->request);
        var_dump($rq);
        
        $args = $rq[1];
        $r = $module->findControllerRoute($rq[0]);
        
        $controller = $module->createController($r);

        $action = $controller[0]->runAction($controller[1], $args);

        $this->_context = [];

        foreach ($controller[0]->propertyMap as $prop) {
            $this->_context[$prop] = $controller[0]->$prop;
        }

        return $action;
    }
    */
    public function getHeaders()
    {
        return;
    }
}

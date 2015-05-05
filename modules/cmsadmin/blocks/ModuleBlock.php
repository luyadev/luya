<?php

namespace cmsadmin\blocks;

class ModuleBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'Module Integration';
    }
    
    public function config()
    {
        return [
            "vars" => [
                ["var" => "moduleName", "label" => "Module Name", "type" => "zaa-input-text"]
            ]  
        ];
    }
    
    public function extraVars()
    {
        return [
            'moduleContent' => $this->moduleContent($this->getVarValue('moduleName'))  
        ];
    }
    
    public function twigAdmin()
    {
        return '<p><i class="fa fa-terminal fa-2x"></i> Module Integration: <strong>{{ vars.moduleName }}</strong></p>';
    }
    
    public function twigFrontend()
    {
        return '{{ extras.moduleContent }}';
    }
    
    private function moduleContent($moduleName)
    {
        $module = \yii::$app->getModule($moduleName);
        $module->setContext('cms');
        $module->setContextOptions($this->getEnvOptions());
        $pathAfterRoute = $this->getEnvOption('restString');
        
        \yii::$app->request->setPathInfo($module->id.'/'.$pathAfterRoute);

        $mgr = new \luya\components\UrlManager();
        $mgr->addRules($module::$urlRules, true);
        $rq = $mgr->parseRequest(\yii::$app->request);
        $args = $rq[1];
        $r = $module->findControllerRoute($rq[0]);
        $controller = $module->createController($r);
        
        $action = $controller[0]->runAction($controller[1], $args);
        
        return $action;
        
    }
}
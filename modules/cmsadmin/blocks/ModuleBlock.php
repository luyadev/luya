<?php

namespace cmsadmin\blocks;

use Yii;

class ModuleBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';
    
    public function name()
    {
        return 'Modul';
    }

    public function icon()
    {
        return "mdi-social-share";
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'moduleName', 'label' => 'Module Name', 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                ['var' => 'moduleController', 'label' => 'Controller Name (ohne Controller suffix)', 'type' => 'zaa-text'],
                ['var' => 'moduleAction', 'label' => 'Action Name (ohne action prefix)', 'type' => 'zaa-text'],
                ['var' => 'moduleActionArgs', 'label' => 'Action Arguments (json: {"var":"value"})', 'type' => 'zaa-text'],
            ]
        ];
    }

    public function extraVars()
    {
        return [
            'moduleContent' => $this->moduleContent($this->getVarValue('moduleName')),
        ];
    }

    public function twigAdmin()
    {
        return '{% if vars.moduleName is empty %}<span class="block__empty-text">Es wurde noch kein Modul ausgewählt.</span>{% else %}<p><i class="fa fa-terminal fa-2x"></i> Modulintegration: <strong>{{ vars.moduleName }}</strong></p>{% endif %}';
    }

    public function twigFrontend()
    {
        return '{{extras.moduleContent}}';
    }
    
    private function moduleContent($moduleName)
    {
        if (empty($moduleName)) {
            return null;
        }
        
        $ctrl = $this->getCfgValue('moduleController');
        $action = $this->getCfgValue('moduleAction');
        $actionArgs = json_decode($this->getCfgValue('moduleActionArgs'), true);
        
        // get module
        $module = Yii::$app->getModule($moduleName);
        $module->setContext('cms');
        $module->setContextOptions($this->getEnvOptions());
        
        // start module reflection
        $reflection = new \luya\module\Reflection($module);
        $reflection->setModuleSuffix($this->getEnvOption('restString'));
        if ($ctrl && $action) {
            $reflection->setInitRun($ctrl, $action, $actionArgs);
        }
        
        $response = $reflection->responseContent();
        
        $context = $reflection->getContext();
        
        return $response;
    }

    /*
    private function moduleContent($moduleName)
    {
        if (empty($moduleName)) {
            return;
        }
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
    */
}

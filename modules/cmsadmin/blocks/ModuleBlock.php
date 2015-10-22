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
        return 'view_module';
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
            ],
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
        return '{% if vars.moduleName is empty %}<span class="block__empty-text">Es wurde noch kein Modul ausgewählt.</span>{% else %}<p><i class="material-icons">developer_board</i> Modulintegration: <strong>{{ vars.moduleName }}</strong></p>{% endif %}';
    }

    public function twigFrontend()
    {
        return '{{extras.moduleContent}}';
    }

    private function moduleContent($moduleName)
    {
        if ($this->isAdminContext()) {
            return;
        }
        /*
         * in the admin context (means env options are empty) we do not have to render the module!
         */
        if (empty($moduleName) || count($this->getEnvOptions()) === 0) {
            return;
        }

        $ctrl = $this->getCfgValue('moduleController');
        $action = $this->getCfgValue('moduleAction');
        $actionArgs = json_decode($this->getCfgValue('moduleActionArgs'), true);
        if (empty($actionArgs)) {
            $actionArgs = [];
        }

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

        $reflectionRequest = $reflection->getRequestResponse();
        $response = $reflection->responseContent($reflectionRequest);

        return $response;
    }
}

<?php

namespace cmsadmin\blocks;

use Yii;
use cmsadmin\Module;

class ModuleBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public function name()
    {
        return Module::t('block_module_name');
    }

    public function icon()
    {
        return 'view_module';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'moduleName', 'label' => Module::t('block_module_modulename_label'), 'type' => 'zaa-select', 'options' => $this->getModuleNames()],
            ],
            'cfgs' => [
                ['var' => 'moduleController', 'label' => Module::t('block_module_modulecontroller_label'), 'type' => 'zaa-text'],
                ['var' => 'moduleAction', 'label' => Module::t('block_module_moduleaction_label'), 'type' => 'zaa-text'],
                ['var' => 'moduleActionArgs', 'label' => Module::t('block_module_moduleactionargs_label'), 'type' => 'zaa-text'],
            ],
        ];
    }

    public function getModuleNames()
    {
        $data = [];
        foreach(Yii::$app->getFrontendModules() as $k => $f ) {
            $data[] = ['value' => $k, 'label' => $k];
        }
        return $data;
    }

    public function getFieldHelp()
    {
        return [
            'moduleName' => 'Es erscheinen alle Frontend Modulnamen, die in der Config hinterlegt sind.'
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
        return '{% if vars.moduleName is empty %}<span class="block__empty-text">' . Module::t('block_module_no_module') . '</span>{% else %}<p><i class="material-icons">developer_board</i> ' . Module::t('block_module_integration') . ': <strong>{{ vars.moduleName }}</strong></p>{% endif %}';
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
        $module->context = 'cms';
        //$module->setContextOptions($this->getEnvOptions());
        // start module reflection

        $reflection = \luya\helpers\ModuleHelper::reflectionObject($module);
        $reflection->suffix = $this->getEnvOption('restString');

        if ($ctrl && $action) {
            $reflection->defaultRoute($ctrl, $action, $actionArgs);
        }

        return $reflection->run();
    }
}

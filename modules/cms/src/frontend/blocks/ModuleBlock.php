<?php

namespace luya\cms\frontend\blocks;

use Yii;
use yii\web\Response;
use luya\cms\Exception;
use luya\cms\frontend\Module;
use luya\helpers\ModuleHelper;
use luya\cms\base\TwigBlock;
use luya\cms\frontend\blockgroups\DevelopmentGroup;

/**
 * Module integration Block to render controller and/or actions.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class ModuleBlock extends TwigBlock
{
    public $module = 'cms';

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
                ['var' => 'moduleController', 'label' => Module::t('block_module_modulecontroller_label'), 'type' => 'zaa-select', 'options' => $this->zaaSelectArrayOption($this->getControllerClasses())],
                ['var' => 'moduleAction', 'label' => Module::t('block_module_moduleaction_label'), 'type' => 'zaa-text'],
                ['var' => 'moduleActionArgs', 'label' => Module::t('block_module_moduleactionargs_label'), 'type' => 'zaa-text'],
            ],
        ];
    }
    
    public function getControllerClasses()
    {
        $moduleName = $this->getVarValue('moduleName', false);

        return (empty($moduleName) || !Yii::$app->hasModule($moduleName)) ? [] : Yii::$app->getModule($moduleName)->getControllerFiles();
    }

    public function getModuleNames()
    {
        $data = [];
        foreach (Yii::$app->getFrontendModules() as $k => $f) {
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
    
    public function getBlockGroup()
    {
        return DevelopmentGroup::className();
    }

    private function moduleContent($moduleName)
    {
        if ($this->isAdminContext() || empty($moduleName) || count($this->getEnvOptions()) === 0) {
            return;
        }
        
        if (!Yii::$app->hasModule($moduleName)) {
            return;
        }
        
        try {
            $ctrl = $this->getCfgValue('moduleController');
            $action = $this->getCfgValue('moduleAction', 'index');
            $actionArgs = json_decode($this->getCfgValue('moduleActionArgs'), true);
            if (empty($actionArgs)) {
                $actionArgs = [];
            }
    
            // get module
            $module = Yii::$app->getModule($moduleName);
            $module->context = 'cms';
            
            // start module reflection
            $reflection = ModuleHelper::reflectionObject($module);
            $reflection->suffix = $this->getEnvOption('restString');
    
            // if a controller has been defined we inject a custom starting route for the
            // module reflection object.
            if (!empty($ctrl)) {
                $reflection->defaultRoute($ctrl, $action, $actionArgs);
            }
    
            $response = $reflection->run();
            
            if ($response instanceof Response) {
                return Yii::$app->end(0, $response);
            }
            
            return $response;
        } catch (\Exception $err) {
            throw new Exception('Exception has been throwed in Module Block: ' . $err->getMessage(), 0, $err);
        }
    }
}

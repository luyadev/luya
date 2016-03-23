<?php

namespace cmsadmin\models;

use Yii;
use cms\Exception;

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

    private $_module = null;

    private function getModule()
    {
        if ($this->_module !== null) {
            return $this->_module;
        }

        $module = $this->module_name;

        if (!Yii::$app->hasModule($module)) {
            throw new Exception("The module '$module' does not exist in your module configuration list.");
        }
        
        $this->_module = Yii::$app->getModule($module);
        $this->_module->context = 'cms';
        /*
        $this->_module->setContext('cms');
        $this->_module->setContextOptions($this->getOptions());
        */
        return $this->_module;
    }

    public function attributeLabels()
    {
        return [
            'module_name' => \cmsadmin\Module::t('model_navitemmodule_module_name_label'),
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

        $reflection = \luya\helpers\ModuleHelper::reflectionObject($module);
        $reflection->suffix = $this->getOption('restString');

        $response = $reflection->run();
        
        Yii::$app->menu->setCurrentUrlRule($reflection->getUrlRule());
        
        return $response;
    }
}

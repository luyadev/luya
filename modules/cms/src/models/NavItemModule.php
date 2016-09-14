<?php

namespace luya\cms\models;

use Yii;
use luya\cms\Exception;
use luya\cms\base\NavItemTypeInterface;
use luya\cms\base\NavItemType;
use luya\cms\admin\Module;
use luya\base\ModuleReflection;

/**
 * Represents the type MODULE for a NavItem.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NavItemModule extends NavItemType implements NavItemTypeInterface
{
    /**
     * {@InheritDoc}
     * @see \luya\cms\base\NavItemType::getNumericType()
     */
    public static function getNummericType()
    {
        return NavItem::TYPE_MODULE;
    }
    
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
            'module_name' => Module::t('model_navitemmodule_module_name_label'),
        ];
    }

    private $_content = null;
    
    /**
     * @todo: see if $pathAfterRoute could be available in the urlRules, otherwise display default
     * (non-PHPdoc)
     *
     * @see luya\cms\base\NavItemType::getContent()
     */
    public function getContent()
    {
        if ($this->_content == null) {
            $module = $this->getModule();
            
            $reflection = Yii::createObject(['class' => ModuleReflection::className(), 'module' => $module]);
            $reflection->suffix = $this->getOption('restString');
            
            $this->_content = $reflection->run();
            
            $this->controller = $reflection->controller;
            
            Yii::$app->menu->setCurrentUrlRule($reflection->getUrlRule());
        }
        
        return $this->_content;
    }
}

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
        
        $reflectionRequest = $reflection->getRequestResponse();
        $response = $reflection->responseContent($reflectionRequest);
        
        return $response;
    }
    
    public function getHeaders()
    {
        return;
    }
}

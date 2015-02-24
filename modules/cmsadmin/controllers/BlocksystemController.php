<?php
namespace cmsadmin\controllers;

class BlocksystemController extends \admin\ngrest\base\Controller
{
    public $modelClass = 'cmsadmin\models\Block';
    
    public function getNgRestConfig()
    {
        $config = new \admin\ngrest\Config($this->getModelObject()->getNgRestApiEndpoint(), $this->getModelObject()->getNgRestPrimaryKey());
        
        $config->i18n($this->getModelObject()->getI18n());
        
        $config->list->field("class", "Klasse")->text();
        
        $config->update->copyFrom('list', ['id']);
        $config->create->copyFrom('list', ['id']);
        
        return $config;
    }
}

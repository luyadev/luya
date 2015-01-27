<?php
namespace cmsadmin\models;

class Cat extends \admin\ngrest\base\Model
{
    public $ngRestEndpoint = 'api-cms-cat';
    
    public function ngRestConfig($config)
    {
        $config->list->field("name", "Name")->text()->required();
        $config->list->field("default_nav_id", "Default-Nav-Id")->text()->required();
        $config->list->field("rewrite", "Rewrite")->text()->required();
        $config->list->field("id", "ID")->text();
        
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        
        return $config;
    }
    
    public static function tableName()
    {
        return 'cms_cat';
    }

    public function rules()
    {
        return [
            [['name', 'rewrite', 'default_nav_id'], 'required']
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'rewrite', 'default_nav_id'],
            'restupdate' => ['name', 'rewrite', 'default_nav_id']
        ];
    }
}

<?php
namespace cmsadmin\models;

class Layout extends \admin\ngrest\base\Model
{
    public $ngRestEndpoint = 'api-cms-layout';
    
    public function ngRestConfig($config)
    {
        $config->list->field("name", "Name")->text()->required();
        $config->list->field("json_config", "JSON Config")->ace();
        $config->list->field("view_file", "Twig Filename (*.twig)")->text()->required();
        
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        
        return $config;
    }
    
    public static function tableName()
    {
        return 'cms_layout';
    }

    public function rules()
    {
        return [
            [["name", "json_config", "view_file"], "required"]
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'json_config', 'view_file'],
            'restupdate' => ['name', 'json_config', 'view_file']
        ];
    }

    public function getJsonConfig($node = false)
    {
        $json = @json_decode($this->json_config, true);

        if (!$node) {
            return $json;
        }

        if (isset($json[$node])) {
            return $json[$node];
        }

        return [];
    }
}

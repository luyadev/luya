<?php

namespace luya\cms\models;

use yii\helpers\Json;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Layout Model for CMS-Layouts.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Layout extends NgRestModel
{
    public static function tableName()
    {
        return 'cms_layout';
    }
    
    public static function ngRestApiEndpoint()
    {
        return 'api-cms-layout';
    }
    
    public function rules()
    {
        return [
            [['name', 'json_config', 'view_file'], 'required'],
        ];
    }
    
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'json_config' => ['textarea', 'encoding' => false],
            'view_file' => 'text',
        ];
    }
    
    public function ngRestScopes()
    {
        return [
            ['list', ['name', 'json_config', 'view_file'], ],
            [['create', 'update'], ['name']],
        ];
    }

    
    public function getJsonConfig($node = false)
    {
        $json = Json::decode($this->json_config);

        if (!$node) {
            return $json;
        }

        if (isset($json[$node])) {
            return $json[$node];
        }

        return [];
    }
}

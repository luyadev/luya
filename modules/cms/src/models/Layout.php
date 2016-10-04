<?php

namespace luya\cms\models;

use yii\helpers\Json;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Layout Model for CMS-Layouts.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Layout extends NgRestModel
{
    public static function ngRestApiEndpoint()
    {
        return 'api-cms-layout';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text();
        $config->list->field('json_config', 'JSON Config')->textarea();
        $config->list->field('view_file', 'Twig Filename (*.twig)')->text();

        $config->create->copyFrom('list', ['id']);

        $config->update->copyFrom('list', ['id']);
        $config->update->field('json_config', 'JSON Konfiguration')->textarea();

        return $config;
    }

    public static function tableName()
    {
        return 'cms_layout';
    }

    public function rules()
    {
        return [
            [['name', 'json_config', 'view_file'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'json_config', 'view_file'],
            'restupdate' => ['name', 'json_config', 'view_file'],
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

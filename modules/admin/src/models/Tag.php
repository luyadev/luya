<?php

namespace luya\admin\models;

use luya\admin\ngrest\base\NgRestModel;

class Tag extends NgRestModel
{
    /* yii model properties */

    public static function tableName()
    {
        return 'admin_tag';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['id', 'name'],
            'restupdate' => ['id', 'name'],
        ];
    }

    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['name'];
    }

    public static function ngRestApiEndpoint()
    {
        return 'api-admin-tag';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text();
        $config->create->copyFrom('list');
        $config->update->copyFrom('list');
        $config->delete = true;

        return $config;
    }
}

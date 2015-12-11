<?php

namespace admin\models;

use admin\aws\TagActiveWindow;

class Tag extends \admin\ngrest\base\Model
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

    public function ngRestApiEndpoint()
    {
        return 'api-admin-tag';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text();
        $config->create->copyFrom('list');
        $config->update->copyFrom('list');
        $config->delete = true;

        $config->aw->register(new TagActiveWindow("admin_tag"), 'Tags');

        return $config;
    }
}

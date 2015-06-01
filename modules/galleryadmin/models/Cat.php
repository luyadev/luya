<?php

namespace galleryadmin\models;

class Cat extends \admin\ngrest\base\Model
{
    /* yii model properties */

    public static function tableName()
    {
        return 'gallery_cat';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title'],
            'restupdate' => ['title'],
        ];
    }

    /* ngrest model properties */

    public function ngRestApiEndpoint()
    {
        return 'api-gallery-cat';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('title', 'Name')->text()->required();
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        return $config;
    }
}
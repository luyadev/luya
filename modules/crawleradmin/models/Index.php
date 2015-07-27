<?php

namespace crawleradmin\models;

class Index extends \admin\ngrest\base\Model
{
    /* yii model properties */

    public static function tableName()
    {
        return 'crawler_index';
    }

    public function scenarios()
    {
        return [
            'default' => ['url', 'content', 'title', 'arguments_json', 'language_info', 'added_to_index', 'last_update'],
            'restcreate' => ['url', 'content', 'title', 'arguments_json', 'language_info'],
            'restupdate' => ['url', 'content', 'title', 'arguments_json', 'language_info'],
        ];
    }

    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['url', 'content', 'title', 'arguments_json', 'language_info'];
    }

    public function ngRestApiEndpoint()
    {
        return 'api-crawler-index';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('url', 'Url')->text();
        $config->list->field('title', 'Title')->text();
        $config->list->field('language_info', 'Language_info')->text();
        $config->list->field('content', 'Content')->textarea();
        $config->list->field('arguments_json', 'Arguments_json')->textarea();
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        return $config;
    }
}
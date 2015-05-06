<?php

namespace newsadmin\models;

class Tag extends \admin\ngrest\base\Model
{
    public $i18n = ['title'];

    public static function tableName()
    {
        return 'news_tag';
    }

    public function ngRestApiEndpoint()
    {
        return 'api-news-tag';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('title', 'Titel')->text()->required();

        $config->update->copyFrom('list', ['id']);
        $config->create->copyFrom('list', ['id']);

        return $config;
    }

    public function scenarios()
    {
        return [
           'restcreate' => ['title'],
           'restupdate' => ['title'],
       ];
    }
}

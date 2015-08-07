<?php

namespace newsadmin\models;

class Tag extends \admin\ngrest\base\Model
{
    public static function tableName()
    {
        return 'news_tag';
    }

    public function attributeLabel()
    {
        return ['title' => 'Tag-Name'];
    }

    public function rules()
    {
        return [['title', 'required', 'message' => 'Bitte geben Sie einen Tag-Namen ein.']];
    }

    public function scenarios()
    {
        return [
           'restcreate' => ['title'],
           'restupdate' => ['title'],
       ];
    }

    // ngrest

    public $i18n = ['title'];

    public function ngRestApiEndpoint()
    {
        return 'api-news-tag';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('title', 'Titel')->text();

        $config->update->copyFrom('list', ['id']);
        $config->create->copyFrom('list', ['id']);

        return $config;
    }

}

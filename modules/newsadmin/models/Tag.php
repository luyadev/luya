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
        return ['title' => newsadmin\Module::t('tag_title')];
    }

    public function ngrestAttributeTypes()
    {
        return [
            'title' => 'text',
        ];
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
        $this->ngRestConfigDefine($config, 'list', ['title']);

        $config->update->copyFrom('list', ['id']);
        $config->create->copyFrom('list', ['id']);

        return $config;
    }
}

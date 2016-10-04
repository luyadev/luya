<?php

namespace luya\news\models;

use luya\news\admin\Module;

class Tag extends \luya\admin\ngrest\base\NgRestModel
{
    public static function tableName()
    {
        return 'news_tag';
    }

    public function attributeLabel()
    {
        return ['title' => Module::t('tag_title')];
    }

    public function ngrestAttributeTypes()
    {
        return [
            'title' => 'text',
        ];
    }

    public function rules()
    {
        return [['title', 'required', 'message' => Module::t('tag_title_create_error')]];
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

    public static function ngRestApiEndpoint()
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

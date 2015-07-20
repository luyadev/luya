<?php

namespace admin\models;

class Lang extends \admin\ngrest\base\Model
{
    public function ngRestApiEndpoint()
    {
        return 'api-admin-lang';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text();
        $config->list->field('short_code', 'Kurz-Code')->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
    }

    public static function tableName()
    {
        return 'admin_lang';
    }

    public function rules()
    {
        return [
            [['name', 'short_code'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'short_code'],
            'restupdate' => ['name', 'short_code'],
        ];
    }

    public function beforeCreate()
    {
        $this->is_default = 0;
    }

    public static function getDefault()
    {
        return self::find()->where(['is_default' => 1])->asArray()->one();
    }
}

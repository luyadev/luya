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
    
    private static $_langInstanceQuery = null;
    
    public static function getQuery()
    {
        if (self::$_langInstanceQuery === null) {
            self::$_langInstanceQuery = Lang::find()->asArray()->all();
        }
        
        return self::$_langInstanceQuery;
    }
    
    private static $_langInstance = null;

    public static function getDefault()
    {
        if (self::$_langInstance === null) {
            self::$_langInstance = self::find()->where(['is_default' => 1])->asArray()->one();
        }
        
        return self::$_langInstance;
    }
}

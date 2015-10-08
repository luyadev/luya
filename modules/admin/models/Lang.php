<?php

namespace admin\models;

use Yii;

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

    public static function getLangIdByShortCode($shortCode)
    {
        $item = self::find()->select(['id'])->where(['short_code' => $shortCode])->one();

        return ($item) ? $item->id : false;
    }

    private static $_langInstanceQuery = null;

    public static function getQuery()
    {
        if (self::$_langInstanceQuery === null) {
            self::$_langInstanceQuery = self::find()->asArray()->indexBy('short_code')->all();
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

    public static function findActive()
    {
        $langShortCode = Yii::$app->composition->getKey('langShortCode');

        if (!$langShortCode) {
            return self::getDefault();
        }

        return self::find()->where(['short_code' => $langShortCode])->asArray()->one();
    }
}

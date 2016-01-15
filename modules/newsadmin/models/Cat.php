<?php

namespace newsadmin\models;
use newsadmin;

class Cat extends \admin\ngrest\base\Model
{
    public static function tableName()
    {
        return 'news_cat';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title'],
            'restupdate' => ['title'],
        ];
    }

    public function rules()
    {
        return [['title', 'required', 'message' => 'Bitte geben Sie einen Kategorienamen ein.']];
    }

    public function attributeLabels()
    {
        return ['title' => newsadmin\Module::t('cat_title')];
    }

    public function ngrestAttributeTypes()
    {
        return [
            'title' => 'text',
        ];
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
    }

    public function eventBeforeDelete($event)
    {
        $items = Article::find()->where(['cat_id' => $this->id])->all();

        if (count($items) > 0) {
            $this->addError('id', 'Diese Kategorie wird noch von einem oder mehreren Terminen benutzt und kann nicht gelöscht werden.');
            $event->isValid = false;

            return;
        }

        $event->isValid = true;
    }

    // ngrest

    public $i18n = ['title'];

    public function ngRestApiEndpoint()
    {
        return 'api-news-cat';
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['title']);

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $config->delete = true;

        return $config;
    }
}

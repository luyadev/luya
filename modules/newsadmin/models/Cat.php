<?php

namespace newsadmin\models;

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

    public function ngRestApiEndpoint()
    {
        return 'api-news-cat';
    }

    public function rules()
    {
        return [['title', 'required', 'message' => 'Bitte geben Sie einen Kategorienamen ein.']];
    }

    public function attributeLabels()
    {
        return ['title' => 'Kategoriename'];
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
            $this->addError('Diese Kategorie wird noch von einem oder mehreren Terminen benutzt und kann nicht gelöscht werden.');
            $event->isValid = false;
            return;
        }

        $event->isValid = true;
    }


    public function ngRestConfig($config)
    {
        $config->list->field('title', 'Kategoriename')->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $config->delete = true;

        return $config;
    }
}

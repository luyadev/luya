<?php

namespace galleryadmin\models;

class Cat extends \admin\ngrest\base\Model
{
    /* yii model properties */

    public static function tableName()
    {
        return 'gallery_cat';
    }

    public function rules()
    {
        return [
            ['title', 'required', 'message' => 'Bitte geben Sie einen Titel an.'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'cover_image_id', 'description'],
            'restupdate' => ['title', 'cover_image_id', 'description'],
        ];
    }

    public function attributeLabels()
    {
        return ['title' => 'Kategoriename'];
    }

    /* ngrest model properties */

    public function ngRestApiEndpoint()
    {
        return 'api-gallery-cat';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
    }

    public function eventBeforeDelete($event)
    {
        $items = Album::find()->where(['cat_id' => $this->id])->all();

        if (count($items) > 0) {
            $this->addError('Diese Kategorie wird noch von einem oder mehreren Alben benutzt und kann nicht gelöscht werden.');
            $event->isValid = false;
            return;
        }

        $event->isValid = true;
    }

    public function ngRestConfig($config)
    {
        //var_dump($config);
        $config->list->field('title', 'Kategoriename')->text();
        $config->list->field('description', 'Beschreibung')->text();


        $config->create->copyFrom('list', ['id']);
        $config->create->field('cover_image_id', 'Cover-Bild')->image();
        $config->update->copyFrom('create');

        $config->delete = true;

        return $config;
    }
}
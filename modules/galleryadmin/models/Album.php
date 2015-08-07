<?php

namespace galleryadmin\models;

class Album extends \admin\ngrest\base\Model
{
    public static function tableName()
    {
        return 'gallery_album';
    }

    public function ngRestApiEndpoint()
    {
        return 'api-gallery-album';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'description', 'cover_image_id', 'cat_id'],
            'restupdate' => ['title', 'description', 'cover_image_id', 'cat_id'],
        ];
    }

    public function rules()
    {
        return [
            ['cat_id', 'required', 'message' => 'Bitte wählen Sie eine Kategorie aus.'],
            ['title', 'required', 'message' => 'Bitte geben Sie einen Titel ein.'],
        ];
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
    }

    public function eventBeforeDelete()
    {
        // find all gallery_album_image references and delete them
        (new \yii\db\Query())->createCommand()->delete('gallery_album_image', 'album_id = :albumId', [':albumId' => $this->id])->execute();
    }

    public function getCategoryUrl()
    {
        $category = Cat::findOne($this->cat_id);
        return \luya\helpers\Url::to('gallery/alben/index', ['catId' => $category->id, 'title' => \yii\helpers\Inflector::slug($category->title)]);
    }

    public function getCategoryName()
    {
        $category = Cat::findOne($this->cat_id);
        return $category->title;
    }

    public function getDetailUrl($contextNavItemId = null)
    {
        if ($contextNavItemId) {
            return \luya\helpers\Url::toModule($contextNavItemId, 'gallery/album/index', ['albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
        }

        return \luya\helpers\Url::to('gallery/album/index', ['albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
    }

    public function images()
    {
        return (new \yii\db\Query())->from('gallery_album_image')->where(['album_id' => $this->id])->all();
    }

    public function ngRestConfig($config)
    {
        $config->aw->register(new \admin\aws\Gallery('gallery_album_image', 'image_id', 'album_id'), 'Bilder Hochladen &amp; Verwalten');

        $config->list->field('cat_id', 'Kategorie')->selectClass('\galleryadmin\models\Cat', 'id', 'title');
        $config->list->field('title', 'Titel')->text();
        $config->list->field('description', 'Beschreibung')->textarea();
        $config->list->field('cover_image_id', 'Cover-Bild')->image();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $config->delete = true;

        return $config;
    }

}

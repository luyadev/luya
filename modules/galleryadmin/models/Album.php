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

    public function ngRestConfig($config)
    {
        $config->aw->register(new \admin\aws\Gallery('gallery_album_image', 'image_id', 'album_id'), 'Bilder Hochladen &amp; Verwalten');

        $config->list->field('cat_id', 'Kategorie')->selectClass('\galleryadmin\models\Cat', 'id', 'title')->required();
        $config->list->field('title', 'Titel')->text()->required();
        $config->list->field('description', 'Beschreibung')->textarea();
        $config->list->field('cover_image_id', 'Cover-Bild')->image()->required();
        
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'description', 'cover_image_id', 'cat_id'],
            'restupdate' => ['title', 'description', 'cover_image_id', 'cat_id'],
        ];
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
}

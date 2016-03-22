<?php

namespace galleryadmin\models;

use galleryadmin\Module;

class Album extends \admin\ngrest\base\Model
{
    public static function tableName()
    {
        return 'gallery_album';
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
            ['cat_id', 'required', 'message' => Module::t('album_category_error')],
            ['title', 'required', 'message' => Module::t('album_title_create_error')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Module::t('album_title'),
            'description' => Module::t('album_description'),
            'cover_image_id' => Module::t('album_cover_image_id'),
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

        return \luya\helpers\Url::toManager('gallery/alben/index', ['catId' => $category->id, 'title' => \yii\helpers\Inflector::slug($category->title)]);
    }

    public function getCategoryName()
    {
        $category = Cat::findOne($this->cat_id);

        return $category->title;
    }

    public function getDetailUrl($contextNavItemId = null)
    {
        if ($contextNavItemId) {
            return \cms\helpers\Url::toMenuItem($contextNavItemId, 'gallery/album/index', ['albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
        }

        return \luya\helpers\Url::toManager('gallery/album/index', ['albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
    }

    public function images()
    {
        return (new \yii\db\Query())->from('gallery_album_image')->where(['album_id' => $this->id])->all();
    }

    // ngrest

    public $i18n = ['title', 'description'];

    public function ngRestApiEndpoint()
    {
        return 'api-gallery-album';
    }

    public function ngrestAttributeTypes()
    {
        return [
            'title' => 'text',
            'description' => 'textarea',
            'cover_image_id' => 'image',
        	'cat_id' => ['selectModel', 'modelClass' => Cat::className(), 'valueField' => 'id', 'labelField' => 'title'],
        ];
    }

    public function ngRestConfig($config)
    {
        $config->aw->load([
            'class' => 'admin\aws\Gallery',
            'refTableName' => 'gallery_album_image',
            'imageIdFieldName' => 'image_id',
            'refFieldName' => 'album_id',
            'alias' => Module::t('album_upload')
        ]);

        $this->ngRestConfigDefine($config, 'list', ['title', 'description', 'cover_image_id']);

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        $config->delete = true;

        return $config;
    }
}

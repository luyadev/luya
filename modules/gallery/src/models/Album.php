<?php

namespace luya\gallery\models;

use luya\gallery\admin\Module;

class Album extends \luya\admin\ngrest\base\NgRestModel
{
    public static function tableName()
    {
        return 'gallery_album';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'description', 'cover_image_id', 'cat_id', 'sort_index', 'is_highlight'],
            'restupdate' => ['title', 'description', 'cover_image_id', 'cat_id', 'sort_index', 'is_highlight'],
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
            'cat_id' => Module::t('album_cat_id'),
            'sort_index' => Module::t('album_sort_index'),
            'is_highlight' => Module::t('album_is_highlight'),
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
            return \luya\cms\helpers\Url::toMenuItem($contextNavItemId, 'gallery/album/index', ['albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
        }

        return \luya\helpers\Url::toManager('gallery/album/index', ['albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
    }

    public function images()
    {
        return (new \yii\db\Query())->from('gallery_album_image')->where(['album_id' => $this->id])->all();
    }

    // ngrest

    public $i18n = ['title', 'description'];

    public static function ngRestApiEndpoint()
    {
        return 'api-gallery-album';
    }

    public function ngRestAttributeTypes()
    {
        return [
            'title' => 'text',
            'description' => 'textarea',
            'cover_image_id' => 'image',
            'cat_id' => ['selectModel', 'modelClass' => Cat::className(), 'valueField' => 'id', 'labelField' => 'title'],
            'sort_index' => 'number',
            'is_highlight' => 'toggleStatus',
        ];
    }

    public function ngRestConfig($config)
    {
        $config->aw->load([
            'class' => 'luya\admin\aws\Gallery',
            'refTableName' => 'gallery_album_image',
            'imageIdFieldName' => 'image_id',
            'refFieldName' => 'album_id',
            'alias' => Module::t('album_upload')
        ]);

        $this->ngRestConfigDefine($config, 'list', ['title', 'sort_index', 'is_highlight', 'cover_image_id']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['cat_id', 'title', 'description', 'cover_image_id', 'sort_index', 'is_highlight']);

        $config->delete = true;

        return $config;
    }
}

<?php

namespace luya\news\models;

use luya\news\admin\Module;
use Yii;

class Article extends \luya\admin\ngrest\base\NgRestModel
{
    public static function tableName()
    {
        return 'news_article';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'eventBeforeInsert']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'eventBeforeUpdate']);
    }

    public function scenarios()
    {
        return [
           'restcreate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'tags', 'timestamp_create', 'timestamp_display_from', 'timestamp_display_until', 'is_display_limit', 'file_list'],
           'restupdate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'tags', 'timestamp_create', 'timestamp_display_from', 'timestamp_display_until', 'is_display_limit', 'file_list'],
       ];
    }

    public function rules()
    {
        return [
            [['cat_id', 'title', 'text'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Module::t('article_title'),
            'text' => Module::t('article_text'),
            'image_id' => Module::t('article_image_id'),
            'timestamp_create' => Module::t('article_timestamp_create'),
            'timestamp_display_from' => Module::t('article_timestamp_display_from'),
            'timestamp_display_until' => Module::t('article_timestamp_display_until'),
            'is_display_limit' => Module::t('article_is_display_limit'),
            'image_list' => Module::t('article_image_list'),
            'file_list' => Module::t('article_file_list'),
        ];
    }
    
    public function ngRestAttributeTypes()
    {
        return [
            'title' => 'text',
            'text' => 'textarea',
            'image_id' => 'image',
            'timestamp_create' => 'datetime',
            'timestamp_display_from' => 'date',
            'timestamp_display_until' => 'date',
            'is_display_limit' => 'toggleStatus',
            'image_list' => 'imageArray',
            'file_list' => 'fileArray',
            'cat_id' => ['selectModel', 'modelClass' => Cat::className(), 'valueField' => 'id', 'labelField' => 'title']
        ];
    }

    public function eventBeforeUpdate()
    {
        $this->update_user_id = Yii::$app->adminuser->getId();
        $this->timestamp_update = time();
    }

    public function eventBeforeInsert()
    {
        $this->create_user_id = Yii::$app->adminuser->getId();
        $this->update_user_id = Yii::$app->adminuser->getId();
        $this->timestamp_update = time();
        if (empty($this->timestamp_create)) {
            $this->timestamp_create = time();
        }
        if (empty($this->timestamp_display_from)) {
            $this->timestamp_display_from = time();
        }
    }

    public function getDetailUrl($contextNavItemId = null)
    {
        if ($contextNavItemId) {
            return \luya\cms\helpers\Url::toMenuItem($contextNavItemId, 'news/default/detail', ['id' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
        }

        return \luya\helpers\Url::toManager('news/default/detail', ['id' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
    }

    public static function getAvailableNews($limit = false)
    {
        $q = self::find()->where('timestamp_display_from <= :time', ['time' => time()])->orderBy('timestamp_display_from DESC');
        if ($limit) {
            $q->limit($limit);
        }
        $articles = $q->all();

        // filter if display time is limited
        foreach ($articles as $key => $article) {
            if ($article->is_display_limit) {
                if ($article->timestamp_display_until <= time()) {
                    unset($articles[$key]);
                }
            }
        }

        return $articles;
    }

    public function getCategoryName()
    {
        $catModel = Cat::find()->where(['id' => $this->cat_id])->one();

        return $catModel->title;
    }

    // ngrest

    public $tags = []; // cause of extra fields - will pe parsed trough the ngrest plugins.

    public $i18n = ['title', 'text', 'image_list'];

    public function extraFields()
    {
        return ['tags'];
    }

    public static function ngRestApiEndpoint()
    {
        return 'api-news-article';
    }
    
    public function ngRestAttributeGroups()
    {
        return [
            [['timestamp_create', 'timestamp_display_from', 'is_display_limit', 'timestamp_display_until'], 'Time', 'collapsed'],
            [['image_id', 'image_list', 'file_list'], 'Media'],
        ];
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['title', 'cat_id', 'timestamp_create', 'image_id']);

        $this->ngRestConfigDefine($config, ['create', 'update'], ['title', 'cat_id', 'text', 'timestamp_create', 'timestamp_display_from', 'is_display_limit', 'timestamp_display_until', 'image_id', 'image_list', 'file_list']);
        
        $config->delete = true;

        return $config;
    }
}

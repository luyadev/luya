<?php

namespace luya\news\models;

use luya\news\admin\Module;
use Yii;

/**
 * This is the model class for table "news_article".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $cat_id
 * @property string $image_id
 * @property string $image_list
 * @property string $file_list
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $timestamp_create
 * @property integer $timestamp_update
 * @property integer $timestamp_display_from
 * @property integer $timestamp_display_until
 * @property integer $is_deleted
 * @property integer $is_display_limit
 * @property string $teaser_text
 */
class Article extends \luya\admin\ngrest\base\NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_article';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'eventBeforeInsert']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'eventBeforeUpdate']);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
           'restcreate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'tags', 'timestamp_create', 'timestamp_display_from', 'timestamp_display_until', 'is_display_limit', 'file_list', 'teaser_text'],
           'restupdate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'tags', 'timestamp_create', 'timestamp_display_from', 'timestamp_display_until', 'is_display_limit', 'file_list', 'teaser_text'],
       ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['title', 'text', 'image_list', 'file_list', 'teaser_text'], 'string'],
            [['cat_id', 'create_user_id', 'update_user_id', 'timestamp_create', 'timestamp_update', 'timestamp_display_from', 'timestamp_display_until', 'is_deleted', 'is_display_limit'], 'integer'],
            [['image_id'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Module::t('article_title'),
            'text' => Module::t('article_text'),
            'teaser_text' => Module::t('teaser_text'),
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
            'teaser_text' => 'textarea',
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

    public $tags = [];

    public $i18n = ['title', 'text', 'teaser_text', 'image_list'];

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

        $this->ngRestConfigDefine($config, ['create', 'update'], ['cat_id', 'title', 'teaser_text', 'text', 'timestamp_create', 'timestamp_display_from', 'is_display_limit', 'timestamp_display_until', 'image_id', 'image_list', 'file_list']);
        
        $config->delete = true;

        return $config;
    }
}

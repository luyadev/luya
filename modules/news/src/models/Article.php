<?php

namespace luya\news\models;

use Yii;
use yii\helpers\Inflector;
use luya\helpers\Url;
use luya\news\admin\Module;
use luya\admin\aws\TagActiveWindow;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\traits\SoftDeleteTrait;
use luya\admin\traits\TagsTrait;

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
 * @property string $detailUrl Return the link to the detail url of a news item.
 * @author Basil Suter <basil@nadar.io>
 */
class Article extends NgRestModel
{
    use SoftDeleteTrait;
    use TagsTrait;
    
    public $i18n = ['title', 'text', 'teaser_text', 'image_list'];
    
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
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
           'restcreate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'timestamp_create', 'timestamp_display_from', 'timestamp_display_until', 'is_display_limit', 'file_list', 'teaser_text'],
           'restupdate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'timestamp_create', 'timestamp_display_from', 'timestamp_display_until', 'is_display_limit', 'file_list', 'teaser_text'],
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

    /**
     * @inheritdoc
     */
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
    
    /**
     * @inheritdoc
     */
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

    /**
     *
     * @return string
     */
    public function getDetailUrl()
    {
        return Url::toRoute(['/news/default/detail', 'id' => $this->id, 'title' => Inflector::slug($this->title)]);
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-news-article';
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeGroups()
    {
        return [
            [['timestamp_create', 'timestamp_display_from', 'is_display_limit', 'timestamp_display_until'], 'Time', 'collapsed'],
            [['image_id', 'image_list', 'file_list'], 'Media'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        $config->aw->load(['class' => TagActiveWindow::class]);
    
        $this->ngRestConfigDefine($config, 'list', ['cat_id', 'title', 'timestamp_create', 'image_id']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['cat_id', 'title', 'teaser_text', 'text', 'timestamp_create', 'timestamp_display_from', 'is_display_limit', 'timestamp_display_until', 'image_id', 'image_list', 'file_list']);
    
        $config->delete = true;
    
        return $config;
    }
    
    /**
     *
     * @param string $limit
     * @return unknown
     */
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

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Cat::class, ['id' => 'cat_id']);
    }
    
    /**
     * The cat name short getter.
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->cat->title;
    }
}

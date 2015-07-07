<?php

namespace newsadmin\models;

use Yii;

class Article extends \admin\ngrest\base\Model
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
           'restcreate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'tags', 'timestamp_display_from', 'timestamp_display_until', 'file_list'],
           'restupdate' => ['title', 'text', 'cat_id', 'image_id', 'image_list', 'tags', 'timestamp_display_from', 'timestamp_display_until', 'file_list'],
       ];
    }

    public function rules()
    {
        return [
            [['cat_id', 'title', 'text' ], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'cat_id' => 'Kategorie',
          'title' => 'Titel',
          'text' => 'Text',
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
        $this->timestamp_create = time();
        $this->timestamp_update = time();
        $this->timestamp_display_from = time();
    }

    public function getDetailUrl($contextNavItemId = null)
    {
        if ($contextNavItemId) {
            return \luya\helpers\Url::toModule($contextNavItemId, 'news/default/detail', ['id' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
        }

        return \luya\helpers\Url::to('news/default/detail', ['id' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
    }

    // ngrest

    public $tags = []; // cause of extra fields - will pe parsed trough the ngrest plugins.

    public $i18n = ['title', 'text'];

    public $extraFields = ['tags'];

    public function ngRestApiEndpoint()
    {
        return 'api-news-article';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('cat_id', 'Kategorie')->selectClass('\newsadmin\models\Cat', 'id', 'title');
        $config->list->field('title', 'Titel')->text();
        $config->list->field('timestamp_create', 'Datum')->date();

        $config->update->field('cat_id', 'Kategorie')->selectClass('\newsadmin\models\Cat', 'id', 'title');
        $config->update->field('title', 'Titel')->text()->required();
        $config->update->field('text', 'Text')->textarea()->required();
        $config->update->field('timestamp_create', 'News erstellt am:')->date();
        $config->update->field('timestamp_display_from', 'News anzeigen ab')->date();
        $config->update->field('timestamp_display_until', 'News anzeigen bis')->date();
        //$config->update->field('timestamp_display_until', 'News anzeigen bis')->date();
        $config->update->field('image_id', 'Bild')->image()->required();
        $config->update->field('image_list', 'Bild Liste')->imageArray();
        $config->update->field('file_list', 'Datei Liste')->fileArray();
        $config->update->extraField('tags', 'Tags')->checkboxRelation(\newsadmin\models\Tag::className(), 'news_article_tag', 'article_id', 'tag_id');
        
        $config->create->copyFrom('update', ["timestamp_display_until"]);

        return $config;
    }
}

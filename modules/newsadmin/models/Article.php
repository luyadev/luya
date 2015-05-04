<?php
namespace newsadmin\models;

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

    public function eventBeforeUpdate()
    {
        $this->update_user_id = \admin\Module::getAdminUserData()->id;
        $this->timestamp_update = time();
    }
    
    public function eventBeforeInsert()
    {
        $this->create_user_id = \admin\Module::getAdminUserData()->id;
        $this->update_user_id = \admin\Module::getAdminUserData()->id;
        $this->timestamp_create = time();
        $this->timestamp_update = time();
    }

    /*
    public function setTags($value)
    {
        $this->tags = $value;
        //$this->setRelation($value, "news_article_tag", "article_id", "tag_id");
    }

    public function getTags()
    {
        return $this->hasMany(\newsadmin\models\Tag::className(), ['id' => 'tag_id'])->viaTable('news_article_tag', ['article_id' => 'id']);
    }
    */

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
        $config->list->field("cat_id", "Kategorie")->selectClass('\newsadmin\models\Cat', 'id', 'title');
        $config->list->field("title", "Titel")->text()->required();
        $config->list->field("text", "Text")->textarea()->required();
        $config->list->field("timestamp_display_from", "News anzeigen ab")->datepicker();
        $config->list->field("timestamp_display_until", "News anzeigen bis")->datepicker();
        $config->list->field("image_id", "Bild")->image()->required();
        $config->list->field("image_list", "Bild Liste")->imageArray();
        $config->list->field("file_list", "Datei Liste")->fileArray();
        $config->list->extraField("tags", "Tags")->checkboxReleation(\newsadmin\models\Tag::className(), 'news_article_tag', 'article_id', 'tag_id');
        //$config->list->extraField("tags", "Tags")->checkboxReleation(['model' => \newsadmin\models\Tag::className(), 'labelField' => 'title']);
        
        $config->update->copyFrom('list', ['id']);
        $config->create->copyFrom('list', ['id']);

        return $config;
    }
}

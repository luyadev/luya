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
    }

    public function scenarios()
    {
        return [
           'restcreate' => ['title', 'text', 'image_id', 'timestamp_update'],
           'restupdate' => ['title', 'text', 'image_id', 'tags', 'timestamp_update'],
       ];
    }

    public function eventBeforeInsert()
    {
        $this->create_user_id = \admin\Module::getAdminUserData()->id;
        $this->timestamp_create = time();
    }

    public function setTags($value)
    {
        $this->setRelation($value, "news_article_tag", "article_id", "tag_id");
    }

    public function getTags()
    {
        return $this->hasMany(\newsadmin\models\Tag::className(), ['id' => 'tag_id'])->viaTable('news_article_tag', ['article_id' => 'id']);
    }

    // ngrest

    public $ngRestEndpoint = 'api-news-article';

    public $i18n = ['title', 'text'];

    public $extraFields = ['tags'];

    public function ngRestConfig($config)
    {
        $config->list->field("title", "Titel")->text()->required();
        $config->list->field("text", "Text")->textarea()->required();
        $config->list->field("timestamp_update", "Update Datum")->datepicker()->required();
        $config->list->field("image_id", "Bild")->image();

        $config->update->copyFrom('list', ['id']);
        $config->update->extraField("tags", "Tags")->checkboxReleation(['model' => \newsadmin\models\Tag::className(), 'labelField' => 'title']);

        $config->create->copyFrom('list', ['id']);

        return $config;
    }
}

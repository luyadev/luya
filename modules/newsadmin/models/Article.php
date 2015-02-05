<?php
namespace newsadmin\models;

class Article extends \admin\ngrest\base\Model
{
    public $ngRestEndpoint = 'api-news-article';
    
    public $i18n = ['title', 'text'];
    
    public static function tableName()
    {
        return 'news_article';
    }
    
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'onCreate']);
    }
    
    public function ngRestConfig($config)
    {
        $config->list->field("title", "Titel")->text()->required();
        $config->list->field("text", "Text")->textarea()->required();
        
        $config->update->copyFrom('list', ['id']);
        $config->create->copyFrom('list', ['id']);
        
        return $config;
    }
    
    public function scenarios()
    {
        return [
           'restcreate' => ['title', 'text'],
           'restupdate' => ['title', 'text'],
       ];
    }
   
    public function onCreate()
    {
        $this->create_user_id = \admin\Module::getAdminUserData()->id;
        $this->timestamp_create = time();
    }
}

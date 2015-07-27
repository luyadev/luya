<?php

namespace crawleradmin\models;

class BuilderIndex extends \admin\ngrest\base\Model
{
    /* yii model properties */

    public static function tableName()
    {
        return 'crawler_builder_index';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['url', 'content', 'title', 'arguments_json', 'language_info'],
            'restupdate' => ['url', 'content', 'title', 'arguments_json', 'language_info'],
            'default' => ['url', 'content', 'title', 'arguments_json', 'language_info'],
        ];
    }

    /* custom functions */
    
    public static function isIndexed($url)
    {
        $model = self::findOne(['url' => $url]);
        
        if ($model) {
            if ($model->crawled == 1) {
                return true;
            }
        }
        
        return false;
    }
    
    public static function findUrl($url)
    {
        return self::findOne(['url' => $url]);
    }
    
    public static function addToIndex($url, $title = null)
    {
        $model = self::findOne(['url' => $url]);
        
        if ($model) {
            return false;
        }
        
        $model = new self;
        $model->url = $url;
        $model->title = $title;
        $model->crawled = 0;
        return $model->insert();
    }
    
    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['url', 'content', 'title', 'arguments_json', 'language_info'];
    }

    public function ngRestApiEndpoint()
    {
        return 'api-crawler-builderindex';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('url', 'Url')->text();
        $config->list->field('title', 'Title')->text();
        $config->list->field('language_info', 'Language_info')->text();
        $config->list->field('content', 'Content')->textarea();
        $config->list->field('arguments_json', 'Arguments_json')->textarea();
        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);
        return $config;
    }
}
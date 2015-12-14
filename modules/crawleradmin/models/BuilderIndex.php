<?php

namespace crawleradmin\models;

class BuilderIndex extends \admin\ngrest\base\Model
{
    public function init()
    {
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'hashContent']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'hashContent']);
    }
    
    public function hashContent($event)
    {
        $this->content_hash = md5($this->content);
        $count = self::find()->where(['content_hash' => $this->content_hash])->andWhere(['!=', 'url', $this->url])->count();
        if ($count > 0) {
            $this->is_dublication = 1;
        } else {
            $this->is_dublication = 0;
        }
    }
    
    /* yii model properties */

    public static function tableName()
    {
        return 'crawler_builder_index';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['url', 'content', 'title', 'language_info'],
            'restupdate' => ['url', 'content', 'title', 'language_info'],
            'default' => ['url', 'content', 'title', 'language_info', 'content_hash', 'is_dublication'],
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

        $model = new self();
        $model->url = $url;
        $model->title = $title;
        $model->crawled = 0;

        return $model->insert();
    }

    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['url', 'content', 'title', 'language_info'];
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
        $config->update->copyFrom('list', ['id']);

        return $config;
    }
}

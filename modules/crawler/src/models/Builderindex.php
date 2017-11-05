<?php

namespace luya\crawler\models;

use luya\crawler\admin\Module;
use luya\helpers\StringHelper;

/**
 * Temporary Builder Index Model.
 *
 * The Builder Index is used while the crawl process. After a success crawl for the given website, the whole BuilderIndex
 * will be synced into the {{luya\crawler\models\Index}} model.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Builderindex extends \luya\admin\ngrest\base\NgRestModel
{
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'hashContent']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'hashContent']);
    }
    
    /* yii model properties */

    public static function tableName()
    {
        return 'crawler_builder_index';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['url', 'content', 'title', 'language_info', 'url_found_on_page', 'group'],
            'restupdate' => ['url', 'content', 'title', 'language_info', 'url_found_on_page', 'group'],
            'default' => ['url', 'content', 'title', 'language_info', 'content_hash', 'is_dublication', 'url_found_on_page', 'group', 'description'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'url' => Module::t('builderindex_url'),
            'title' => Module::t('builderindex_title'),
            'language_info' => Module::t('builderindex_language_info'),
            'content' => Module::t('builderindex_content'),
            'url_found_on_page' => Module::t('builderindex_url_found'),
        ];
    }
    
    /* ngrest model properties */
    
    public function genericSearchFields()
    {
        return ['url', 'content', 'title', 'language_info'];
    }
    
    public static function ngRestApiEndpoint()
    {
        return 'api-crawler-builderindex';
    }
    
    public function ngRestAttributeTypes()
    {
        return [
            'url' => 'text',
            'title' => 'text',
            'language_info' => 'text',
            'url_found_on_page' => 'text',
            'content' => 'textarea',
        ];
    }
    
    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['url', 'title', 'language_info', 'url_found_on_page']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['url', 'title', 'language_info', 'url_found_on_page', 'content']);
    
        return $config;
    }

    /* custom functions */

    public static function isIndexed($url)
    {
        $model = self::findOne(['url' => $url]);

        if ($model) {
            if ($model->crawled) {
                return true;
            }
        }

        return false;
    }

    public static function findUrl($url)
    {
        return self::findOne(['url' => $url]);
    }

    public static function addToIndex($url, $title = null, $urlFoundOnPage = null)
    {
        $model = self::findOne(['url' => $url]);

        if ($model) {
            return false;
        }

        $model = new self();
        $model->url = $url;
        $model->title = StringHelper::truncate($title, 197);
        $model->url_found_on_page = $urlFoundOnPage;
        $model->crawled = false;

        return $model->save(false);
    }

    public function hashContent($event)
    {
        $this->content_hash = md5($this->content);
        $count = self::find()->where(['content_hash' => $this->content_hash])->andWhere(['!=', 'url', $this->url])->count();
        if ($count > 0) {
            $this->is_dublication = true;
        } else {
            $this->is_dublication = false;
        }
    }
}

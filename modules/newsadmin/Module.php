<?php

namespace newsadmin;

use Yii;

class Module extends \luya\admin\base\Module
{
    public $isCoreModule = true;

    public $apis = [
        'api-news-article' => 'newsadmin\apis\ArticleController',
        'api-news-tag' => 'newsadmin\apis\TagController',
        'api-news-cat' => 'newsadmin\apis\CatController',
    ];

    public function getMenu()
    {
        return $this
        ->node(Module::t('news'), 'local_library')
            ->group(Module::t('news_administrate'))
                ->itemApi(Module::t('article'), 'newsadmin-article-index', 'edit', 'api-news-article')
                ->itemApi(Module::t('cat'), 'newsadmin-cat-index', 'bookmark_border', 'api-news-cat')
                ->itemApi(Module::t('tag'), 'newsadmin-tag-index', 'label_outline', 'api-news-tag')
        ->menu();
    }

    public $translations = [
        [
            'prefix' => 'newsadmin*',
            'basePath' => '@newsadmin/messages',
            'fileMap' => [
                'newsadmin' => 'newsadmin.php',
            ],
        ],
    ];

    public static function t($message, array $params = [])
    {
        return Yii::t('newsadmin', $message, $params, Yii::$app->luyaLanguage);
    }
}

<?php

namespace luya\news\admin;

use Yii;
use luya\admin\components\AdminMenuBuilder;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-news-article' => 'luya\news\admin\apis\ArticleController',
        'api-news-tag' => 'luya\news\admin\apis\TagController',
        'api-news-cat' => 'luya\news\admin\apis\CatController',
    ];

    public $translations = [
        [
            'prefix' => 'newsadmin*',
            'basePath' => '@newsadmin/messages',
            'fileMap' => [
                'newsadmin' => 'newsadmin.php',
            ],
        ],
    ];
    
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))
            ->node('news', 'local_library')
                ->group('news_administrate')
                    ->itemApi('article', 'newsadmin/article/index', 'edit', 'api-news-article')
                    ->itemApi('cat', 'newsadmin/cat/index', 'bookmark_border', 'api-news-cat')
                    ->itemApi('tag', 'newsadmin/tag/index', 'label_outline', 'api-news-tag');
    }

    public static function t($message, array $params = [])
    {
        return Yii::t('newsadmin', $message, $params, Yii::$app->luyaLanguage);
    }
}

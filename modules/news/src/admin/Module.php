<?php

namespace luya\news\admin;

use luya\admin\components\AdminMenuBuilder;

/**
 * News Admin Module.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-news-article' => 'luya\news\admin\apis\ArticleController',
        'api-news-tag' => 'luya\news\admin\apis\TagController',
        'api-news-cat' => 'luya\news\admin\apis\CatController',
    ];

    /**
     * @inheritdoc
     */
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))
            ->node('news', 'local_library')
                ->group('news_administrate')
                    ->itemApi('article', 'newsadmin/article/index', 'edit', 'api-news-article')
                    ->itemApi('cat', 'newsadmin/cat/index', 'bookmark_border', 'api-news-cat');
    }

    public static function onLoad()
    {
    	self::registerTranslation('newsadmin', '@newsadmin/messages', [
    		'newsadmin' => 'newsadmin.php',
    	]);
    }
    
    /**
     * Translat news messages.
     *
     * @param string $message
     * @param array $params
     * @return string
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('newsadmin', $message, $params);
    }
}

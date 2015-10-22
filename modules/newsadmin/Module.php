<?php

namespace newsadmin;

class Module extends \admin\base\Module
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
        ->node('News', 'local_library')
            ->group('Daten')
                ->itemApi('News Eintrag', 'newsadmin-article-index', 'edit', 'api-news-article')
                ->itemApi('Kategorien', 'newsadmin-cat-index', 'label_outline', 'api-news-cat')
                ->itemApi('Tags', 'newsadmin-tag-index', 'label_outline', 'api-news-tag')
        ->menu();
    }
}

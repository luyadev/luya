<?php

namespace newsadmin;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-news-article' => 'newsadmin\apis\ArticleController',
        'api-news-tag' => 'newsadmin\apis\TagController',
        'api-news-cat' => 'newsadmin\apis\CatController',
    ];

    public function getMenu()
    {
        return $this
        ->node('News', 'mdi-action-language')
            ->group('Daten')
                ->itemApi('News Eintrag', 'newsadmin-article-index', 'mdi-content-content-paste', 'api-news-article')
                ->itemApi('Kategorien', 'newsadmin-cat-index', 'mdi-action-view-headline', 'api-news-cat')
                ->itemApi('Tags', 'newsadmin-tag-index', 'mdi-action-label-outline', 'api-news-tag')
        ->menu();
    }
}

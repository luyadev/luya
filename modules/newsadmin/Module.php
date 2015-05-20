<?php

namespace newsadmin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-news-article' => 'newsadmin\apis\ArticleController',
        'api-news-tag' => 'newsadmin\apis\TagController',
        'api-news-cat' => 'newsadmin\apis\CatController',
    ];

    public function getMenu()
    {
        return $this
        ->node('Neuigkeiten', 'mdi-av-new-releases')
            ->group('Daten')
                ->itemApi('Artikel', 'newsadmin-article-index', 'fa-newspaper-o', 'api-news-article')
                ->itemApi('Tags', 'newsadmin-tag-index', 'fa-tags', 'api-news-tag')
                ->itemApi('Katgorien', 'newsadmin-cat-index', 'fa-list-alt', 'api-news-cat')
        ->menu();
    }

    /*
    public function getMenu()
    {
        $node = $this->menu->createNode('newsadmin', 'News', 'fa-newspaper-o');
        // create menu group
        $this->menu->createGroup($node, 'Daten', [
            // insert group items
            $this->menu->createItem("article", "Artikel", "newsadmin-article-index", "fa-newspaper-o"),
            $this->menu->createItem("tag", "Tags", "newsadmin-tag-index", "fa-tags"),
        ]);

        return $this->menu->get();
    }
    */
}

<?php
namespace newsadmin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-news-article' => 'newsadmin\apis\ArticleController',
    ];

    public function getMenu()
    {
        $node = $this->menu->createNode('newsadmin', 'News', 'fa-newspaper-o');
        // create menu group
        $this->menu->createGroup($node, 'Daten', [
            // insert group items
            $this->menu->createItem("article", "Artikel", "newsadmin-article-index", "fa-newspaper-o"),
        ]);

        return $this->menu->get();
    }
}

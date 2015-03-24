<?php
namespace newsadmin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-news-article' => 'newsadmin\apis\ArticleController',
        'api-news-tag' => 'newsadmin\apis\TagController',
    ];

    public function getMenu()
    {
        return $this
        ->node("News", "fa-newspaper-o")
            ->group("Daten")
                ->item("Artikel", "newsadmin-article-index", "fa-newspaper-o")
                ->item("Tags", "newsadmin-tag-index", "fa-tags")
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
    
    public function getAuthApis()
    {
        return [
            ['api' => 'api-news-article', 'alias' => 'Artikel'],
            ['api' => 'api-news-tag', 'alias' => 'Tags'],
        ];
    }
}

<?php

namespace galleryadmin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-gallery-album' => '\\galleryadmin\\apis\\AlbumController',
        'api-gallery-cat' => 'galleryadmin\apis\CatController',
    ];

    public function getMenu()
    {
        return $this->node('Gallerien', 'mdi-image-photo-album')
            ->group('Verwalten')
                ->itemApi('Alben', 'galleryadmin-album-index', 'fa-folder-open', 'api-gallery-album')
                ->itemApi('Kategorien', 'galleryadmin-cat-index', 'fa-folder-openl', 'api-gallery-cat')
        ->menu();
    }
}

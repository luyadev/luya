<?php

namespace galleryadmin;

class Module extends \admin\base\Module
{
    public $isCoreModule = true;

    public $apis = [
        'api-gallery-album' => '\\galleryadmin\\apis\\AlbumController',
        'api-gallery-cat' => 'galleryadmin\apis\CatController',
    ];

    public function getMenu()
    {
        return $this->node('Gallerien', 'photo_album')
            ->group('Verwalten')
                ->itemApi('Alben', 'galleryadmin-album-index', 'camera', 'api-gallery-album')
                ->itemApi('Kategorien', 'galleryadmin-cat-index', 'collections', 'api-gallery-cat')
        ->menu();
    }
}

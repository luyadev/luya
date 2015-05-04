<?php

namespace galleryadmin;

class Module extends \admin\base\Module
{
    public static $apis = [
        'api-gallery-album' => '\\galleryadmin\\apis\\AlbumController',  
    ];
    
    public function getMenu()
    {
        return $this->node('Gallery', 'fa-image')
            ->group('Verwalten')
                ->itemApi('Alben', 'galleryadmin-album-index', 'fa-folder-open', 'api-gallery-album')
        ->menu();
    }
    
    
}
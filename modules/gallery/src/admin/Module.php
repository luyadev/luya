<?php

namespace luya\gallery\admin;

use luya\admin\components\AdminMenuBuilder;

final class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-gallery-album' => 'luya\gallery\admin\apis\AlbumController',
        'api-gallery-cat' => 'luya\gallery\admin\apis\CatController',
    ];
    
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))->node('gallery', 'photo_album')
            ->group('gallery_administrate')
                ->itemApi('album', 'galleryadmin/album/index', 'camera', 'api-gallery-album')
                ->itemApi('cat', 'galleryadmin/cat/index', 'collections', 'api-gallery-cat');
    }

    public static function onLoad()
    {
    	self::registerTranslation('galleryadmin', '@galleryadmin/messages', [
    		'galleryadmin' => 'galleryadmin.php',
    	]);
    }
    
    public static function t($message, array $params = [])
    {
        return parent::baseT('galleryadmin', $message, $params);
    }
}

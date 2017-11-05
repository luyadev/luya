<?php

namespace luya\gallery\admin;

use luya\admin\components\AdminMenuBuilder;

/**
 * Gallery Admin Module.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Module extends \luya\admin\base\Module
{
    /**
     * @inheritdoc
     */
    public $apis = [
        'api-gallery-album' => 'luya\gallery\admin\apis\AlbumController',
        'api-gallery-cat' => 'luya\gallery\admin\apis\CatController',
    ];
    
    /**
     * @inheritdoc
     */
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))
            ->node('gallery', 'photo_album')
                ->group('gallery_administrate')
                    ->itemApi('album', 'galleryadmin/album/index', 'camera', 'api-gallery-album')
                    ->itemApi('cat', 'galleryadmin/cat/index', 'collections', 'api-gallery-cat');
    }

    /**
     * @inheritdoc
     */
    public static function onLoad()
    {
        self::registerTranslation('galleryadmin', '@galleryadmin/messages', [
            'galleryadmin' => 'galleryadmin.php',
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('galleryadmin', $message, $params);
    }
}

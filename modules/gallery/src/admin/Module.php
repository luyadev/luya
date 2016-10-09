<?php

namespace luya\gallery\admin;

use Yii;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-gallery-album' => 'luya\gallery\admin\apis\AlbumController',
        'api-gallery-cat' => 'luya\gallery\admin\apis\CatController',
    ];

    public function getMenu()
    {
        return $this->node('gallery', 'photo_album')
            ->group('gallery_administrate')
                ->itemApi('album', 'galleryadmin-album-index', 'camera', 'api-gallery-album')
                ->itemApi('cat', 'galleryadmin-cat-index', 'collections', 'api-gallery-cat')
        ->menu();
    }

    public $translations = [
        [
            'prefix' => 'galleryadmin*',
            'basePath' => '@galleryadmin/messages',
            'fileMap' => [
                'galleryadmin' => 'galleryadmin.php',
            ],
        ],
    ];

    public static function t($message, array $params = [])
    {
        return Yii::t('galleryadmin', $message, $params, Yii::$app->luyaLanguage);
    }
}

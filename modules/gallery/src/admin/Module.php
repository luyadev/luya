<?php

namespace luya\gallery\admin;

use Yii;
use luya\base\CoreModuleInterface;

class Module extends \luya\admin\base\Module implements CoreModuleInterface
{

    public $apis = [
        'api-gallery-album' => 'luya\gallery\admin\apis\AlbumController',
        'api-gallery-cat' => 'luya\gallery\admin\apis\CatController',
    ];

    public function getMenu()
    {
        return $this->node(Module::t('gallery'), 'photo_album')
            ->group(Module::t('gallery_administrate'))
                ->itemApi(Module::t('album'), 'galleryadmin-album-index', 'camera', 'api-gallery-album')
                ->itemApi(Module::t('cat'), 'galleryadmin-cat-index', 'collections', 'api-gallery-cat')
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

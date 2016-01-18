<?php

namespace crawleradmin;

use Yii;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-crawler-builderindex' => 'crawleradmin\apis\BuilderIndexController',
        'api-crawler-index' => 'crawleradmin\apis\IndexController',
    ];

    public function getMenu()
    {
        return $this->node(Module::t('crawler'), 'pageview')
            ->group(Module::t('crawler_indexing'))
                ->itemApi(Module::t('crawler_index'), 'crawleradmin-index-index', 'visibility', 'api-crawler-index')
                ->itemApi(Module::t('crawler_builderindex'), 'crawleradmin-builderindex-index', 'visibility_off', 'api-crawler-builderindex')
        ->menu();
    }

    public $translations = [
        [
            'prefix' => 'crawleradmin*',
            'basePath' => '@luya/messages',
            'fileMap' => [
                'crawleradmin' => 'crawleradmin.php',
            ],
        ],
    ];

    public static function t($message, array $params = [])
    {
        return Yii::t('crawleradmin', $message, $params, Yii::$app->luyaLanguage);
    }
}

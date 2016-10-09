<?php

namespace luya\crawler\admin;

use Yii;

class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-crawler-builderindex' => 'luya\crawler\admin\apis\BuilderindexController',
        'api-crawler-index' => 'luya\crawler\admin\apis\IndexController',
        'api-crawler-searchdata' => 'luya\crawler\admin\apis\SearchdataController',
    ];

    public function getMenu()
    {
        return $this->node('crawler', 'find_in_page')
            ->group('crawler_indexing')
                ->itemApi('crawler_index', 'crawleradmin-index-index', 'list', 'api-crawler-index')
                //->itemApi('crawler_builderindex'), 'crawleradmin-builderindex-index', 'visibility_off', 'api-crawler-builderindex')
            ->group('Anylatics')
            ->itemApi('Searchdata', 'crawleradmin-searchdata-index', 'label', 'api-crawler-searchdata')
        ->menu();
    }

    public $translations = [
        [
            'prefix' => 'crawleradmin*',
            'basePath' => '@crawleradmin/messages',
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

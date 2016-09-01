<?php

namespace luya\crawler\admin;

use Yii;
use luya\base\CoreModuleInterface;

class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    public $apis = [
        'api-crawler-builderindex' => 'luya\crawler\admin\apis\BuilderindexController',
        'api-crawler-index' => 'luya\crawler\admin\apis\IndexController',
        'api-crawler-searchdata' => 'luya\crawler\admin\apis\SearchdataController',
    ];

    public function getMenu()
    {
        return $this->node(Module::t('crawler'), 'find_in_page')
            ->group(Module::t('crawler_indexing'))
                ->itemApi(Module::t('crawler_index'), 'crawleradmin-index-index', 'list', 'api-crawler-index')
                //->itemApi(Module::t('crawler_builderindex'), 'crawleradmin-builderindex-index', 'visibility_off', 'api-crawler-builderindex')
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

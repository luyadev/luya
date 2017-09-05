<?php

namespace luya\crawler\admin;

use Yii;
use luya\admin\components\AdminMenuBuilder;

final class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-crawler-builderindex' => 'luya\crawler\admin\apis\BuilderindexController',
        'api-crawler-index' => 'luya\crawler\admin\apis\IndexController',
        'api-crawler-searchdata' => 'luya\crawler\admin\apis\SearchdataController',
    ];

    public static $translations = [
        [
            'prefix' => 'crawleradmin*',
            'basePath' => '@crawleradmin/messages',
            'fileMap' => [
                'crawleradmin' => 'crawleradmin.php',
            ],
        ],
    ];
    
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))->node('crawler', 'find_in_page')
        ->group('crawler_indexing')
        ->itemApi('crawler_index', 'crawleradmin/index/index', 'list', 'api-crawler-index')
        ->group('Anylatics')
        ->itemApi('Searchdata', 'crawleradmin/searchdata/index', 'label', 'api-crawler-searchdata');
    }
    
    public static function onLoad()
    {
    	self::registerTranslation('crawleradmin', static::staticBasePath() . ' /messages', [
    		'crawleradmin' => 'crawleradmin.php',
    	]);
    }

    public static function t($message, array $params = [])
    {
        return Yii::t('crawleradmin', $message, $params);
    }
}

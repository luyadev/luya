<?php

namespace luya\crawler\admin;

use luya\admin\components\AdminMenuBuilder;

/**
 * Crawler Admin Module.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
final class Module extends \luya\admin\base\Module
{
	/**
	 * @inheritdoc
	 */
    public $apis = [
        'api-crawler-builderindex' => 'luya\crawler\admin\apis\BuilderindexController',
        'api-crawler-index' => 'luya\crawler\admin\apis\IndexController',
        'api-crawler-searchdata' => 'luya\crawler\admin\apis\SearchdataController',
    ];
    
    /**
     * @inheritdoc
     */
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))->node('crawler', 'find_in_page')
        ->group('crawler_indexing')
        ->itemApi('crawler_index', 'crawleradmin/index/index', 'list', 'api-crawler-index')
        ->group('Anylatics')
        ->itemApi('Searchdata', 'crawleradmin/searchdata/index', 'label', 'api-crawler-searchdata');
    }
    
    /**
     * @inheritdoc
     */
    public static function onLoad()
    {
    	self::registerTranslation('crawleradmin', static::staticBasePath() . ' /messages', [
    		'crawleradmin' => 'crawleradmin.php',
    	]);
    }

    /**
     * @inheritdoc
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('crawleradmin', $message, $params);
    }
}

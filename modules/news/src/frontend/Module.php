<?php

namespace luya\news\frontend;

/**
 * News Frontend Module.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Module extends \luya\base\Module
{
    /**
     * @var boolean use the application view folder
     */
    public $useAppViewPath = true;

    /**
     * @var array The default order for the article overview in the index action for the news.
     * 
     * In order to read more about activeDataProvider defaultOrder: http://www.yiiframework.com/doc-2.0/yii-data-sort.html#$defaultOrder-detail
     */
    public $articleDefaultOrder = ['timestamp_create' => SORT_DESC];
    
    /**
     * @var integer Default number of pages.
     */
    public $articleDefaultPageSize = 10;
    
    /**
     * @var array The default order for the category article list in the category action for the news.
     *
     * In order to read more about activeDataProvider defaultOrder: http://www.yiiframework.com/doc-2.0/yii-data-sort.html#$defaultOrder-detail
     */
    public $categoryArticleDefaultOrder = ['timestamp_create' => SORT_DESC];
    
    /**
     * @var integer Default number of pages.
     */
    public $categoryArticleDefaultPageSize = 10;
    
    /**
     * @var array
     */
    public $urlRules = [
        ['pattern' => 'news/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
    ];
}

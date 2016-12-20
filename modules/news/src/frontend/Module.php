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
     * @var array
     */
    public $urlRules = [
        ['pattern' => 'news/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
    ];
}

<?php

namespace crawleradmin;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-crawler-builderindex' => 'crawleradmin\apis\BuilderIndexController',
        'api-crawler-index' => 'crawleradmin\apis\IndexController',
    ];
    
    public function getMenu()
    {
        return $this->node('Crawler', 'http://materializecss.com/icons.html')
        ->group('Daten')
        ->itemApi('Builder Index', 'crawleradmin-builderindex-index', 'http://materializecss.com/icons.html', 'api-crawler-builderindex')
        ->itemApi('Index', 'crawleradmin-index-index', 'http://materializecss.com/icons.html', 'api-crawler-index')
        
        ->menu();
    }
    
}
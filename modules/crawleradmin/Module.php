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
        return $this->node('Crawler', 'pageview')
            ->group('Indexierungen')
                ->itemApi('Seiten Index', 'crawleradmin-index-index', 'visibility', 'api-crawler-index')
                ->itemApi('Zwischenspeicher', 'crawleradmin-builderindex-index', 'visibility_off', 'api-crawler-builderindex')
        ->menu();
    }
}

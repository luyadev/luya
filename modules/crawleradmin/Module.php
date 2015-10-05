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
        return $this->node('Crawler', 'mdi-action-pageview')
            ->group('Indexierungen')
                ->itemApi('Seiten Index', 'crawleradmin-index-index', 'mdi-action-visibility', 'api-crawler-index')
                ->itemApi('Zwischenspeicher', 'crawleradmin-builderindex-index', 'mdi-action-visibility-off', 'api-crawler-builderindex')
        ->menu();
    }
}

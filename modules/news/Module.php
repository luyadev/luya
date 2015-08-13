<?php

namespace news;

class Module extends \luya\base\Module
{
    public $urlRules = [
        ['pattern' => 'news/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
    ];
}

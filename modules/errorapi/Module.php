<?php
namespace errorapi;

class Module extends \luya\base\Module
{
    public static $urlRules = [
        ['pattern' => 'errorapi/create', 'route' => 'errorapi/default/create'],
        ['pattern' => 'errorapi/resolve', 'route' => 'errorapi/default/resolve'],
    ];
}
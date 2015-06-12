<?php

namespace errorapi;

class Module extends \luya\base\Module
{
    public $recipient = null;
    
    public $slackEndpoint = null;
    
    public static $urlRules = [
        ['pattern' => 'errorapi/create', 'route' => 'errorapi/default/create'],
        ['pattern' => 'errorapi/resolve', 'route' => 'errorapi/default/resolve'],
    ];
}

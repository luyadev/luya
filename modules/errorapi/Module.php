<?php

namespace errorapi;

class Module extends \luya\base\Module
{
    public $isCoreModule = true;

    public $recipient = [];

    public $slackToken = null;
    
    public $slackChannel = '#luya';

    public $urlRules = [
        ['pattern' => 'errorapi/create', 'route' => 'errorapi/default/create'],
        ['pattern' => 'errorapi/resolve', 'route' => 'errorapi/default/resolve'],
    ];
}

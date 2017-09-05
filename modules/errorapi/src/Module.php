<?php

namespace luya\errorapi;

use Yii;
use luya\base\CoreModuleInterface;

final class Module extends \luya\base\Module implements CoreModuleInterface
{
    public $recipient = [];

    public $slackToken;
    
    public $slackChannel = '#luya';

    public $urlRules = [
        ['pattern' => 'errorapi/create', 'route' => 'errorapi/default/create'],
        ['pattern' => 'errorapi/resolve', 'route' => 'errorapi/default/resolve'],
    ];

    public static $translations = [
        [
            'prefix' => 'errorapi*',
            'basePath' => '@errorapi/messages',
            'fileMap' => [
                'errorapi' => 'errorapi.php',
            ],
        ],
    ];
    
    public static function onLoad()
    {
    	self::registerTranslation('errorapi', '@errorapi/messages', [
    		'errorapi' => 'errorapi.php',
    	]);
    }

    public static function t($message, array $params = [])
    {
        return parent::baseT('errorapi', $message, $params);
    }
}

<?php

namespace luya\errorapi;

use Yii;
use luya\base\CoreModuleInterface;

class Module extends \luya\base\Module implements CoreModuleInterface
{
    public $recipient = [];

    public $slackToken;
    
    public $slackChannel = '#luya';

    public $urlRules = [
        ['pattern' => 'errorapi/create', 'route' => 'errorapi/default/create'],
        ['pattern' => 'errorapi/resolve', 'route' => 'errorapi/default/resolve'],
    ];

    public $translations = [
        [
            'prefix' => 'errorapi*',
            'basePath' => '@errorapi/messages',
            'fileMap' => [
                'errorapi' => 'errorapi.php',
            ],
        ],
    ];

    public static function t($message, array $params = [])
    {
        return Yii::t('errorapi', $message, $params, Yii::$app->language);
    }
}

<?php

namespace errorapi;

use Yii;

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

    public $translations = [
        [
            'prefix' => 'errorapi*',
            'basePath' => '@luya/messages',
            'fileMap' => [
                'errorapi' => 'errorapi.php',
            ],
        ],
    ];

    public static function t($message, array $params = [])
    {
        return Yii::t('errorapi', $message, $params, Yii::$app->luyaLanguage);
    }
}

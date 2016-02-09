<?php

namespace luya;

use Yii;
use luya\components\UrlRule;

class Module extends \luya\base\Module
{
    /**
     * The current luya version.
     *
     * @link https://github.com/zephir/luya/blob/master/CHANGELOG.md
     *
     * @var string
     */
    const VERSION = '1.0.0-beta6-dev';

    /**
     * Default url behavior if luya is included. first rule which will be picked.
     *
     * @var array
     */
    public $urlRules = [
        ['class' => 'luya\components\UrlRule', 'position' => UrlRule::POSITION_LUYA],
    ];
    
    /**
     * @var array Register all luya core component language messages.
     */
    public $translations = [
        [
            'prefix' => 'luya*',
            'basePath' => '@luya/messages',
            'fileMap' => [
                'luya/luya' => 'luya.php',
                'luya/admin' => 'admin.php',
                'luya/cmsadmin' => 'cmsadmin.php',
            ],
        ],
    ];
    
    /**
     * Get translations for a speficif section
     * 
     * @param string $category The categery of the translation, e.g. 'admin' (cause fileMap luya/admin)
     * @param string $message The message name (array key in messages file)
     * @param array $params Optional paramters to pass.
     * @return string
     */
    public static function t($category, $message, array $params = [])
    {
        return Yii::t('luya/' . $category, $message, $params, Yii::$app->luyaLanguage);
    }
}

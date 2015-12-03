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
    const VERSION = '1.0.0-beta2';

    /**
     * Default url behavior if luya is included. first rule which will be picked.
     *
     * @var array
     */
    public $urlRules = [
        ['class' => 'luya\components\UrlRule', 'position' => UrlRule::POSITION_LUYA],
    ];
    
    /**
     * initializ luya messages
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }
    
    /**
     * register the translation service for luya
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['luya*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@luya/messages',
            'fileMap' => [
                'luya/luya' => 'luya.php',
                'luya/admin' => 'admin.php',
                'luya/cmsadmin' => 'cmsadmin.php',
            ],
        ];
    }
    
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

<?php

namespace cms;

/**
 * Cms Module.
 * 
 * @author nadar
 */
class Module extends \luya\base\Module
{
    /**
     * @var array We have no urlRules in cms Module. the UrlRoute file will only be used when
     *            no module is provided. So the CMS url alias does only apply on default behavior.
     */
    public $urlRules = [];

    /**
     * @var bool If enabled the cms content will be compressed (removing of whitespaces and tabs).
     */
    public $enableCompression = true;

    /**
     * @var bool If enableTagParsing is enabled tags like `link(1)` or `link(1)[Foo Bar]` will be parsed
     *           and transformed into links based on the cms.
     */
    public $enableTagParsing = true;

    /**
     * @var bool CMS is a luya core module.
     */
    public $isCoreModule = true;
    
    /**
     * @var array Define an array with the names of defined yii\web\User's from the config. Example defintion
     * in the config. This array will be used to perform group permission checks based on the 
     * luya\web\GroupUserIdentityInterface implemantions of `authGroups()`.
     * 
     * ```
     * 'patient' => [
     *     'class' => 'luya\web\GroupUser',
     *     'identityClass' => 'app\models\frontend\Patient',
     * ],
     * 'expert' => [
     *     'class' => 'luya\web\GroupUser',
     *     'identityClass' => 'app\models\frontend\Expert',
     * ],
     * ```
     * 
     * would look like this in frontendUsers array
     * 
     * ```
     * $frontendUsers = ['patient', 'expert'];
     * ```
     * 
     * You can define this property via the application configuration.
     */
    public $frontendUsers = [];

    /**
     * Define all available frontend groups
     * 
     * @var array An array contain all frontend groups which are available, like
     * 
     * ```php
     * $frontendGroups = ['patient', 'expert', 'those', 'theothers'];
     * ```
     */
    public $frontendGroups = [];
    
    /**
     * 
     * {@inheritDoc}
     * @see \luya\base\Module::registerComponents()
     */
    public function registerComponents()
    {
        return [
            'links' => [
                'class' => 'cms\components\Links',
            ],
            'menu' => [
                'class' => 'cms\menu\Container',
            ],
        ];
    }
}

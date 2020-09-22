<?php

namespace luya\traits;

use luya\theme\ThemeManager;
use Yii;
use luya\base\AdminModuleInterface;
use luya\base\Module;
use luya\base\CoreModuleInterface;
use luya\base\PackageInstaller;

/**
 * LUYA Appliation trait
 *
 * @property string $webroot Returns the webroot directory event for console commands.
 * @property \luya\components\Mail $mail Get luya mail component
 * @property ThemeManager $themeManager Get luya theme manager
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait ApplicationTrait
{
    /**
     * @var string Title for the application used in different sections like Login screen
     */
    public $siteTitle = 'LUYA Application';
    
    /**
     * @var string|boolean Set a token, which will be used to collect data from a central host, if you want to enable this feature.
     * Use http://passwordsgenerator.net/ to create complex strings. When you have enabled this feature you can collect information's from
     * all your hosts with `example.com/admin/remote?token=Sha1EncodedRemoteToken`.
     */
    public $remoteToken = false;

    /**
     * @var string The directory where your webroot represents, this is basically used to find the webroot directory
     * in the console mode, cause some importer classes need those variables.
     */
    public $webrootDirectory = 'public_html';
    
    /**
     * @var string This value will be used as hostInfo when running console applications in urlManager. An example for using the hostInfo
     *
     * ```php
     * 'consoleHostInfo' => 'https://luya.io'
     * ```
     */
    public $consoleHostInfo;
    
    /**
     * @var string This value is used when declared for console request as urlManger baseUrl in order to enable urlHandling. If {{luya\web\traits\ApplicationTrait::$consoleHostInfo}}
     * is defined, consoleBaseUrl will use `/` as default value. The base url is the path where the application is running after hostInfo like
     *
     * ```php
     * 'consoleBaseUrl' => '/luya-kickstarter'
     * ```
     *
     * But in the most cases when the website is online the baseUrl is `/` which is enabled by default when {{luya\web\traits\ApplicationTrait::$consoleHostInfo}} is defined.
     */
    public $consoleBaseUrl;
    
    /**
     * @var boolean If enabled, the application will throw an exception if a request is not from a secure connection (https). So any none secure request will throw
     * a {{yii\web\ForbiddenHttpException}}. This option will also make sure REST APIs are requested by a secure connection.
     * @since 1.0.5
     */
    public $ensureSecureConnection = false;
    
    /**
     * @var array Add tags to the TagParser class. Example
     *
     * ```php
     * 'tags' => [
     *     'foobar' => ['class' => '\app\tags\FoobarTag'],
     * ],
     * ```
     */
    public $tags = [];

    /**
     * @var array Can override the localisation value used for php internal `setlocale()` method for specific language. For example
     * the language is de but the it should use the locale charset `de_CH.utf8` (locale -a will return all locales installed on the server)
     * you can define them inside an array where key is the language and value the locale value to be used.
     *
     * ```php
     * public $locales = [
     *    'de' => 'de_CH',
     *    'en' => 'en_GB',
     * ];
     * ```
     */
    public $locales = [];

    /**
     * @var array An array to provide application wide CORS settings.
     *
     * By default the X-Headers of Yii and LUYA Admin are exposed. In order to override the cors
     * config the following example would work (including cors class definition).
     *
     * ```php
     * 'corsConfig' => [
     * 'class' => 'yii\filters\Cors',
     *     'cors' => [
     *         'Origin' => ['*'],
     *         'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
     *         'Access-Control-Request-Headers' => ['*'],
     *         'Access-Control-Allow-Credentials' => null,
     *         'Access-Control-Max-Age' => 86400,
     *         'Access-Control-Expose-Headers' => [
     *             'X-My-Header-Name',
     *         ],
     *     ],
     * ]
     * ```
     *
     * @since 1.0.22
     */
    public $corsConfig = [
        'class' => 'yii\filters\Cors',
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            'Access-Control-Request-Headers' => ['*'],
            'Access-Control-Allow-Credentials' => null,
            'Access-Control-Max-Age' => 86400,
            'Access-Control-Expose-Headers' => [
                'X-Pagination-Current-Page',
                'X-Pagination-Page-Count',
                'X-Pagination-Per-Page',
                'X-Pagination-Total-Count',
                'X-Cruft-Length',
            ],
        ],
    ];
    
    /**
     * Add trace info to luya application trait
     */
    public function init()
    {
        parent::init();
        
        // add trace info
        Yii::debug('initialize LUYA Application', __METHOD__);
        
        $this->setLocale($this->language);
    }
    
    /**
     * Transform the $language into a locale sign to set php env settings.
     *
     * Example transform input `de` to `de_CH` when available $locales property as
     *
     * ```php
     * 'locales' => ['de' => 'de_CH']
     * ```
     *
     * @param string $lang Find the locale for the provided $lang short code.
     * @return string The localisation code for the provided lang short code.
     */
    public function ensureLocale($lang)
    {
        // see if the $lang is available in the $locales map.
        if (array_key_exists($lang, $this->locales)) {
            return $this->locales[$lang];
        }
        
        // generate from `de` the locale `de_DE` or from `en` `en_EN` only if $lang is 2 chars.
        if (strlen($lang) == 2) {
            return strtolower($lang) . '_' . strtoupper($lang);
        }
        
        return $lang;
    }
    
    /**
     * Set the application localisation trough `setlocale`.
     *
     * The value will be parsed trough {{ensureLocale()}} in order to generated different possible localisation
     * values like `en_EN` or `en_EN.utf8` and it will generate from `de` a locale value like `de_DE`.
     *
     * setlocale() can have multiple arguments:
     *
     * > If locale is an array or followed by additional parameters then each array element or parameter
     * > is tried to be set as new locale until success. This is useful if a locale is known under different
     * > names on different systems or for providing a fallback for a possibly not available locale.
     *
     * @param string $lang The language short code to set the locale for.
     */
    public function setLocale($lang)
    {
        $locale = str_replace(['.utf8', '.UTF-8'], '', $this->ensureLocale($lang));
        setlocale(LC_ALL, $locale.'.utf8', $locale.'UTF-8', $locale);
    }

    private $_packageInstaller;
    
    /**
     * Get the package Installer
     * @return \luya\base\PackageInstaller
     */
    public function getPackageInstaller()
    {
        if ($this->_packageInstaller == null) {
            $file = Yii::getAlias('@vendor/luyadev/installer.php');
        
            $data = is_file($file) ? include $file : [];
        
            $this->_packageInstaller = new PackageInstaller($data);
        }
        
        return $this->_packageInstaller;
    }
    
    /**
     * @inheritdoc
     */
    protected function bootstrap()
    {
        foreach ($this->getPackageInstaller()->getConfigs() as $config) {
            $this->bootstrap = array_merge($this->bootstrap, $config->bootstrap);
        }
        
        parent::bootstrap();
    }
    
    private $_webroot;
    
    /**
     * Read only property which is used in cli bootstrap process to set the @webroot alias
     *
     * ```php
     * Yii::setAlias('@webroot', $app->webroot);
     * ```
     */
    public function getWebroot()
    {
        if ($this->_webroot === null) {
            $this->_webroot = realpath(realpath($this->basePath) . DIRECTORY_SEPARATOR . $this->webrootDirectory);
        }
        
        return $this->_webroot;
    }

    /**
     * Add additional core components to the yii2 base core components.
     */
    public function luyaCoreComponents()
    {
        return array_merge(parent::coreComponents(), [
            'mail' => ['class' => 'luya\components\Mail'],
            'formatter' => ['class' => 'luya\components\Formatter'],
            'themeManager' => ['class' => 'luya\theme\ThemeManager'],
        ]);
    }

    /**
     * Get an array with all modules which are an instance of the `luya\base\Module`.
     *
     * @return \luya\base\Module
     */
    public function getApplicationModules()
    {
        $modules = [];

        foreach ($this->getModules() as $id => $obj) {
            if ($obj instanceof Module) {
                $modules[$id] = $obj;
            }
        }

        return $modules;
    }

    /**
     * Return a list with all registered frontend modules except 'luya' and 'cms'. This is needed in the module block.
     *
     * @return \luya\base\Module
     */
    public function getFrontendModules()
    {
        $modules = [];

        foreach ($this->getModules() as $id => $obj) {
            if ($obj instanceof Module && !$obj instanceof AdminModuleInterface && !$obj instanceof CoreModuleInterface) {
                $modules[$id] = $obj;
            }
        }

        return $modules;
    }
    
    private $_adminModules;

    /**
     * Return all Admin Module Interface implementing modules.
     *
     * @return \luya\base\AdminModuleInterface
     */
    public function getAdminModules()
    {
        if ($this->_adminModules === null) {
            $this->_adminModules = [];
            foreach ($this->getModules() as $id => $obj) {
                if ($obj instanceof Module && $obj instanceof AdminModuleInterface) {
                    $this->_adminModules[$id] = $obj;
                }
            }
        }

        return $this->_adminModules;
    }

    /**
     * Get all admin menu modules
     *
     * @return array An array where the key is the module id and value the menu array.
     * @since 1.7.0
     */
    public function getAdminModulesMenus()
    {
        $menu = [];
        foreach($this->getAdminModules() as $module) {
            if ($module->getMenu()) {
                $menu[$module->id] = $module->getMenu();
            }
        }

        return $menu;
    }

    /**
     * Get all assets files from all admin modules
     *
     * @return array
     * @since 1.7.0
     */
    public function getAdminModulesAssets()
    {
        $assets = [];
        foreach ($this->getAdminModules() as $module) {
            $assets = array_merge($module->getAdminAssets(), $assets);
        }

        return $assets;
    }

    /**
     * Get all js translations from all admin modules
     *
     * @return array
     * @since 1.7.0
     */
    public function getAdminModulesJsTranslationMessages()
    {
        $jsTranslations = [];
        foreach ($this->getAdminModules() as $id => $module) {
            $jsTranslations[$id] = $module->getJsTranslationMessages();
        }

        return $jsTranslations;
    }
    
}

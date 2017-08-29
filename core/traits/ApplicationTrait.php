<?php

namespace luya\traits;

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
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait ApplicationTrait
{
    private $_webroot;
    
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
     * the language is de but the it should use the locale charset `de_CH.utf` (locale -a will return all locales installed on the server)
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
     * Add trace info to luya application trait
     */
    public function init()
    {
        parent::init();
        
        // add trace info
        Yii::trace('initialize LUYA Application', __METHOD__);
        
        $this->setLocale($this->language);
    }
    
    /**
     * Transform the $language into a locale sign to set php env settings.
     *
     * Example transform input `de` to `de_CH` when available $locales property.
     *
     * @param string $lang Find the locale POSIX for the provided $lang short code.
     * @return string The localisation code for the provided lang short code.
     */
    public function ensureLocale($lang)
    {
        if (array_key_exists($lang, $this->locales)) {
            return $this->locales[$lang];
        }
        
        if (strlen($lang) == 2) {
            switch ($lang) {
                case 'de':
                    return 'de_DE';
                case 'fr':
                    return 'fr_FR';
                case 'it':
                    return 'it_IT';
                case 'ru':
                    return 'ru_RU';
                case 'en':
                    return 'en_US';
                default:
                    return strtolower($lang) . '_' . strtoupper($lang);
            }
        }
        
        return $lang;
    }
    
    /**
     * Setter method ensures the locilations POSIX from {{ensureLocale}} for the provided lang
     * and changes the Yii::$app->langauge and sets the `setlocale()` code from ensureLocale().
     *
     * @param string $lang The language short code to set the locale for.
     */
    public function setLocale($lang)
    {
        $locale = str_replace('.utf8', '', $this->ensureLocale($lang));
        $this->language = $locale;
        setlocale(LC_ALL, $locale.'.utf8', $locale);
    }

    /**
     * Get the package Installer
     * @return \luya\base\PackageInstaller
     */
    public function getPackageInstaller()
    {
        $file = Yii::getAlias('@vendor' . DIRECTORY_SEPARATOR . 'luyadev' . DIRECTORY_SEPARATOR . 'installer.php');
        
        $data = [];
        if (is_file($file)) {
            $data = require($file);
        }
         
        return new PackageInstaller($data);
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
    
    /**
     * Return all Admin Module Interface implementing modules.
     *
     * @return \luya\base\AdminModuleInterface
     */
    public function getAdminModules()
    {
        $modules = [];
        
        foreach ($this->getModules() as $id => $obj) {
            if ($obj instanceof Module && $obj instanceof AdminModuleInterface) {
                $modules[$id] = $obj;
            }
        }
        
        return $modules;
    }
}

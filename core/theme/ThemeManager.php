<?php

namespace luya\theme;

use luya\base\PackageConfig;
use luya\Exception;
use luya\helpers\Json;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

/**
 * Core theme manager for LUYA.
 *
 * This component manage available themes via file system and the actual display themes.
 *
 * @property bool $hasActiveTheme
 * @property Theme $activeTheme
 *
 * @author Bennet Klarhölter <boehsermoe@me.com>
 * @since  1.1.0
 */
class ThemeManager extends \yii\base\Component
{
    /**
     * Name of the event before the active theme will be setup.
     */
    const EVENT_BEFORE_SETUP = 'eventBeforeSetup';
    
    /**
     * Name of the theme which should be activated on setup.
     *
     * @var string
     */
    public $activeThemeName;
    
    /**
     * @var ThemeConfig[]
     */
    private $_themes = [];
    
    /**
     * Read the theme.json and create a new \luya\theme\ThemeConfig for the given base path.
     *
     * @param string $basePath Base path can either be a path to a folder with theme.json files or an absolute path to a theme.json file
     * @return ThemeConfig
     * @throws Exception
     * @throws InvalidConfigException
     */
    public static function loadThemeConfig(string $basePath)
    {
        if (strpos($basePath, '@') === 0) {
            $dir = Yii::getAlias($basePath);
        } elseif (strpos($basePath, '/') !== 0) {
            $dir = $basePath = Yii::$app->basePath . DIRECTORY_SEPARATOR . $basePath;
        } else {
            $dir = $basePath;
        }
        
        // $basePath is an absolute path = /VENDOR/NAME/theme.json
        if (is_file($basePath) && file_exists($basePath)) {
            $themeFile = $basePath;
            // if basePath is the theme file itself and existing process:
            $basePath = pathinfo($basePath, PATHINFO_DIRNAME);
        } else {
            if (!is_dir($dir) || !is_readable($dir)) {
                throw new Exception('Theme directory not exists or readable: ' . $dir);
            }

            $themeFile = $dir . DIRECTORY_SEPARATOR . 'theme.json';
            if (!file_exists($themeFile)) {
                throw new InvalidConfigException('Theme config file missing at: ' . $themeFile);
            }
        }
        
        $config = Json::decode(file_get_contents($themeFile)) ?: [];
    
        return new ThemeConfig($basePath, $config);
    }
    
    /**
     * Setup active theme
     *
     * @throws Exception
     * @throws InvalidConfigException
     * @throws \yii\db\Exception
     */
    final public function setup()
    {
        if ($this->activeTheme instanceof Theme) {
            // Active theme already loaded
            return;
        }
        
        $basePath = $this->getActiveThemeBasePath();
        $this->beforeSetup($basePath);
        
        if ($basePath) {
            $themeConfig = $this->getThemeByBasePath($basePath);
            $theme = new Theme($themeConfig);
            $this->activate($theme);
        }
    }
    
    /**
     * Trigger the {{\luya\theme\ThemeManager::EVENT_BEFORE_SETUP}} event.
     *
     * @param string $basePath
     */
    protected function beforeSetup(string &$basePath)
    {
        $event = new SetupEvent();
        $event->basePath = $basePath;
        $this->trigger(self::EVENT_BEFORE_SETUP, $event);
        
        $basePath = $event->basePath;
    }
    
    /**
     * Get base path of active theme.
     *
     * @return string
     * @throws \yii\db\Exception
     */
    protected function getActiveThemeBasePath()
    {
        if (!empty($this->activeThemeName) && is_string($this->activeThemeName)) {
            return $this->activeThemeName;
        }
        
        return false;
    }
    
    /**
     * Get all theme configs as array list.
     *
     * @param bool $throwException Whether an exception should by throw or not. By version 1.0.24 this is disabled by default.
     * @return ThemeConfig[]
     * @throws \yii\base\Exception
     */
    public function getThemes($throwException = false)
    {
        if ($this->_themes) {
            return $this->_themes;
        }
        
        $themeDefinitions = $this->getThemeDefinitions();
        
        foreach ($themeDefinitions as $themeDefinition) {
            try {
                $themeConfig = static::loadThemeConfig($themeDefinition);
                $this->registerTheme($themeConfig);
            } catch (\yii\base\Exception $ex) {
                if ($throwException) {
                    throw $ex;
                }
            }
        }
        
        return $this->_themes;
    }
    
    /**
     * Get theme definitions by search in `@app/themes` and the `Yii::$app->getPackageInstaller()`
     *
     * @return string[]
     */
    protected function getThemeDefinitions()
    {
        $themeDefinitions = [];
        
        if (file_exists(Yii::getAlias('@app/themes'))) {
            foreach (glob(Yii::getAlias('@app/themes/*')) as $dirPath) {
                $themeDefinitions[] = "@app/themes/" . basename($dirPath);
            }
        }
        
        foreach (Yii::$app->getPackageInstaller()->getConfigs() as $config) {
            /** @var PackageConfig $config */
            $themeDefinitions = array_merge($themeDefinitions, $config->themes);
        }
        
        return $themeDefinitions;
    }
    
    /**
     * @param string $basePath
     *
     * @return ThemeConfig
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getThemeByBasePath(string $basePath)
    {
        $themes = $this->getThemes();
        
        if (!isset($themes[$basePath])) {
            throw new InvalidArgumentException("Theme $basePath could not loaded.");
        }
        
        return $themes[$basePath];
    }
    
    /**
     * Register a theme config and set the path alias with the name of the theme.
     *
     * @param ThemeConfig $themeConfig Base path of the theme.
     *
     * @throws InvalidConfigException
     */
    protected function registerTheme(ThemeConfig $themeConfig)
    {
        $basePath = $themeConfig->getBasePath();
        if (isset($this->_themes[$basePath])) {
            throw new InvalidArgumentException("Theme $basePath already registered.");
        }
        
        $this->_themes[$basePath] = $themeConfig;
        
        Yii::setAlias('@' . basename($basePath) . 'Theme', $basePath);
    }
    
    /**
     * Change the active theme in the \yii\base\View component and set the `activeTheme ` alias to new theme base path.
     *
     * @param Theme $theme
     */
    protected function activate(Theme $theme)
    {
        Yii::$app->view->theme = $theme;
        Yii::setAlias('activeTheme', $theme->basePath);
        
        $this->setActiveTheme($theme);
    }
    
    /**
     * @var Theme|null
     */
    private $_activeTheme;
    
    /**
     * Get the active theme. Null if no theme is activated.
     *
     * @return Theme|null
     */
    public function getActiveTheme()
    {
        return $this->_activeTheme;
    }
    
    /**
     * Change the active theme.
     *
     * @param Theme $theme
     */
    protected function setActiveTheme(Theme $theme)
    {
        $this->_activeTheme = $theme;
    }
    
    /**
     * Check if a theme is activated.
     *
     * @return bool
     */
    public function getHasActiveTheme()
    {
        return $this->getActiveTheme() !== null;
    }
}

<?php

namespace luya\theme;

use luya\base\PackageConfig;
use luya\helpers\Json;
use Yii;
use luya\Exception;
use yii\base\InvalidConfigException;

/**
 * Core theme manager for LUYA.
 *
 * This component manage the actual display themes.
 *
 * @property Theme $activeTheme
 *
 * @author Mateusz Szymański Teamwant <zzixxus@gmail.com>
 * @author Bennet Klarhölter <boehsermoe@me.com>
 * @since 1.0.0
 */
class ThemeManager extends \yii\base\Component
{
    const APP_THEMES_BLANK = '@app/themes/blank';
    
    /**
     * @var Theme
     */
    private $_activeTheme;
    
    /**
     * @var ThemeConfig[]
     */
    private $_themes = [];

    /**
     * Setup active theme
     */
    public function setup()
    {
        if ($this->activeTheme instanceof Theme) {
            // Active theme already loaded
            return;
        }

        $basePath = $this->getActiveThemeBasePath();
        
        $themeConfig = new ThemeConfig($basePath);
        $this->activeTheme = new Theme($themeConfig);
        
        Yii::$app->view->theme = $this->activeTheme;
        
        Yii::setAlias('theme', $this->activeTheme->basePath);
    }

    /**
     * Get base path of active theme.
     *
     * @return string
     * @throws \yii\db\Exception
     */
    protected function getActiveThemeBasePath()
    {
        if (!empty($this->activeTheme) && is_string($this->activeTheme)) {
            // load active theme by config
            return $this->activeTheme;
        }
    
        return self::APP_THEMES_BLANK;
    }
    
    /**
     * Get all theme configs as array list.
     *
     * @return ThemeConfig[]
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getThemes()
    {
        if ($this->_themes) {
            return $this->_themes;
        }
        
        $themeDefinitions = $this->getThemeDefinitions();
    
        foreach ($themeDefinitions as $themeDefinition) {
            $dir = Yii::getAlias($themeDefinition);
            
            if (!is_dir($dir) || is_readable($dir)) {
                throw new Exception('Theme directory not exists or readable: ' . $dir);
            }
    
            $themeFile = $dir . '/theme.json';
            if (file_exists($themeFile)) {
                $themeConfig = new ThemeConfig($themeDefinition);
                $this->_themes[$themeDefinition] = $themeConfig;
            }
        }
    
        return $this->_themes;
    }

    /**
     * Get theme definitions by search in `@app/themes` and the `Yii::$app->getPackageInstaller()`
     *
     * @return string[]
     */
    protected function getThemeDefinitions() : array
    {
        $themeDefinitions = [];
        
        foreach (scandir(Yii::getAlias('@app/themes')) as $dirPath) {
            $themeDefinitions = array_merge($themeDefinitions, "@app/themes/" , basename($dirPath));
        }
        
        foreach (Yii::$app->getPackageInstaller()->getConfigs() as $config) {
            /** @var PackageConfig $config */
            $themeDefinitions = array_merge($themeDefinitions, $config->themes);
        }
        
        return $themeDefinitions;
    }

    /**
     * @return Theme
     */
    public function getActiveTheme()
    {
        return $this->_activeTheme;
    }
    
    /**
     * @param Theme|string $theme
     */
    public function setActiveTheme($theme)
    {
        $this->_activeTheme = $theme;
    }
}

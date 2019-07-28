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
        if (!$this->activeTheme) {
            $basePath = $this->getActiveThemeBasePath();
        } elseif (is_string($this->activeTheme)) {
            $basePath = $this->activeTheme;
        } elseif ($this->activeTheme instanceof Theme) {
            // Active theme already loaded
            return;
        }
    
        $themeConfig = new ThemeConfig($basePath);
        $this->activeTheme = new Theme($themeConfig);
        
        Yii::$app->view->theme = $this->activeTheme;
        
        Yii::setAlias('theme', $this->activeTheme->basePath);
    }

    /**
     * Get current theme from SQL
     * If you have own theme you must inset into db record named active_theme like that:
     *
     * INSERT INTO `admin_config` (`name`, `value`, `is_system`, `id`) VALUES ('active_theme', '@app/themes/teamwant', '1', NULL);
     *
     * todo: create admin module to manage themes
     * @return string
     * @throws \yii\db\Exception
     */
    public function getActiveThemeBasePath()
    {
        try {
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("SELECT * FROM `admin_config` WHERE `name` = :name limit 1;", [':name' => 'active_theme']);

            $result = $command->queryOne();

            if (!$result) {
                return self::APP_THEMES_BLANK;
            }

        } catch (\Exception $e) {
//            do none, return default theme
            return self::APP_THEMES_BLANK;
        }

        return $result['value'];
    }
    
    /**
     * Get all themes as array list.
     *
     * @todo: Should be exclude in a ThemeImporter and loaded via CLI command `import`. And load the dirs from the package.
     *
     * @return ThemeConfig[]
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
     * Get Themes directories
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
        var_dump($themeDefinitions);
        die;
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

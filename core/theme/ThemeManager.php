<?php

namespace luya\theme;

use luya\helpers\Json;
use Yii;
use luya\Exception;
use yii\base\InvalidConfigException;

/**
 * Theme for LUYA CMS.
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
     * @var Theme[]
     */
    private $themes = [];

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
        
        Yii::$app->params['active_theme'] = $this->activeTheme;
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
     * @return Theme[]
     */
    public function getThemes()
    {
        //  @todo: Should be exclude in a ThemeImporter and loaded via CLI command `import`. And load the dirs from the package.
        $dir = $this->getThemesDir();

        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new Exception('Themes directory not exists: ' . $dir);
            }

            chmod($dir, 0766);
        }

        foreach (scandir($dir) as $entry) {
            if ($entry != "." && $entry != "..") {
    
                $themeFile = $dir . '/' . $entry . '/theme.json';
                if (file_exists($themeFile)) {
                    $data = Json::decode(file_get_contents($themeFile));

                    if ($data === false) {
                        continue;
                    }

                    $this->themes[$entry] = [
                        'name' => $data->name
                    ];
                }

            }
        }

        return $this->themes;
    }

    /**
     * Get Themes directory
     *
     * @return string
     */
    protected function getThemesDir()
    {
        return Yii::$app->basePath . '/themes';
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

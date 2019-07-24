<?php

namespace luya\theme;

use luya\helpers\Json;
use Yii;
use luya\Exception;

/**
 * Theme for LUYA CMS.
 *
 * This module / component allow user to manage actual display themes.
 *
 * @author Mateusz Szymański Teamwant <zzixxus@gmail.com>
 * @author Mateusz Szymański Teamwant <kontakt@teamwant.pl>
 * @since 1.0.0
 */
class ThemeManager extends \yii\base\Component
{
    const APP_THEMES_BLANK = '@app/themes/blank';
    
    /**
     * @var Theme
     */
    private $activeTheme;
    
    /**
     * @var Theme[]
     */
    private $themes = [];


    /**
     * Initialize Themes Component
     */
    public function init()
    {
        parent::init();
    }


    /**
     * Setup component
     * @return $this
     */
    public function setup()
    {
        $this->activeTheme = new Theme(['path' => $this->getActiveThemePath()]);
        Yii::setAlias('theme', $this->activeTheme->path);
        
        Yii::$app->params['active_theme'] = $this->activeTheme;

        return $this;
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
    public function getActiveThemePath()
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
     * Return $this->config value
     * @return Theme
     */
    public function getActiveTheme()
    {
        return $this->activeTheme;
    }

}

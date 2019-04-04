<?php

namespace luya\components;

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
class Themes extends \yii\base\Component
{

    /**
     * @var array
     */
    private $config = array();
    /**
     * @var array
     */
    private $themes = array();


    /**
     * Initialize Themes Component
     */
    public function init()
    {
        parent::init();
        $this->setup();
    }


    /**
     * Setup component
     * @return $this
     */
    public function setup()
    {

        $this->config['active'] = $this->getActive();
        $this->config['views'] = $this->config['active'] . '/views';
        $this->config['resources'] = $this->config['active'] . '/resources';
        $this->config['layout'] = $this->config['views'] . '/layouts';
        $this->config['layout_file'] = 'main';
        $this->config['layout_main'] = $this->config['layout'] . '/' . $this->config['layout_file'] . '.php';

        if ($data = $this->getThemeData($this->config['active'])) {
            $this->config['theme'] = $data;
        } else {
            $this->config['theme'] = ['error' => 1];
        }


        Yii::$app->params['active_theme'] = $this->config;


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
    public function getActive()
    {
        try {
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("SELECT * FROM `admin_config` WHERE `name` = :name limit 1;", [':name' => 'active_theme']);

            $result = $command->queryOne();

            if (!$result) {
                return '@app/themes/blank';
            }

        } catch (\Exception $e) {
//            do none, return default theme
            return '@app/themes/blank';
        }

        return $result['value'];
    }

    /**
     *
     * Read theme info from XML theme file
     *
     * @param $path
     * @return array
     */
    public function getThemeData($path)
    {

        $path = implode('/', array_map(function ($v) {
            return Yii::getAlias($v);
        }, explode('/', $path)));


        if (file_exists($path . '/theme.xml')) {
            $xml = simplexml_load_string(file_get_contents($path . '/theme.xml'));

            if ($xml === false) {
                return array();
            }

            return array(
                'name' => $xml->name,
                'description' => $xml->description,
                'author' => $xml->author,
                'image' => $xml->image,
            );
        }

        return array();

    }

    /**
     * Get all themes as array list
     *
     * @return array
     */
    public function getThemes()
    {
        $dir = $this->getThemesDir();

        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new Exception('Themes directory not exists: ' . $dir);
            }

            chmod($dir, 0766);
        }

        foreach (scandir($dir) as $entry) {
            if ($entry != "." && $entry != "..") {

                if (file_exists($dir . '/' . $entry . '/theme.xml')) {
                    $xml = simplexml_load_string(file_get_contents($dir . '/' . $entry . '/theme.xml'));

                    if ($xml === false) {
                        continue;
                    }

                    $this->themes[$entry] = [
                        'name' => $xml->name
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
    public function getThemesDir()
    {
        return Yii::$app->basePath . '/themes';
    }

    /**
     * Return $this->config value
     * @return array
     */
    public function getTheme()
    {
        return $this->config;
    }

}

<?php

namespace luya\console\commands;

use luya\helpers\FileHelper;
use luya\helpers\Json;
use luya\theme\ThemeConfig;
use Yii;
use yii\helpers\Console;
use yii\helpers\Inflector;

/**
 * Command to create a new LUYA theme.
 *
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since 1.1.0
 */
class ThemeController extends \luya\console\Command
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';
    
    /**
     * Humanize the class name
     *
     * @return string The humanized name.
     */
    public function humanizeName($name)
    {
        return $name = Inflector::humanize(Inflector::camel2words($name));
    }
    
    /**
     * Render the json template.
     *
     * @param string $basePath
     * @param string $themeName
     * @return string
     */
    public function renderJson(string $basePath, string $themeName)
    {
        $themeConfig = new ThemeConfig($basePath);
        $themeConfig->name = $themeName;
    
        if ($this->confirm('Inherit from other theme?')) {
            $themeConfig->parentTheme = $this->prompt("Enter the base path (e.g. `@app/themes/blank`) of the parent theme:",
                [
                    'default' => '@app/themes/blank',
                    'validator' => function ($input, &$error) {
                        if (preg_match('/^[a-z]+$/', $input) === false) {
                            $error = 'The theme name must be only letter chars!';
                            return false;
                        } elseif (Yii::getAlias($input, false) === false) {
                            $error = 'The theme base path not exists!';
                            return false;
                        }
                    
                        return true;
                    },
                ]);
        }
        
        return Json::encode($themeConfig->toArray(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    
    /**
     * Create a new frontend/admin module.
     *
     * @return number
     */
    public function actionCreate()
    {
        Console::clearScreenBeforeCursor();
    
        $themeName = $this->prompt("Enter the name of the theme you like to generate:");
        
        $newName = preg_replace("/[^a-z]/", "", strtolower($themeName));
        if ($newName !== $themeName) {
            if (!$this->confirm("We have changed the name to '{$newName}'. Do you want to proceed with this name?")) {
                return $this->outputError('Abort by user.');
            } else {
                $themeName = $newName;
            }
        }
        
        $basePath = '@app' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $themeName;
        
        $appModulesFolder = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'themes';
        $themeFolder = $appModulesFolder . DIRECTORY_SEPARATOR . $themeName;
        
        if (file_exists($themeFolder)) {
            return $this->outputError("The folder " . $themeFolder . " exists already.");
        }
        
        $folders = [
            '',
            'resources',
            'views',
            'views/layouts',
            'views/cmslayouts',
        ];

        foreach ($folders as $folder) {
            FileHelper::createDirectory($themeFolder . DIRECTORY_SEPARATOR . $folder);
        }
        
        $contents = [
            $themeFolder. DIRECTORY_SEPARATOR . 'theme.json' => $this->renderJson($basePath, $themeName),
        ];
        
        foreach ($contents as $fileName => $content) {
            FileHelper::writeFile($fileName, $content);
        }
        
        return $this->outputSuccess("Theme files has been created successfully. Please run `".$_SERVER['PHP_SELF']." import` to loaded into the database.");
    }
}

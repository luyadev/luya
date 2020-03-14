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
 * @since 1.0.21
 */
class ThemeController extends \luya\console\Command
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';
    
    /**
     * Create a new theme.
     *
     * @param string|null $themeName
     *
     * @return int
     * @throws \yii\base\Exception
     */
    public function actionCreate(string $themeName = null)
    {
        Console::clearScreenBeforeCursor();
    
        $themeName = $this->prompt("Enter the name (lower case) of the theme you like to generate:", ['default' => $themeName]);
        
        $newName = preg_replace("/[^a-z]/", "", strtolower($themeName));
        if ($newName !== $themeName) {
            if (!$this->confirm("We have changed the name to '{$newName}'. Do you want to proceed with this name?")) {
                return $this->outputError('Abort by user.');
            } else {
                $themeName = $newName;
            }
        }
    
        $availableModules = implode(', ', array_column(Yii::$app->getFrontendModules(), 'id'));
        $themeLocation = $this->prompt("Enter the theme location where to generate (as path alias e.g. app, $availableModules):", ['default' => 'app']);
        $themeLocation = '@' . ltrim($themeLocation, '@');
    
        preg_match("#^@[A-z]+#", $themeLocation, $newThemeLocation);

        if ($newThemeLocation[0] !== $themeLocation) {
            if (!$this->confirm("We have changed the name to '{$newThemeLocation[0]}'. Do you want to proceed with this name?")) {
                return $this->outputError('Abort by user.');
            } else {
                $themeLocation = $newThemeLocation[0];
            }
        }
        
        $basePath = $themeLocation . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $themeName;
        $themeFolder = Yii::getAlias($basePath);
    
        if (file_exists($themeFolder)) {
            return $this->outputError("The folder " . $themeFolder . " exists already.");
        }
    
        $this->outputInfo("Theme path alias: " . $basePath);
        $this->outputInfo("Theme real path: " . $themeFolder);
        if (!$this->confirm("Do you want continue?")) {
            return $this->outputError('Abort by user.');
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
        
        return $this->outputSuccess("Theme files has been created successfully. Please run `".$_SERVER['PHP_SELF']." import` to import the theme into the database.");
    }
    
    /**
     * Render the json template.
     *
     * @param string $basePath
     * @param string $themeName
     * @return string
     */
    private function renderJson(string $basePath, string $themeName)
    {
        $themeConfig = new ThemeConfig($basePath, []);
        $themeConfig->name = $themeName;
        
        if ($this->confirm('Inherit from other theme?')) {
            $themeConfig->parentTheme = $this->prompt(
                "Enter the base path (e.g. `@app/themes/blank`) of the parent theme:",
                [
                    'default' => null,
                    'validator' => [$this, 'validateParentTheme'],
                ]
            );
        }
        
        return Json::encode($themeConfig->toArray(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private function validateParentTheme($input, &$error)
    {
        if (!preg_match('/^@[a-z]+$/', $input)) {
            $error = 'The theme name must be only letter chars!';
            return false;
        } elseif (Yii::getAlias($input, false) === false) {
            $error = 'The theme base path not exists!';
            return false;
        }

        return true;
    }
}

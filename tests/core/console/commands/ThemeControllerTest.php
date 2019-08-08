<?php

namespace luyatests\core\console\commands;

use luya\helpers\FileHelper;
use Yii;
use luya\console\commands\ThemeController;

class ThemeControllerTest extends \luyatests\LuyaConsoleTestCase
{
    public function testActionCreate()
    {
        $themePath = Yii::getAlias('@luyatests/data/themes/mynewtheme/');
        FileHelper::removeDirectory($themePath);
        
        $controller = new ThemeController('module', Yii::$app);
        $controller->interactive = false;
    
        $exitCode = $controller->actionCreate("myNewTheme");
    
        $this->assertEquals(0, $exitCode);
        
        $this->assertDirectoryExists($themePath);
        $this->assertDirectoryExists($themePath . DIRECTORY_SEPARATOR . 'resources');
        $this->assertDirectoryExists($themePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'cmslayouts');
        $this->assertDirectoryExists($themePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts');
        
        $expectedJson = <<<JSON
{
    "name": "mynewtheme",
    "parentTheme": "@app/themes/blank",
    "pathMap": [],
    "description": null,
    "image": null
}
JSON;

        $this->assertJsonStringEqualsJsonString($expectedJson, file_get_contents($themePath . DIRECTORY_SEPARATOR . 'theme.json'));
    }
    
    public function testRenderJson()
    {
    
    }
}

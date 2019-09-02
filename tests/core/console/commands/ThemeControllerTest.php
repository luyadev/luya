<?php

namespace luyatests\core\console\commands;

use luya\console\commands\ThemeController;
use luya\helpers\FileHelper;
use Yii;

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
    "description": null
}
JSON;
        
        $this->assertJsonStringEqualsJsonString($expectedJson, file_get_contents($themePath . DIRECTORY_SEPARATOR . 'theme.json'));
    }
    
    public function testUserAbort()
    {
        $controller = new ThemeControllerStub('module', Yii::$app);
        
        // Enter invalid theme name
        $controller->sendInput('THEME-NAME');
        // answer with no
        $controller->sendInput('no');
        
        $exitCode = $controller->actionCreate();
        
        $this->assertEquals(1, $exitCode);
        $this->assertEquals('Abort by user.', $controller->readOutput());
        $this->assertEquals('', $controller->readOutput());
    
        $controller->truncateStreams();
    
    
        // Enter valid theme name
        $controller->sendInput('themename');
        // Enter invalid location/alias
        $controller->sendInput('-invalid!sign1');
        // answer with no
        $controller->sendInput('no');
        
        $exitCode = $controller->actionCreate();

        $this->assertEquals(1, $exitCode);
        $this->assertEquals('Abort by user.', $controller->readOutput());
    
        $controller->truncateStreams();
    
    
        // Enter valid theme name
        $controller->sendInput('themename');
        // Enter valid location/alias
        $controller->sendInput('app');
        // Do you want continue? -> answer with no
        $controller->sendInput('no');
    
        $exitCode = $controller->actionCreate();
    
        $this->assertEquals(1, $exitCode);
        $this->assertEquals('Theme path alias: @app/themes/themename', $controller->readOutput());
        $this->assertEquals('Theme real path: ' . Yii::getAlias('@app/themes/themename'), $controller->readOutput());
        $this->assertEquals('Abort by user.', $controller->readOutput());
    }
    
    public function testThemeAlreadyExists()
    {
        $themePath = realpath(Yii::getAlias('@luyatests/data/themes/mynewtheme/'));
        FileHelper::createDirectory($themePath);
    
        $controller = new ThemeControllerStub('module', Yii::$app);
        
        // Enter valid theme name
        $controller->sendInput('mynewtheme');
        // Enter valid location/alias
        $controller->sendInput('app');
        // Do you want continue? -> answer with no
        $controller->sendInput('no');
    
        $exitCode = $controller->actionCreate();
    
        $this->assertEquals(1, $exitCode);
        $this->assertEquals("The folder $themePath exists already.", $controller->readOutput());
    }
}

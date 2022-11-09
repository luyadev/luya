<?php

namespace luyatests\core\console\commands;

use luya\console\commands\ThemeController;
use luya\helpers\FileHelper;
use luya\testsuite\traits\CommandStdStreamTrait;
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
        $this->assertDirectoryExists($themePath . 'resources');
        $this->assertFileExists($themePath . 'resources/mynewtheme.css');
        $this->assertFileExists($themePath . 'MynewthemeAsset.php');
        $this->assertFileExists($themePath . 'views' . DIRECTORY_SEPARATOR . 'cmslayouts/theme.php');
        $this->assertFileExists($themePath . 'views' . DIRECTORY_SEPARATOR . 'layouts/theme.php');

        $expectedJson = <<<JSON
{
    "name": "mynewtheme",
    "parentTheme": "",
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
        $controller->sendInput('@invalid!sign1');
        // answer with no
        $controller->sendInput('no');

        $exitCode = $controller->actionCreate();

        $this->assertEquals(1, $exitCode);
        $this->assertEquals('Abort by user.', $controller->readOutput());

        $controller->truncateStreams();

        // Enter valid theme name
        $controller->sendInput('themename');
        // Enter valid location/alias
        $controller->sendInput('@app-invalid');
        // Rename theme location? -> answer with yes
        $controller->sendInput('yes');
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

    public function testInvalidParentTheme()
    {
        $themePath = Yii::getAlias('@luyatests/data/themes/mynewtheme');
        FileHelper::removeDirectory($themePath);

        $controller = new ThemeControllerStub('module', Yii::$app);

        // Enter valid theme name
        $controller->sendInput('mynewtheme');
        // Enter valid location/alias
        $controller->sendInput('app');
        // Do you want continue? -> answer with no
        $controller->sendInput('yes');
        // Inherit from other theme? -> answer with yes
        $controller->sendInput('yes');
        // Enter invalid parent theme
        $controller->sendInput('INVALID-PARENT');

        $exitCode = $controller->actionCreate();

        $this->assertEquals(0, $exitCode);
        $this->assertEquals('Theme path alias: @app/themes/mynewtheme', $controller->readOutput());
        $this->assertEquals('Theme real path: ' . Yii::getAlias('@app/themes/mynewtheme'), $controller->readOutput());
        $this->assertEquals("Theme files has been created successfully. Please run `".$_SERVER['PHP_SELF']." import` to import the theme into the database.", $controller->readOutput());
    }

    public function testValidateParentTheme()
    {
        $controller = new ThemeController('module', Yii::$app);

        $error = null;
        $input = '@INVALID';
        $result = $this->invokeMethod($controller, 'validateParentTheme', [$input, &$error]);
        $this->assertFalse($result);
        $this->assertEquals('The theme name must be only letter chars!', $error);

        $error = null;
        $input = '@invalid';
        $result = $this->invokeMethod($controller, 'validateParentTheme', [$input, &$error]);
        $this->assertFalse($result);
        $this->assertEquals('The theme base path not exists!', $error);

        $error = null;
        $input = '@app';
        $result = $this->invokeMethod($controller, 'validateParentTheme', [$input, &$error]);
        $this->assertTrue($result);
        $this->assertNull($error);
    }
}

class ThemeControllerStub extends ThemeController
{
    use CommandStdStreamTrait;
}

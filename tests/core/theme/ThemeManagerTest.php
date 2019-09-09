<?php

namespace luyatests\core\theme;

use luya\theme\SetupEvent;
use luya\theme\Theme;
use luya\web\Controller;
use Yii;
use luya\theme\ThemeManager;
use luyatests\LuyaWebTestCase;
use yii\base\InvalidArgumentException;
use yii\base\InvalidCallException;

/**
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since  1.1.0
 */
class ThemeManagerTest extends LuyaWebTestCase
{
    public function testSetup()
    {
        $themeManager = new ThemeManager();
        $themeManager->activeThemeName = '@app/themes/blank';
        $themeManager->setup();
        
        $this->assertNotNull(Yii::$app->view->theme, 'Theme must be set.');
        $expectedPath = realpath(Yii::getAlias('@luyatests/data/themes/blank'));
        $this->assertEquals($expectedPath, Yii::$app->view->theme->basePath, 'Theme base path not correct.');
        $this->assertEquals($expectedPath, Yii::getAlias('@activeTheme'), 'Alias path is not correct.');
    
        $this->assertInstanceOf(Theme::class, $themeManager->activeTheme);
    }
    
    public function testBeforeSetupEvent()
    {
        $themeManager = new ThemeManager();
        $themeManager->activeThemeName = '@app/themes/test';
        $themeManager->on(ThemeManager::EVENT_BEFORE_SETUP, function(SetupEvent $setupEvent) {
            $setupEvent->basePath = '@app/themes/blank';
        });
        $themeManager->setup();
        
        $expectedPath = realpath(Yii::getAlias('@luyatests/data/themes/blank'));
        $this->assertEquals($expectedPath, Yii::$app->view->theme->basePath, 'Theme base path not correct.');
        $this->assertEquals($expectedPath, Yii::getAlias('@activeTheme'), 'Alias path is not correct.');
        
        $themeManager->off(ThemeManager::EVENT_BEFORE_SETUP);
        $themeManager->on(ThemeManager::EVENT_BEFORE_SETUP, function(SetupEvent $setupEvent) {
            throw new InvalidCallException('Theme setup already done.');
        });
        $themeManager->setup();
    }
    
    /**
     * @runInSeparateProcess Must be isolated from other tests to check the path aliases.
     */
    public function testSetupWithoutActiveTheme()
    {
        $themeManager = new ThemeManager();
        $themeManager->setup();
    
        $this->assertNull(Yii::$app->view->theme, 'Theme must be null set.');
        $this->assertNull($themeManager->activeTheme);
        $this->assertFalse(Yii::getAlias('@activeTheme', false), 'Alias path must not set.');
    }
    
    public function testRenderLayoutInheritance()
    {
        $themeManager = new ThemeManager();
        $themeManager->activeThemeName = '@app/themes/blank3';
        $themeManager->setup();
        
        $this->assertEquals(Yii::getAlias('@app/themes/blank3'), $themeManager->activeTheme->getBasePath());
    
        /** @var Controller $controller */
        $controller = \Yii::$app->createController('foo')[0];
        
        $result = $controller->findLayoutFile(\Yii::$app->getView());
        // @todo wrong layoutpath
        $this->assertEquals(realpath(Yii::getAlias('@luyatests/data/views/layouts/main.php')), $result);
    
        $result = $controller->renderContent("Main layout form app dir");
        $this->assertEquals("Main layout form app dir", $result);
    
        $controller->layout = 'blank';
    
        $result = $controller->renderContent("Content");
        $this->assertEquals("BLANK 3 THEME", $result);
    }
    
    public function testRenderViewInheritance()
    {
        $themeManager = new ThemeManager();
        $themeManager->activeThemeName = '@app/themes/blank3';
        $themeManager->setup();
        
        $result = \Yii::$app->getView()->render('//test/index');
        $this->assertEquals("DEFAULT BLANK THEME", $result);
        
        $result = \Yii::$app->getView()->render('//test/index2');
        $this->assertEquals("BLANK 2 THEME", $result);
    }
    
    public function testThemeFromModule()
    {
        $themeManager = new ThemeManager();
        $themeManager->activeThemeName = '@thememodule/themes/testTheme';
        $themeManager->setup();
        
        /** @var Controller $controller */
        $controller = \Yii::$app->createController('thememodule/default/index')[0];
    
        $result = $controller->render("index");
        $this->assertEquals(Yii::getAlias('@thememodule/themes/testTheme/views/default/index.php'), $result);
    }
    
    /**
     * @expectedException \yii\base\InvalidArgumentException
     * @expectedExceptionMessage Theme @theme/not/exists could not loaded.
     */
    public function testInvalidThemeBasePath()
    {
        $themeManager = new ThemeManager();
        $themeManager->getThemeByBasePath('@theme/not/exists');
    }
    
    /**
     * @expectedException \luya\Exception
     * @expectedExceptionMessageRegExp #^Theme directory not exists or readable: [\w/]+/themes/not-readable$#
     */
    public function testNotReadableThemeDir()
    {
        $themeManager = new ThemeManager();
        // only writeable dir
        mkdir(Yii::getAlias('@app/themes/not-readable'), 0200);
        
        try {
            $themeManager->getThemes();
        } finally {
            rmdir(Yii::getAlias('@app/themes/not-readable'));
        }
    }
    
    /**
     * @expectedException \yii\base\InvalidConfigException
     * @expectedExceptionMessageRegExp #^Theme config file missing at: [\w/]+/otherThemeLocation/emptyThemeDir/theme.json$#
     */
    public function testEmptyThemeDir()
    {
        $themeManager = new ThemeManager();
        Yii::$app->getPackageInstaller()->getConfigs()['luyadev/luya-core']->setValue('themes', ['@app/otherThemeLocation/emptyThemeDir']);
    
        mkdir(Yii::getAlias('@app/otherThemeLocation/emptyThemeDir'));
    
        try {
            $themeManager->getThemes();
        } finally {
            rmdir(Yii::getAlias('@app/otherThemeLocation/emptyThemeDir'));
        }
    }
    
    public function testRelativeThemeDefinition()
    {
        $relativePath = 'otherThemeLocation/foo';
    
        Yii::$app->getPackageInstaller()->getConfigs()['luyadev/luya-core']->setValue('themes', [$relativePath]);
    
        $themeManager = new ThemeManager();
        $basePath = realpath(__DIR__ . '/../../data') . DIRECTORY_SEPARATOR . $relativePath;
        $themeConfig = $themeManager->getThemeByBasePath($basePath);
        
        $this->assertEquals("fooTheme", $themeConfig->name);
    }
    
    public function testAbsoluteThemeDefinition()
    {
        $absolutePath = realpath(__DIR__ . '/../../data') . DIRECTORY_SEPARATOR . 'otherThemeLocation/foo';
    
        Yii::$app->getPackageInstaller()->getConfigs()['luyadev/luya-core']->setValue('themes', [$absolutePath]);
        
        $themeManager = new ThemeManager();
        $themeConfig = $themeManager->getThemeByBasePath($absolutePath);
        
        $this->assertEquals("fooTheme", $themeConfig->name);
    }
    
    /**
     * @expectedException \yii\base\InvalidArgumentException
     * @expectedExceptionMessage  Theme @app/themes/blank already registered.
     */
    public function testDuplicateThemeDefinition()
    {
        Yii::$app->getPackageInstaller()->getConfigs()['luyadev/luya-core']->setValue('themes', ['@app/themes/blank']);
        
        $themeManager = new ThemeManager();
        $themeManager->getThemes();
    }
}

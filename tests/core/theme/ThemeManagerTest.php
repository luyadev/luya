<?php

namespace luyatests\core\theme;

use luya\theme\Theme;
use luya\web\Controller;
use Yii;
use luya\theme\ThemeManager;
use luyatests\LuyaWebTestCase;

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
    
        $this->assertInstanceOf(Theme::class, $themeManager->getActiveTheme());
    }
    
    public function testSetupWithoutActiveTheme()
    {
        $themeManager = new ThemeManager();
        $themeManager->setup();
    
        $this->assertNull(Yii::$app->view->theme, 'Theme must be null set.');
        $this->assertNull($themeManager->getActiveTheme());
        
        // Cannot tested because aliases are not reset between the tests.
        // $this->assertFalse(Yii::getAlias('@activeTheme', false), 'Alias path must not set.');
    }
    
    public function testRenderLayoutInheritance()
    {
        $themeManager = new ThemeManager();
        $themeManager->activeThemeName = '@app/themes/blank3';
        $themeManager->setup();
        
        $this->assertEquals(Yii::getAlias('@app/themes/blank3'), $themeManager->getActiveTheme()->getBasePath());
    
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
}

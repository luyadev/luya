<?php

namespace luyatests\core\web;

use luya\theme\Theme;
use Yii;
use luya\web\View;
use luya\web\Asset;

class TestAsset extends Asset
{
    public $sourcePath = '@app';
}

class ViewTest extends \luyatests\LuyaWebTestCase
{
    public function testCompress()
    {
        $view = new View();

        $string = '  ';
        $resultString = $view->compress($string);
        $this->assertEquals(0, strlen($resultString));

        $string = ' ';
        $resultString = $view->compress($string);
        $this->assertEquals(0, strlen($resultString));

        $this->assertSame('<p> foo bar </p>', $view->compress('    <p> foo    bar      </p>'));
    }
    
    /*
    public function testAssetUrlGetter()
    {
        $view = new View();
        TestAsset::register($view);
        $url = $view->getAssetUrl(TestAsset::class);
        $this->assertContains('c0d3b50b', $url);
    }
    */
    
    public function testUknownAssetUrl()
    {
        $this->expectException('luya\Exception');
        $view = new View();
        $view->getAssetUrl('Uknown');
    }
    
    public function testGetPublicHtml()
    {
        $view = new View();
        $url = $view->getPublicHtml();
        $this->assertContains('public_html', $url);
    }

    public function testThemeSetup()
    {
        Yii::$app->themeManager->activeThemeName = '@app/themes/blank';
        Yii::$app->themeManager->setup();

        $view = new View();

        $this->assertInstanceOf(Theme::class, $view->theme);

        $expectedPath = realpath(Yii::getAlias('@luyatests/data/themes/blank'));
        $this->assertEquals($expectedPath, $view->theme->basePath, 'Theme base path not correct.');
        $this->assertEquals($expectedPath, Yii::getAlias('@activeTheme'), 'Alias path is not correct.');

    }
}

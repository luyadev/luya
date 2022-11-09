<?php

namespace luyatests\core\traits;

use luyatests\LuyaWebTestCase;
use Yii;

class ApplicationTraitTest extends LuyaWebTestCase
{
    private $trait;

    public function afterSetup()
    {
        $this->trait = Yii::$app;
    }

    public function testCountApplicationModules()
    {
        $this->assertSame(5, count($this->trait->getApplicationModules()));
    }

    public function testCountFrontendModules()
    {
        $this->assertSame(4, count($this->trait->getFrontendModules()));
    }

    public function testLocalisation()
    {
        $app = Yii::$app;
        // default
        $this->assertStringContainsString('en-US', $app->ensureLocale($app->language));
        $app->locales = ['de' => 'de_CH.utf8'];
        $app->setLocale('de');
        $this->assertEquals('de_CH.utf8', $app->ensureLocale('de'));
        $this->assertSame('en-US', $app->language);
    }

    public function testWithoutUtf8Notiation()
    {
        $app = Yii::$app;
        $lang = 'de';
        $app->locales = [$lang => 'de_CH'];
        $this->assertSame('de_CH', $app->ensureLocale($lang));
        $this->assertSame('en-US', $app->language);
    }

    public function testUknownLocales()
    {
        $app = Yii::$app;

        $this->assertSame('xx_XX', $app->ensureLocale('xx_XX'));
        $this->assertSame('en_EN', $app->ensureLocale('en'));

        $app->locales = ['en' => 'en_US'];
        $this->assertSame('en_US', $app->ensureLocale('en'));
    }
}

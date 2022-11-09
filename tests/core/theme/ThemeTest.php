<?php

namespace luyatests\core\theme;

use luya\helpers\Json;
use luya\theme\Theme;
use luya\theme\ThemeConfig;
use luyatests\LuyaWebTestCase;
use Yii;

/**
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since  1.1.0
 */
class ThemeTest extends LuyaWebTestCase
{
    public function testSimplePathMap()
    {
        $basePath = '@app/themes/blank3';
        $config = Json::decode(file_get_contents(Yii::getAlias($basePath . '/theme.json')));

        $themeConfig = new ThemeConfig($basePath, $config);
        $theme = new Theme($themeConfig);

        $expectedPathMap = [
            '@app/views' => [
                '@app/views',
                '@app/themes/blank3/views',
                '@app/themes/blank2/views',
                '@app/themes/blank/views',
            ],
            '@app/themes/blank3/views' => [
                '@app/views',
                '@app/themes/blank3/views',
                '@app/themes/blank2/views',
                '@app/themes/blank/views',
            ],
            '@app/themes/blank2/views' => [
                '@app/views',
                '@app/themes/blank3/views',
                '@app/themes/blank2/views',
                '@app/themes/blank/views',
            ],
            '@app/themes/blank/views' => [
                '@app/views',
                '@app/themes/blank3/views',
                '@app/themes/blank2/views',
                '@app/themes/blank/views',
            ],
        ];

        $this->assertEquals($expectedPathMap, $theme->pathMap);
    }

    public function testAdditionalPathMap()
    {
        $theme1Config = new ThemeConfig('@app/themes/blank', []);
        $theme2Config = new ThemeConfig('@app/themes/blank2', ['parent' => $theme1Config, 'pathMap' => ['@additional/views']]);
        $theme3Config = new ThemeConfig('@app/themes/blank3', ['parent' => $theme2Config]);

        $theme = new Theme($theme3Config);

        $themePathOrder = [
            '@app/views',
            '@app/themes/blank3/views',
            '@app/themes/blank2/views',
            '@app/themes/blank/views',
        ];

        $expectedPathMap = [
            '@app/views' => $themePathOrder,
            '@app/themes/blank3/views' => $themePathOrder,
            '@app/themes/blank2/views' => $themePathOrder,
            '@app/themes/blank/views' => $themePathOrder,
            '@additional/views' => $themePathOrder,
        ];

        $this->assertEquals($expectedPathMap, $theme->pathMap);
    }

    public function testInvalidConfig()
    {
        $this->expectException('\yii\base\InvalidConfigException');
        $themeConfigMock = new class () extends ThemeConfig {
            public function __construct()
            {
            }
        };
        $themeConfig = new $themeConfigMock();

        $theme = new Theme($themeConfig);
    }
}

<?php

namespace luyatests\core\theme;


use luya\theme\ThemeConfig;
use luyatests\LuyaWebTestCase;
use yii\base\Theme;

/**
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since 1.1.0
 */
class ThemeTest extends LuyaWebTestCase
{
    public function testPathMap()
    {
        $basePath = '@app/themes/blank3';
        $themeConfig = new ThemeConfig($basePath);
        $theme = new Theme($themeConfig);
    
        $expectedPathMap = [
            '/var/www/themes/blank3' => [
                '@app/themes/blank3',
            ],
            '@app/views' => [
                '@app/themes/blank3'
            ],
        ];
        $this->assertEquals($expectedPathMap, $theme->pathMap);
    }
}

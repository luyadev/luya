<?php

namespace luyatests\core\theme;

use Yii;
use luya\theme\Theme;
use luya\theme\ThemeConfig;
use luya\theme\ThemeManager;
use luyatests\LuyaWebTestCase;

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
        ];

        $this->assertEquals($expectedPathMap, $theme->pathMap);
    }
}

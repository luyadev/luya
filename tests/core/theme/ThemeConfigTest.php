<?php

namespace luya\theme;

use Yii;
use luya\helpers\Json;
use luyatests\LuyaWebTestCase;

class ThemeConfigTest extends LuyaWebTestCase
{
    public function testWithParents()
    {
        $basePath = '@app/themes/blank3';
        $config = Json::decode(file_get_contents(Yii::getAlias($basePath . '/theme.json')));
    
        $themeConfig = new ThemeConfig($basePath, $config);
    
        $parents = $themeConfig->getParents();

        $this->assertCount(2, $parents);
        $this->assertEquals('@app/themes/blank2', $parents[0]->getBasePath());
        $this->assertEquals('@app/themes/blank', $parents[1]->getBasePath());
    }
    
    public function testWithoutParents()
    {
        $themeConfig = new ThemeConfig('@app/themes/blank', []);
        
        $this->assertCount(0, $themeConfig->getParents());
    }
    
    public function testGetViewPath()
    {
        $basePath = '@app/themes/blank3';
        $config = Json::decode(file_get_contents(Yii::getAlias($basePath . '/theme.json')));
    
        $themeConfig = new ThemeConfig($basePath, $config);
        $this->assertEquals($basePath . '/views', $themeConfig->getViewPath());
    }
}

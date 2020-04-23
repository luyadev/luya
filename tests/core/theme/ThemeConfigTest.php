<?php

namespace luyatests\core\theme;

use luya\helpers\Json;
use luya\theme\ThemeConfig;
use luyatests\LuyaWebTestCase;
use Yii;

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
    
    public function testBasePath()
    {
        $basePath = '@app/themes/blank3';
        $config = Json::decode(file_get_contents(Yii::getAlias($basePath . '/theme.json')));
        
        $themeConfig = new ThemeConfig($basePath, $config);
        $this->assertEquals('@app/themes/blank3', $themeConfig->getBasePath());
    }
    
    public function testGetViewPath()
    {
        $basePath = '@app/themes/blank3';
        $config = Json::decode(file_get_contents(Yii::getAlias($basePath . '/theme.json')));
        
        $themeConfig = new ThemeConfig($basePath, $config);
        $this->assertEquals($basePath . '/views', $themeConfig->getViewPath());
    }
    
    /**
     * @expectedException \yii\base\InvalidConfigException
     * @expectedExceptionMessage The path of @app/not/exists is not readable or not exists.
     */
    public function testInvalidConfig()
    {
        $themeConfig = new ThemeConfig('@app/not/exists', []);
    }
    
    /**
     * @expectedException \yii\base\InvalidArgumentException
     * @expectedExceptionMessage Theme @app/not/exists could not loaded.
     */
    public function testInvalidParent()
    {
        $themeConfig = new ThemeConfig('@app/themes/blank', ['parentTheme' => '@app/not/exists']);
        $themeConfig->getParent();
    }
}

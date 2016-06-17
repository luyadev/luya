<?php

namespace cmstests\src\helpers;

use Yii;
use cms\helpers\Url;
use cmstests\CmsFrontendTestCase;

class UrlTest extends CmsFrontendTestCase
{
    public function testToModuleFromOldLuyaBaseTest()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        $url = \cms\helpers\Url::toMenuItem(1, 'news/default/detail', ['id' => 1, 'title' => 'foo-bar']);
        $this->assertEquals('/1/foo-bar', $url);
    }
    
    public function testToModule()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        
        $this->assertEquals('/en/news-module', Url::toModule('news'));
        $this->assertEquals('notexists', Url::toModule('notexists'));
    }

    public function testToModuleRoute()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';

        $this->assertEquals('/en/news-module/1/foo-bar', Url::toModuleRoute('news', 'news/default/detail', ['id' => 1, 'title' => 'foo-bar']));
    }
}

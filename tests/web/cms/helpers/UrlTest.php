<?php

namespace tests\web\cms\helpers;

use Yii;
use cms\helpers\Url;

class UrlTest extends \tests\web\Base
{
    public function testToModule()
    {
        $this->assertEquals('/my-news-page', Url::toModule('gallery'));
        $this->assertEquals('notexists', Url::toModule('notexists'));
    }
    
    public function testToModuleRoute()
    {
        Yii::$app->request->baseUrl = '';
        Yii::$app->request->scriptUrl = '';
        
        $this->assertEquals('/news-module-page/news/1/foo-bar', Url::toModuleRoute('news', 'news/default/detail', ['id' => 1, 'title' => 'foo-bar']));
    }
}
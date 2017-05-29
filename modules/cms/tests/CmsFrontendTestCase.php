<?php

namespace cmstests;

use yii\helpers\Inflector;

require 'vendor/autoload.php';
require 'data/env.php';

class CmsFrontendTestCase extends \PHPUnit_Framework_TestCase
{
    public $app;
    
    public function setUp()
    {
        $this->mockApp();
    }
    
    public function mockApp()
    {
        if ($this->app === null) {
            $this->app = new \luya\Boot();
            $this->app->configFile = __DIR__ .'/data/configs/cms.php';
            $this->app->mockOnly = true;
            $this->app->setBaseYiiFile(__DIR__.'/../vendor/yiisoft/yii2/Yii.php');
            $this->app->applicationWeb();
        }
    }

    public static function mockMenuArray()
    {
        $data[] = self::generateMenuItem(1, 'homepage', ['is_home' => 1]);
        $data[] = self::generateMenuItem(2, 'Page 1', []);
        $data[] = self::generateMenuItem(3, 'Page 1.1', ['parent_nav_id' => 2, 'depth' => 2]);
        $data[] = self::generateMenuItem(4, 'Page 1.2', ['parent_nav_id' => 2, 'depth' => 2]);
        $data[] = self::generateMenuItem(5, 'Page 1.3', ['parent_nav_id' => 2, 'depth' => 2]);
        $data[] = self::generateMenuItem(6, 'Page 1.2.1', ['parent_nav_id' => 4, 'depth' => 3]);
        $data[] = self::generateMenuItem(7, 'Page 1.2.2', ['parent_nav_id' => 4, 'depth' => 3]);
        $data[] = self::generateMenuItem(8, 'Page 1.2.3', ['parent_nav_id' => 4, 'depth' => 3]);
        return $data;
    }
    
    public static function mockMenuContainerArray()
    {
        $data[] = self::generateMenuItem(1, 'homepage', ['is_home' => 1]);
        $data[] = self::generateMenuItem(2, 'Page 1', []);
        $data[] = self::generateMenuItem(3, '(c1) Page 1', ['container' => 'c1']);
        $data[] = self::generateMenuItem(5, '(c2) Page 1', ['container' => 'c2']);
        $data[] = self::generateMenuItem(6, '(c2) Page 2', ['container' => 'c2']);
        
        return $data;
    }

    public static function generateMenuItem($id, $title, array $args)
    {
        return array_merge([
            'id' => $id,
            'nav_id' => $id,
            'lang' => 'en',
            'link' => Inflector::slug($title),
            'title' => $title,
            'alias' => Inflector::slug($title),
            'type' => 1,
            'container' => 'default',
            'description' => 0,
            'keyowrds' => null,
            'create_user_id' => 0,
            'update_user_id' => 0,
            'timestamp_create' => time(),
            'timestamp_update' => time(),
            'parent_nav_id' => 0,
            'is_home' => 0,
            'sort_index' => 1000,
            'depth' => 1,
        ], $args);
    }
}

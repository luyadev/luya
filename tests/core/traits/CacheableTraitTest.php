<?php

namespace luyatests\core\traits;

use luya\traits\CacheableTrait;
use luyatests\data\classes\UnitCache;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\caching\FileDependency;

class CacheStub
{
    use CacheableTrait;
}

class CacheableTraitTest extends LuyaWebTestCase
{
    public function testNotCacheable()
    {
        $cache = new CacheStub();
        $this->assertFalse($cache->isCachable());
        $this->assertFalse($cache->setHasCache('not', 'available'));
        $this->assertFalse($cache->deleteHasCache('not'));
        $this->assertFalse($cache->getHasCache('not'));
    }

    public function testCacheable()
    {
        Yii::$app->set('cache', ['class' => 'yii\caching\DummyCache']);
        $cache = new CacheStub();
        $this->assertTrue($cache->isCachable());
        $this->assertTrue($cache->setHasCache('foo', 'bar'));
        $this->assertTrue($cache->setHasCache('baz', 'bar', ['class' => 'yii\caching\FileDependency', 'fileName' => 'foobar.txt']));
        $this->assertTrue($cache->setHasCache('qux', 'bar', (new FileDependency(['fileName' => 'foobar.txt']))));
        $this->assertTrue($cache->deleteHasCache('foo'));
        $this->assertFalse($cache->getHasCache('foo'));
    }

    public function testCacheableArrayKeys()
    {
        Yii::$app->set('cache', ['class' => 'yii\caching\DummyCache']);
        $cache = new CacheStub();
        $this->assertTrue($cache->setHasCache(['cache', 'bar'], 'bar'));
        $this->assertTrue($cache->deleteHasCache(['cache', 'bar']));
        $this->assertFalse($cache->getHasCache(['cache', 'bar']));
    }

    public function testFlushAllCache()
    {
        Yii::$app->set('cache', ['class' => UnitCache::className()]);
        $cache = new CacheStub();
        $cache->setHasCache('foo', 'bar');
        $this->assertSame('bar', $cache->getHasCache('foo'));
        $this->assertTrue($cache->flushHasCache());
        $this->assertFalse($cache->getHasCache('foo'));
    }
}

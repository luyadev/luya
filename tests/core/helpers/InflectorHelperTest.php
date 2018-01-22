<?php

namespace luyatests\core\helpers;

use Yii;
use luya\helpers\Inflector;

class InflectorHelperTest extends \luyatests\LuyaWebTestCase
{
    public function testSlug()
    {
        // testing with transliteration and with lowercase transformation
        $this->assertEquals('zhe-shi-luya', Inflector::slug('這是 LUYA ', '-', true, true));
        // testing with transliteration and without lowercase transformation
        $this->assertEquals('xin-xin-xin-xin', Inflector::slug('新-新-新-新', '-', false, true));
        // testing without transliteration and without lowercase transformation
        $this->assertEquals('新-新-新-新', Inflector::slug('新-新-新-新', '-', false, false));
        $this->assertEquals('這是-LUYA', Inflector::slug('這是 LUYA', '-', false, false));
        // testing without transliteration and without lowercase transformation
        $this->assertEquals('新-新-新-新', Inflector::slug('新-新-新-新', '-', true, false));
        $this->assertEquals('這是-luya', Inflector::slug('這是                  LUYA ', '-', true, false));
        // filter critical string elements whithout inflection
        $this->assertEquals('這是-luya', Inflector::slug('<這是> {LUYA} ', '-', true, false));
        $this->assertEquals('a1Zあ新~!@#$^&*()[];\',:?', Inflector::slug('a1Zあ新`~!@#$%^&*()_+[]\;\\\',./{}|:<>?', '-', false, false));

        // test lowercase and german special char
        $this->assertEquals('ÖöÜäüü-!?Hallo-hH', Inflector::slug('ÖöÜäüü  !?Hallo hH ', '-', false, false));
        $this->assertEquals('ööüäüü-!?hallo-hh', Inflector::slug('ÖöÜäüü  !?Hallo hH ', '-', true, false));
        $this->assertEquals('ööüäüü-新新新', Inflector::slug('ÖöÜäüü  新新新 ', '-', true, false));
        $this->assertEquals('ß', Inflector::slug('ß', '-', true, false));
    }
    
    public function testSlugWithUnderscoreAndDoubleSpaces()
    {
        $this->assertEquals('foo-barbaz', Inflector::slug('Foo  Bar__Baz', '-', true, false));
        $this->assertEquals('foo-barbaz', Inflector::slug('Foo  Bar__Baz'));
    }
}

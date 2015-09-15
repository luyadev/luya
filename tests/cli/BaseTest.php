<?php

namespace tests\cli;

use Yii;

/**
 * tryed to fix
 * 
 * Starting test 'tests\cli\BaseTest::testApp'.
 * PHP Notice 'yii\base\ErrorException' with message 'Array to string conversion'
 * in /home/travis/build/zephir/luya/vendor/phpunit/php-token-stream/src/Token/Stream.php:438
 *
 * with replacing instanceof method with assertEquals
 * @author nadar
 *
 */
class BaseTest extends \tests\cli\Base
{
    public function testApp()
    {
        $this->assertInstanceOf('luya\cli\Application', Yii::$app);
    }
}

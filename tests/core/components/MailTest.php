<?php

namespace tests\core\components;

use Yii;

/**
 * @author nadar
 */
class MailTest extends \tests\LuyaWebTestCase
{
    public function testAppMailerObject()
    {
        $this->assertTrue(Yii::$app->mail instanceof \luya\components\Mail);
    }
}
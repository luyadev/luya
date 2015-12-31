<?php

namespace tests\web\luya\components;

use Yii;

/**
 * @author nadar
 */
class MailTest extends \tests\web\Base
{
    public function testAppMailerObject()
    {
        $this->assertTrue(Yii::$app->mail instanceof \luya\components\Mail);
    }
}
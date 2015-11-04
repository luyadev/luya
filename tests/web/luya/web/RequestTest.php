<?php

namespace tests\web\luya\web\components;

use Yii;
use luya\web\Request;

class RequestTest extends \tests\web\Base
{
    public function testIsAdmin()
    {
        $request = new Request();
        $this->assertEquals(false, $request->isAdmin());

        $request->forceWebRequest = true;
        $request->pathInfo = "admin/test/";
        $this->assertEquals(true, $request->isAdmin());

        $request->forceWebRequest = true;
        $request->pathInfo = "test/admin/test/";
        $this->assertEquals(false, $request->isAdmin());

        $request->forceWebRequest = true;
        $request->pathInfo = "admin/ÜÄß";
        $this->assertEquals(true, $request->isAdmin());

        $request->forceWebRequest = true;
        $request->pathInfo = "de/admin/test/";
        $this->assertEquals(true, $request->isAdmin());

        // changing language code in composition pattern
        Yii::$app->composition->pattern = "<langShortCode:[0-9]{1}>";

        $request->forceWebRequest = true;
        $request->pathInfo = "1/admin/test/";
        $this->assertEquals(true, $request->isAdmin());

    }
}
<?php

namespace luyatests\core\web\filters;

use luya\web\filters\JsonCruftFilter;
use luyatests\LuyaWebTestCase;
use Yii;
use yii\web\Response;

class JsonCruftFilterTest extends LuyaWebTestCase
{
    public function testNoContentAction()
    {
        $filter = new JsonCruftFilter();
        Yii::$app->response->statusCode = 204;
        $result = $filter->afterAction('index', 'result');
        $this->assertSame('result', $result);
        $this->assertSame(null, Yii::$app->response->content);
    }

    public function testCruftPrepend()
    {
        $filter = new JsonCruftFilter();
        Yii::$app->response->content = 'foobar';
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = $filter->afterAction('index', 'result');
        Yii::$app->response->trigger(Response::EVENT_AFTER_PREPARE);
        $this->assertSame('result', $result);
        $this->assertSame(')]}\','.PHP_EOL.'foobar', Yii::$app->response->content);
    }
}

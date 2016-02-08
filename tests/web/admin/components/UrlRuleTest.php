<?php

namespace tests\web\admin\components;

use Yii;
use luya\helpers\Url;

class UrlRuleTest extends \tests\web\Base
{
    public function testControllerMap()
    {
        Yii::$app->getModule('admin')->controllerMap = ['api-admin-user' => '\\admin\\apis\\UserController'];

        $rule = new \admin\components\UrlRule();

        $this->assertEquals(true, is_array($rule->controller));
        $this->assertArrayHasKey('admin/api-admin-user', $rule->controller);
        $this->assertEquals($rule->controller['admin/api-admin-user'], 'admin/api-admin-user');
        
        $this->assertEquals(Url::to(['/admin/login/index']), Url::toManager('admin/login/index'));
        
    }
}

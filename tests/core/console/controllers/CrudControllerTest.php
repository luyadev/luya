<?php

namespace luyatests\core\console\controllers;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\commands\CrudController;

class CrudControllerTest extends LuyaConsoleTestCase
{
    public function testAssertsion()
    {
        $ctrl = new CrudController('id', Yii::$app);
        
        $testShema = Yii::$app->db->getTableSchema('admin_user', true);
        
        $this->assertNotNull($testShema);
        
        $this->assertSame(7, count($ctrl->generateRules($testShema)));
        $this->assertSame(13, count($ctrl->generateLabels($testShema)));
        
        
        $f1 = $ctrl->generateApiContent('file\\namespace', 'TestModel', '\\path\\to\\model');
        $f2 = $ctrl->generateControllerContent('file\\namespace', 'TestModel', '\\path\\to\\model');
        $f3 = $ctrl->generateModelContent(
            'file\\namespace',
            'TestModel',
            'api-endpoint-name',
            Yii::$app->db->getTableSchema('admin_user', true)
        );
        
        $f4 = $ctrl->generateBuildSummery('api-endpoit-name', '\\path\\to\\api\\Model', 'AdminUser', 'module-adminuser-index');
        
    }
}
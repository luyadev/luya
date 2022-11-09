<?php

namespace luyatests\core\console\commands;

use luya\console\commands\ImportController;
use luyatests\data\modules\importermodule\Module;
use Yii;

class ImportControllerTest extends \luyatests\LuyaConsoleTestCase
{
    public function testCustomCommandSuccess()
    {
        Yii::$app->request->setParams([
            'import/index',
        ]);

        $resp = Yii::$app->run();

        $this->assertEquals(0, $resp);
    }

    public function testFileScanner()
    {
        Yii::$app->setModules([
            'importermodule' => ['class' => Module::class],
        ]);
        Yii::$app->getModule('importermodule'); // re init the bootstrapc process
        $ctrl = new ImportController('import-runner', Yii::$app);
        $ctrl->actionIndex();

        $files = $ctrl->getDirectoryFiles('blocks');

        $this->assertNotEmpty($files);
        $this->assertArrayHasKey(0, $files);

        $this->assertSame('ImportTestFile.php', $files[0]['file']);
    }

    public function testImporterQueue()
    {
        Yii::$app->setModules([
            'importermodule' => ['class' => Module::class],
        ]);
        Yii::$app->getModule('importermodule'); // re init the bootstrapc process
        $ctrl = new ImportController('import-runner', Yii::$app);
        $this->assertEmpty($ctrl->buildImporterQueue());
    }
}

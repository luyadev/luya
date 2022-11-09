<?php

namespace luyatests\core\console;

use luya\console\commands\ImportController;
use luya\console\Importer;
use luyatests\LuyaConsoleTestCase;
use Yii;

class StubImporter extends Importer
{
    public function run()
    {
        return $this->importer->id;
    }

    public function getTestModuleId()
    {
        return $this->module->id;
    }
}

class ImporterTest extends LuyaConsoleTestCase
{
    public function testInstance()
    {
        $importRunner = new ImportController('import-runner', Yii::$app);

        $import = new StubImporter($importRunner, Yii::$app->getModule('unitmodule'));
        $this->assertSame('import-runner', $import->run());
        $this->assertSame('unitmodule', $import->getTestModuleId());

        $import->addLog('value');

        $this->assertArrayHasKey('luyatests\core\console\StubImporter', $importRunner->getLog());
    }
}

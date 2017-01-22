<?php

namespace luyatests\core\console;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\Importer;
use luya\console\commands\ImportController;

class StubImporter extends Importer
{
    public function run()
    {
        return $this->importer->id;
    }
}

class ImporterTest extends LuyaConsoleTestCase
{
    public function testInstance()
    {
        $importRunner = new ImportController('import-runner', Yii::$app);
        
        $import = new StubImporter($importRunner);
        $this->assertSame('import-runner', $import->run());
        
        $import->addLog('value');
        
        $this->assertArrayHasKey('luyatests\core\console\StubImporter', $importRunner->getLog());
    }
}

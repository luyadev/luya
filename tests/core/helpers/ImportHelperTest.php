<?php

namespace luyatests\core\helpers;

use luyatests\LuyaWebTestCase;
use luya\helpers\ExportHelper;
use luya\helpers\ImportHelper;

class ImportHelperTest extends LuyaWebTestCase
{
    public function testCsvToArray()
    {
        $csv = ExportHelper::csv([['firstname' => 'John', 'lastname' => 'Doe'], ['firstname' => 'Jane', 'lastname' => 'Doe']]);
        
        $this->assertSame([
            0 => ['firstname', 'lastname'],
            1 => ['John', 'Doe'],
            2 => ['Jane', 'Doe'],
        ], ImportHelper::csv($csv));
        
        $this->assertSame([
            0 => ['John', 'Doe'],
            1 => ['Jane', 'Doe'],
        ], ImportHelper::csv($csv, ['removeHeader' => true]));
        
        $this->assertSame([
            0 => ['John'],
            1 => ['Jane'],
        ], ImportHelper::csv($csv, ['removeHeader' => true, 'fields' => [0]]));
        
        $this->assertSame([
            0 => ['lastname'],
            1 => ['Doe'],
            2 => ['Doe'],
        ], ImportHelper::csv($csv, ['fields' => [1]]));
        
        $this->assertSame([
            0 => ['John'],
            1 => ['Jane'],
        ], ImportHelper::csv($csv, ['removeHeader' => true, 'fields' => ['firstname']]));
    }
    
    public function testCsvWithNewline()
    {
        $csv = ExportHelper::csv([['firstname' => 'John', 'text' => 'Hello' . PHP_EOL . 'World'], ['firstname' => 'Jane', 'text' => 'World\nHello']]);
        
        $this->assertSame([
            0 => ['firstname', 'text'],
            1 => ['John', 'Hello' . PHP_EOL . 'World'],
            2 => ['Jane', 'World\nHello'],
        ], ImportHelper::csv($csv));
    }
}

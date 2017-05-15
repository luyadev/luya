<?php

namespace admintests;

use Yii;
use luya\testsuite\traits\MigrationFileCheckTrait;

class MigrationsFileTest extends AdminTestCase
{
    use MigrationFileCheckTrait;
    
    public function testMigrations()
    {
        $this->checkMigrationFolder('@admin/migrations');
    }
}

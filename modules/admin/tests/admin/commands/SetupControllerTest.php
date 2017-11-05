<?php

namespace admintests\admin\commands;

use admintests\AdminTestCase;
use luya\admin\commands\SetupController;
use luya\console\Application;

class SetupControllerTest extends AdminTestCase
{
    public function testIndexAction()
    {
        $app = new Application($this->getConfigArray());
        $ctrl = new SetupController('setup', $app);
        
        $this->assertInstanceOf('\luya\admin\commands\SetupController', $ctrl);
    }
}

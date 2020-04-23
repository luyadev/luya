<?php

namespace luyatests\data\commands;

use luya\console\Command;

class TestConsoleCommand extends Command
{
    public function actionFoo()
    {
        return 'bar';
    }
}

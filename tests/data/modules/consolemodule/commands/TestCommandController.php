<?php

namespace luyatests\data\modules\consolemodule\commands;

use luya\console\Command;

class TestCommandController extends Command
{
    public function actionSuccess()
    {
        return $this->outputSuccess('success');
    }

    public function actionError()
    {
        return $this->outputError('error');
    }

    public function actionInfo()
    {
        return $this->outputInfo('info');
    }
}

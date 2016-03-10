<?php

namespace luyatests\data\modules\unitmodule\commands;

class CommandOutputController extends \luya\console\Command
{
    public function actionSuccess()
    {
        return $this->outputSuccess('Successfull output!');
    }

    public function actionError()
    {
        return $this->outputError('Failing output!');
    }
}

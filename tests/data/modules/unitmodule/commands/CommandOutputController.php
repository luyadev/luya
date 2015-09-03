<?php

namespace tests\data\modules\unitmodule\commands;

class CommandOutputController extends \luya\base\Command
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

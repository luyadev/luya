<?php

namespace luya\base;

use Yii;
use yii\helpers\Console;

abstract class Command extends \yii\console\Controller
{
    public function isMuted()
    {
        return Yii::$app->mute;
    }

    protected function output($message, $color = false)
    {
        if (!$this->isMuted()) {
            echo $this->ansiFormat("\r".$message."\n", $color);
        }
    }

    public function outputError($message)
    {
        $this->output($message, Console::FG_RED);

        return false;
    }

    public function outputSuccess($message)
    {
        $this->output($message, Console::FG_GREEN);

        return true;
    }
}

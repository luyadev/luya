<?php

namespace luya\base;

use Yii;
use yii\helpers\Console;

/**
 * Base class for all LUYA commands.
 * 
 * @author nadar
 */
abstract class Command extends \yii\console\Controller
{
    /**
     * Helper method to see if the current Application is muted or not. If the Application is muted, no output
     * will displayed.
     * 
     * @return boolean
     */
    public function isMuted()
    {
        return Yii::$app->mute;
    }

    /**
     * Helper method for writting console application output, include before and after wrappers.
     * 
     * @param string $message The message which is displayed
     * @param string $color A color from \yii\helpers\Console::FG_GREEN;
     * @param return void
     */
    protected function output($message, $color = null)
    {
        $format = [];
        if (!$this->isMuted()) {
            if ($color !== null) {
                $format[] = $color;
            }
            echo $this->ansiFormat("\r".$message."\n", $format);
        }
    }

    /**
     * Helper method to stop the console command with an error message, outputError returns exit code 1.
     * 
     * @param string $message The message which should be displayed.
     * @return number Exit code 1
     */
    public function outputError($message)
    {
        $this->output($message, Console::FG_RED);

        return 1;
    }

    /**
     * Helper method to stop the console command with a success message, outputSuccess returns exit code 0.
     * 
     * @param string $message The message which sould be displayed
     * @return number Exit code 0
     */
    public function outputSuccess($message)
    {
        $this->output($message, Console::FG_GREEN);

        return 0;
    }
}

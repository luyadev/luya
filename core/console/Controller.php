<?php

namespace luya\console;

use Yii;
use yii\helpers\Console;

/**
 * Console Controller base class.
 *
 * Extends the base controller by adding helper methods to output responses based on its
 * muted behavior to run unit tests without respones.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Controller extends \yii\console\Controller
{
    /**
     * Helper method to see if the current Application is muted or not. If the Application is muted, no output
     * will displayed.
     *
     * @return bool
     */
    public function isMuted()
    {
        return Yii::$app->mute;
    }

    /**
     * Helper method for writting console application output, include before and after wrappers.
     *
     * @param string $message The message which is displayed
     * @param string $color A color from {{\yii\helpers\Console}} color constants.
     * @param return $color the ansi formated text via echo when muted is disabled.
     */
    protected function output($message, $color = null)
    {
        $format = [];
        if (!$this->isMuted()) {
            if ($color !== null) {
                $format[] = $color;
            }
            echo Console::ansiFormat("\r".$message."\n", $format);
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
    
    /**
     * Helper method to stop the console command with a info message which is threated in case of returns as success
     * but does have a different output color (blue). outputInfo returns exit code 0.
     *
     * @param string $message The message which sould be displayed.
     * @return number Exit code 0
     * @since 1.0.0-beta5
     */
    public function outputInfo($message)
    {
        $this->output($message, Console::FG_CYAN);
        
        return 0;
    }
}

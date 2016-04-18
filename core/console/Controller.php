<?php

namespace luya\console;

use Yii;
use yii\helpers\Console;
use yii\helpers\StringHelper;
use yii\helpers\Inflector;

/**
 * Base class for all LUYA commands.
 *
 * @author nadar
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
     * @param string $color   A color from \yii\helpers\Console::FG_GREEN;
     * @param return void
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
    
    // HELPER METHODS

    /**
     * Get selection list of all module types.
     *
     * @return string
     * @since 1.0.0-beta4
     */
    public function selectModuleType()
    {
        return $this->select('What type of Module you want to create?', [
            'frontend' => 'Frontend Modules are used to render views.',
            'admin' => 'Admin Modules are used when the Data-Managment should be done inside the Administration area.',
        ]);
    }
    
    /**
     * Get selection list for console commands with defined options.
     *
     * @param array $options Define behavior of the module selector prompt, options are name-value pairs. The following options are available:
     *
     * - onlyAdmin: boolean, if enabled all not admin modules will not be included
     * - hideCore: boolean, if enabled all core modules (from luya dev team) will be hidden.
     *
     * @return string The name (ID) of the selected module.
     * @since 1.0.0-beta4
     */
    public function selectModule(array $options = [])
    {
        $modules = [];
        foreach (Yii::$app->getModules() as $id => $object) {
            if (!$object instanceof \luya\base\Module) {
                continue;
            }
            if (isset($options['onlyAdmin'])) {
                if (!$object->isAdmin) {
                    continue;
                }
            }
    
            if (isset($options['hideCore'])) {
                if ($object->isCoreModule) {
                    continue;
                }
            }
            $modules[$id] = $id;
        }
    
        $text = (isset($options['text'])) ? $options['text'] : 'Please select a module:';
    
        return $this->select($text, $modules);
    }
    
    /**
     * Generates a class name with camelcase style and specific suffix, if not already provided
     *
     * @param string $string The name of the class, e.g.: hello_word would
     * @param string $suffix The suffix to append on the class name if not eixsts, e.g.: MySuffix
     * @return string The class name e.g. HelloWorldMySuffix
     * @since 1.0.0-beta4
     */
    public function createClassName($string, $suffix = false)
    {
        $name = Inflector::camelize($string);
    
        if ($suffix && StringHelper::endsWith($name, $suffix, false)) {
            $name = substr($name, 0, -(strlen($suffix)));
        }
    
        return $name . $suffix;
    }
    
    /**
     * Get the current Luya Version
     *
     * @return string
     * @since 1.0.0-beta4
     */
    public function getLuyaVersion()
    {
        return \luya\Boot::VERSION;
    }
}

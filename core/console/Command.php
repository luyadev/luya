<?php

namespace luya\console;

/**
 * Base class for all Commands
 * 
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Command extends \luya\console\Controller
{
    /**
     * @var boolean Whether the verbose printing is enabled from options parameter or not.
     */
    public $verbose = false;
    
    /**
     * @var boolean Whether the command is in interactive mode or not, provided by option paremeters.
     */
    public $interactive = true;
    
    /**
     * Method to print informations directly when verbose is enabled.
     * 
     * @param string $message
     * @param string $section
     */
    public function verbosePrint($message, $section = null)
    {
        if ($this->verbose) {
            $this->output((!empty($section)) ? $section . ': ' . $message : $message);
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \luya\console\Controller::options()
     */
    public function options($actionID)
    {
        return ['verbose', 'interactive'];
    }
}

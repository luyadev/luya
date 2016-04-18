<?php

namespace luya\console;

class Command extends \luya\console\Controller
{
    /**
     * @var boolean Whether the verbose printing is enabled from options parameter or not.
     */
    public $verbose = false;
    
    /**
     * @var boolean Whether the command is in interactive mode or not, provided by option paremeters.
     */
    public $interactive = true;
    
    public function verbosePrint($message)
    {
        if ($this->verbose) {
            $this->output($message);
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

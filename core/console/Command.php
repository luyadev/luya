<?php

namespace luya\console;

use Yii;

class Command extends \luya\console\Controller
{
    /**
     * @var Default option for all luya comamnds, to enable verbose output
     */
    public $verbose = false;
    
    /**
     * {@inheritDoc}
     * @see \yii\console\Controller::options()
     */
    public function options($actionID)
    {
        return ['verbose'];
    }
}

<?php

namespace luya\cli;

/**
 * Luya CLI Application.
 * 
 * @author nadar
 */
class Application extends \yii\console\Application
{
    /*
     * Use the application trait, providing shared methods and properties.
     */
    use \luya\traits\Application;

    /**
     * @var bool Mute the Applications ouput, this is used to make application
     *           cli tests with no output. The `luya\base\Command` output/print methods are listening
     *           to this property.
     */
    public $mute = false;
}

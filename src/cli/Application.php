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

    public $bootstrap = [
        'luya\cli\Bootstrap',
    ];
    
    /**
     * @var bool Mute the Applications ouput, this is used to make application
     *           cli tests with no output. The `luya\base\Command` output/print methods are listening
     *           to this property.
     */
    public $mute = false;
    
    public $controllerMap = [
        'migrate' => '\luya\commands\MigrateController',
        'crud' => '\luya\commands\CrudController',
        'module' => '\luya\commands\ModuleController',
        'command' => '\luya\commands\CommandController',
        'import' => '\luya\commands\ImportController',
        'setup' => '\luya\commands\SetupController',
        'health' => '\luya\commands\HealthController',
        'block' => '\luya\commands\BlockController',
    ];
    
    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge($this->luyaCoreComponents(), [
            'errorHandler' => ['class' => 'luya\cli\components\ErrorHandler'],
        ]);
    }
}

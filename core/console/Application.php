<?php

namespace luya\console;

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
     *           cli tests with no output. The `luya\console\Controller` output/print methods are listening
     *           to this property.
     */
    public $mute = false;

    public $controllerMap = [
        'migrate' => '\luya\console\commands\MigrateController',
        'crud' => '\luya\console\commands\CrudController',
        'module' => '\luya\console\commands\ModuleController',
        'command' => '\luya\console\commands\CommandController',
        'import' => '\luya\console\commands\ImportController',
        'setup' => '\luya\console\commands\SetupController',
        'health' => '\luya\console\commands\HealthController',
        'block' => '\luya\console\commands\BlockController',
        'storage' => '\luya\console\commands\StorageController',
        'aw' => '\luya\console\commands\ActiveWindowController',
    ];

    /**
     * {@inheritdoc}
     */
    public function coreComponents()
    {
        return array_merge($this->luyaCoreComponents(), [
            'errorHandler' => ['class' => 'luya\console\ErrorHandler'],
        ]);
    }
}

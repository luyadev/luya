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
     *           cli tests with no output. The `luya\base\Command` output/print methods are listening
     *           to this property.
     */
    public $mute = false;
    
    public $controllerMap = [
        'migrate' => '\luya\console\controllers\MigrateController',
        'crud' => '\luya\console\controllers\CrudController',
        'module' => '\luya\console\controllers\ModuleController',
        'command' => '\luya\console\controllers\CommandController',
        'import' => '\luya\console\controllers\ImportController',
        'setup' => '\luya\console\controllers\SetupController',
        'health' => '\luya\console\controllers\HealthController',
        'block' => '\luya\console\controllers\BlockController',
    ];
    
    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge($this->luyaCoreComponents(), [
            'errorHandler' => ['class' => 'luya\console\ErrorHandler'],
        ]);
    }
}

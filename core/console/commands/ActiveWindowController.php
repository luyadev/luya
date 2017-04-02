<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Inflector;
use luya\helpers\FileHelper;

/**
 * Command to create ActiveWindow classes.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ActiveWindowController extends \luya\console\Command
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';
    
    /**
     * @var string The suffix for an Active Window classes to generate.
     */
    public $suffix = 'ActiveWindow';
    
    /**
     * Render the view file with its parameters.
     *
     * @param string $className The class name to use.
     * @param string $namespace The namespace for the file.
     * @param string $moduleId The module identifier.
     * @return string
     */
    public function renderWindowClassView($className, $namespace, $moduleId)
    {
        $alias = Inflector::humanize(Inflector::camel2words($className));
        return $this->view->render('@luya/console/commands/views/aw/create.php', [
            'className' => $className,
            'namespace' => $namespace,
            'luyaText' => $this->getGeneratorText('aw/create'),
            'moduleId' => $moduleId,
            'alias' => $alias,
        ]);
    }
    
    /**
     * Create a new ActiveWindow class based on you properties.
     */
    public function actionCreate()
    {
        $name = $this->prompt("Please enter a name for the Active Window:", [
            'required' => true,
        ]);
        
        $className = $this->createClassName($name, $this->suffix);
        
        $moduleId = $this->selectModule(['text' => 'What module should '.$className.' belong to?', 'onlyAdmin' => true]);
        
        $module = Yii::$app->getModule($moduleId);
        
        $folder = $module->basePath . DIRECTORY_SEPARATOR . 'aws';
        
        $file = $folder . DIRECTORY_SEPARATOR . $className . '.php';
        
        $content = $this->renderWindowClassView($className, $module->getNamespace() . '\\aws', $moduleId);
        
        FileHelper::createDirectory($folder);
        
        if (FileHelper::writeFile($file, $content)) {
            return $this->outputSuccess("The Active Window file '$file' has been writtensuccessfull.");
        }
        
        return $this->outputError("Error while writing the Actice Window file '$file'.");
    }
}

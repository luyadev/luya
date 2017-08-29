<?php

namespace luya\admin\commands;

use Yii;
use yii\helpers\Inflector;
use luya\helpers\FileHelper;
use luya\console\Command;

/**
 * Command to create ActiveWindow classes.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ActiveWindowController extends Command
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
        return $this->view->render('@admin/commands/views/aw/classfile.php', [
            'className' => $className,
            'namespace' => $namespace,
            'luyaText' => $this->getGeneratorText('aw/create'),
            'moduleId' => $moduleId,
            'alias' => $alias,
        ]);
    }
    
    public function renderWindowClassViewFile($className, $moduleId)
    {
        return $this->view->render('@admin/commands/views/aw/viewfile.php', [
            'className' => $className,
            'moduleId' => $moduleId,
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
        
        $namespace = $module->getNamespace() . '\\aws';
        
        if (FileHelper::createDirectory($folder) && FileHelper::writeFile($file, $this->renderWindowClassView($className, $namespace, $moduleId))) {
            $object = Yii::createObject(['class' => $namespace . '\\' . $className]);
            
            if (FileHelper::createDirectory($object->getViewPath()) && FileHelper::writeFile($object->getViewPath() . DIRECTORY_SEPARATOR . 'index.php', $this->renderWindowClassViewFile($className, $moduleId))) {
                $this->outputInfo("View file generated.");
            }
            
            return $this->outputSuccess("Active Window '$file' created.");
        }
        
        return $this->outputError("Error while writing the Actice Window file '$file'.");
    }
}

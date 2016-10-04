<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Inflector;
use luya\helpers\FileHelper;

/**
 * Command to create ActiveWindow classes.
 *
 * @author nadar
 * @since 1.0.0-beta4
 */
class ActiveWindowController extends \luya\console\Command
{
    public $suffix = 'ActiveWindow';
    
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
        
        $content = $this->view->render('@luya/console/commands/views/aw/create.php', [
            'className' => $className,
            'namespace' => $module->getNamespace() . '\\aws',
            'luya' => $this->getLuyaVersion(),
            'moduleId' => $moduleId,
            'alias' => Inflector::humanize(Inflector::camel2words($className)),
        ]);
        
        FileHelper::createDirectory($folder);
        
        if (FileHelper::writeFile($file, $content)) {
            return $this->outputSuccess("The Active Window file '$file' has been writtensuccessfull.");
        }
        
        return $this->outputError("Error while writing the Actice Window file '$file'.");
    }
}

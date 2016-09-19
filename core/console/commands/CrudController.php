<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Console;
use yii\helpers\Inflector;
use luya\Boot;

/**
 * NgRest Crud console commands.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class CrudController extends \luya\console\Command
{
    private function getSqlTablesArray()
    {
        $names = Yii::$app->db->schema->tableNames;
        
        return array_combine($names, $names);
    }
    /**
     * Create Ng-Rest-Model, Controller and Api for an existing Database-Table.
     *
     * @return number
     */
    public function actionCreate()
    {
        $this->outputInfo("Make sure the module is added to your configuration.");
        $module = $this->selectModule(['onlyAdmin' => true, 'hideCore' => true, 'text' => 'Select the Module where the crud should be stored in:']);
        $modulePre = preg_replace('/admin$/', '', $module);
        
        $modelSelection = true;
        
        while ($modelSelection) {
            $modelName = $this->prompt('Model Name (e.g. Album):', ['required' => true]);
            
            $camlizeModelName = Inflector::camelize($modelName);
            
            if ($modelName !== $camlizeModelName) {
                if ($this->confirm("We have camlized the model name to '$camlizeModelName' do you want to continue with this name?")) {
                    $modelName = $camlizeModelName;
                    $modelSelection = false;
                }
            } else {
                $modelSelection = false;
            }
        }
        
        $apiEndpoint = $this->prompt('Api Endpoint:', ['required' => true, 'default' => 'api-'.$modulePre.'-'.strtolower($modelName).'']);

        $sqlSelection = true;
        while ($sqlSelection) {
            $sqlTable = $this->prompt('Database Table name:', ['required' => true, 'default' => strtolower($modulePre).'_'.Inflector::underscore($modelName)]);
            
            if ($sqlTable == '?') {
                foreach ($this->getSqlTablesArray() as $table) {
                    $this->outputInfo("- " . $table);
                }
            }
            
            if (isset($this->getSqlTablesArray()[$sqlTable])) {
                $sqlSelection = false;
            } else {
                $this->outputError("The selected database '$sqlTable' does not exists in the list of tables. Type '?' to see all tables.");
            }
        }

        if (!$this->confirm("Create '$modelName' controller, api & model based on sql table '$sqlTable' in module '$module' for api endpoint '$apiEndpoint'?")) {
            return $this->outputError('Crud creation aborted.');
        }

        $shema = Yii::$app->db->getTableSchema($sqlTable, true);

        if (!$shema) {
            return $this->outputError("Could not read informations from database table '$sqlTable', table does not exist.");
        }

        $yiiModule = Yii::$app->getModule($module);

        $basePath = $yiiModule->basePath;

        $ns = $yiiModule->getNamespace();

        $modelName = ucfirst($modelName);
        $fileName = ucfirst(strtolower($modelName));

        $modelNs = '\\'.$ns.'\\models\\'.$modelName;
        $data = [
            'api' => [
                'folder' => 'apis',
                'ns' => $ns.'\\apis',
                'file' => $fileName.'Controller.php',
                'class' => $fileName.'Controller',
                'route' => strtolower($module).'-'.strtolower($modelName).'-index',
            ],
            'controller' => [
                'folder' => 'controllers',
                'ns' => $ns.'\\controllers',
                'file' => $fileName.'Controller.php',
                'class' => $fileName.'Controller',
            ],
            'model' => [
                'folder' => 'models',
                'ns' => $ns.'\\models',
                'file' => $modelName.'.php',
                'class' => $modelName,
            ],
        ];
        $apiClass = null;
        foreach ($data as $name => $item) {
            $folder = $basePath.DIRECTORY_SEPARATOR.$item['folder'];

            if (!file_exists($folder)) {
                mkdir($folder);
            }

            $extended = true;
            
            if (file_exists($folder.DIRECTORY_SEPARATOR.$item['file'])) {
                if ($name == 'model') {
                    $this->outputInfo("Mode '".$item['file']."' exists already. Created an abstract NgRest model where you can extend from.");
                } else {
                    $this->outputInfo("File '".$item['file']."' exists already, created a .copy file instead.");
                }
                $item['file'] = $item['file'].'.copy';
                $extended = false;
            }
            
            $content = '<?php'.PHP_EOL.PHP_EOL;
            $content .= 'namespace '.$item['ns'].';'.PHP_EOL.PHP_EOL;
            switch ($name) {

                case 'api':
                    $content = $this->view->render('@luya/console/commands/views/crud/create_api.php', [
                        'className' => $item['class'],
                        'modelClass' => $modelNs,
                        'namespace' => $item['ns'],
                        'luyaVersion' => Boot::VERSION,
                    ]);
                    break;

                case 'controller':
                    $content = $this->view->render('@luya/console/commands/views/crud/create_controller.php', [
                        'className' => $item['class'],
                        'modelClass' => $modelNs,
                        'namespace' => $item['ns'],
                        'luyaVersion' => Boot::VERSION,
                    ]);
                    break;

                case 'model':

                    if (!$extended) {
                        $modelName = $modelName . 'NgRest';
                        $item['file'] = $modelName . '.php';
                        $item['class'] = $modelName;
                    }
                    
                    $names = [];
                    $allfields = [];
                    $fieldConfigs = [];
                    $textFields = [];
                    $i18n = [];
                    foreach ($shema->columns as $k => $v) {
                        if ($v->isPrimaryKey) {
                            continue;
                        }
                        
                        $allfields[] = $v->name;
                        $properties[$v->name] = $v->type;
                        
                        if ($v->type == 'text') {
                            $fieldConfigs[$v->name] = 'textarea';
                            $i18n[] = $v->name;
                            $names[] = $v->name;
                            $textFields[] = $v->name;
                        }
                        if ($v->type == 'string') {
                            $fieldConfigs[$v->name] = 'text';
                            $i18n[] = $v->name;
                            $names[] = $v->name;
                            $textFields[] = $v->name;
                        }
                        if ($v->type == 'integer' || $v->type == 'bigint' || $v->type == 'smallint') {
                            $fieldConfigs[$v->name] = 'number';
                            $names[] = $v->name;
                        }
                        
                        if ($v->type == 'decimal') {
                            $fieldConfigs[$v->name] = 'decimal';
                            $names[] = $v->name;
                        }
                        
                        if ($v->type == 'boolean') {
                            $fieldConfigs[$v->name] = 'toggleStatus';
                            $names[] = $v->name;
                        }
                    }
                    
                    $content = $this->view->render('@luya/console/commands/views/crud/create_model.php', [
                        'className' => $item['class'],
                        'modelClass' => $modelNs,
                        'namespace' => $item['ns'],
                        'luyaVersion' => Boot::VERSION,
                        'apiEndpoint' => $apiEndpoint,
                        'sqlTable' => $sqlTable,
                        'fieldNames' => $names,
                        'allFieldNames' => $allfields,
                        'fieldConfigs' => $fieldConfigs,
                        'i18n' => $i18n,
                        'extended' => $extended,
                        'textFields' => $textFields,
                        'properties' => $properties,
                    ]);
                    
                    break;
            }

            
            
            if (file_put_contents($folder.DIRECTORY_SEPARATOR.$item['file'], $content)) {
                echo $this->ansiFormat('- File '.$folder.DIRECTORY_SEPARATOR.$item['file'].' created.', Console::FG_GREEN).PHP_EOL;
            }
        }

        $getMenu = 'public function getMenu()
{
    return $this->node(\''.Inflector::humanize($modelName).'\', \'extension\') // instead of extension, choose icon from https://design.google.com/icons/
        ->group(\'GROUP\')
            ->itemApi(\''.Inflector::humanize($modelName).'\', \''.$data['api']['route'].'\', \'label\', \''.$apiEndpoint.'\') // instead of label, choose icon from https://design.google.com/icons/
    ->menu();
}
            ';

        $mname = $this->ansiFormat($basePath.'/Module.php', Console::BOLD);
        $a = $this->ansiFormat('$apis', Console::BOLD);
        echo PHP_EOL.'Modify the '.$a.' var in '.$mname.' like below:'.PHP_EOL.PHP_EOL;
        echo $this->ansiFormat('public $apis = [
    \''.$apiEndpoint.'\' => \''.$data['api']['ns'].'\\'.$data['api']['class'].'\',
];', Console::FG_YELLOW);
        echo PHP_EOL.PHP_EOL.'Update the getMenu() method like below:'.PHP_EOL.PHP_EOL;
        echo $this->ansiFormat($getMenu, Console::FG_YELLOW);
        echo PHP_EOL;

        return 0;
    }
}

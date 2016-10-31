<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Console;
use yii\helpers\Inflector;
use yii\db\TableSchema;
use luya\Boot;
use luya\helpers\FileHelper;

/**
 * Console command to create a NgRest Crud with Controller, Api and Model based on a SQL Table.
 *
 * @property string $moduleNameWithoutAdminSuffix Get the $moduleName without admin suffix (if any).
 * @author Basil Suter <basil@nadar.io>
 */
class CrudController extends BaseCrudController
{
    /**
     * @var string The name of the module which should be used in order to generate the crud structure e.g `cmsadmin`.
     */
    public $moduleName = null;
    
    /**
     * @var string The name of the model in camelcase notation e.g `NavItem`.
     */
    public $modelName = null;
    
    /**
     * @var string The name of the API endpoint based on the modelName und moduleName selections e.g `api-cms-navitem`.
     */
    public $apiEndpoint = null;
    
    /**
     * @var string The name of the corresponding model database table e.g. `cms_navitem`.
     */
    public $dbTableName = null;
    
    /**
     * Get the $moduleName without admin suffix (if any).
     * 
     * @return mixed Return the module name without admin suffix.
     */
    public function getModuleNameWithoutAdminSuffix()
    {
        return preg_replace('/admin$/', '', $this->moduleName);
    }
    
    public function getModelNameLower()
    {
        return strtolower($this->modelName);
    }
    
    public function getModelNameCamlized()
    {
        return Inflector::camelize($this->modelName);
    }
    
    public function getModelNamespace()
    {
        return $this->getNamespace() . '\\models\\' . $this->getModelNameCamlized();
    }
    
    public function getApiEndpointSuggestion()
    {
        return 'api-'.$this->getModuleNameWithoutAdminSuffix().'-'.$this->getModelNameLower();
    }
    
    public function getDatabaseNameSuggestion()
    {
        return strtolower($this->getModuleNameWithoutAdminSuffix().'_'.Inflector::underscore($this->modelName));
    }
    
    private $_dbTableShema = null;
    
    public function getDbTableShema()
    {
        if ($this->_dbTableShema === null) {
            $this->_dbTableShema = Yii::$app->db->getTableSchema($this->dbTableName, true);
        }
        
        return $this->_dbTableShema;
    }
    
    public function getModule()
    {
        return Yii::$app->getModule($this->moduleName);
    }
    
    public function getBasePath()
    {
        return $this->getModule()->basePath;
    }
    
    public function getNamespace()
    {
        return $this->getModule()->getNamespace();
    }
    
    public function getSummaryControllerRoute()
    {
        return strtolower($this->moduleName).'/'.Inflector::camel2id($this->getModelNameCamlized()).'/index';
    }
    
    public function generateApiContent($fileNamespace, $className, $modelClass)
    {
        return $this->view->render('@luya/console/commands/views/crud/create_api.php', [
            'namespace' => $fileNamespace,
            'className' => $className,
            'modelClass' =>  $modelClass,
            'luyaVersion' => Boot::VERSION,
        ]);
    }
    
    public function generateControllerContent($fileNamespace, $className, $modelClass)
    {
        return $this->view->render('@luya/console/commands/views/crud/create_controller.php', [
            'namespace' => $fileNamespace,
            'className' => $className,
            'modelClass' =>  $modelClass,
            'luyaVersion' => Boot::VERSION,
        ]);
    }
    
    public function generateModelContent($fileNamepsace, $className, $apiEndpoint, TableSchema $schema)
    {
        $dbTableName = $schema->fullName;
        
        $fields = [];
        $textfields = [];
        $properties = [];
        $ngrestFieldConfig = [];
        foreach ($schema->columns as $k => $v) {
            $properties[$v->name] = $v->type;
            if ($v->isPrimaryKey) {
                continue;
            }
            $fields[] = $v->name;
            
            if ($v->phpType == 'string') {
                $textfields[] = $v->name;
            }
            
            if ($v->type == 'text') {
                $ngrestFieldConfig[$v->name] = 'textarea';
            }
            if ($v->type == 'string') {
                $ngrestFieldConfig[$v->name] = 'text';
            }
            if ($v->type == 'integer' || $v->type == 'bigint' || $v->type == 'smallint') {
                $ngrestFieldConfig[$v->name] = 'number';
            }
            if ($v->type == 'decimal') {
                $ngrestFieldConfig[$v->name] = 'decimal';
            }
            if ($v->type == 'boolean') {
                $ngrestFieldConfig[$v->name] = 'toggleStatus';
            }
        };
        
        return $this->view->render('@luya/console/commands/views/crud/create_model.php', [
            'namespace' => $fileNamepsace,
            'className' => $className,
            'luyaVersion' => Boot::VERSION,
            'apiEndpoint' => $apiEndpoint,
            'dbTableName' => $dbTableName,
            'fields' => $fields,
            'textFields' => $textfields,
            'rules' => $this->generateRules($schema),
            'labels' => $this->generateLabels($schema),
            'properties' => $properties,
            'ngrestFieldConfig' => $ngrestFieldConfig
        ]);
    }

    public function generateBuildSummery($apiEndpoint, $apiClassPath, $humanizeModelName, $controllerRoute)
    {
        return $this->view->render('@luya/console/commands/views/crud/build_summary.php', [
            'apiEndpoint' => $apiEndpoint,
            'apiClassPath' => $apiClassPath,
            'humanizeModelName' => $humanizeModelName,
            'controllerRoute' => $controllerRoute,
        ]);
    }
    
    /**
     * Create Ng-Rest-Model, Controller and Api for an existing Database-Table.
     *
     * @return number
     */
    public function actionCreate()
    {
        if ($this->moduleName === null) {
            Console::clearScreenBeforeCursor();
            $this->moduleName = $this->selectModule(['onlyAdmin' => true, 'hideCore' => true, 'text' => 'Select the Module where the CRUD files should be saved:']);
        }

        // $module = ;
        // $modulePre = preg_replace('/admin$/', '', $module);
        
        if ($this->modelName === null) {
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
                $this->modelName = $modelName;
            }
        }
        
        // $modelName
        
        
        // $apiEndpoint
        
        if ($this->apiEndpoint === null) {
            $this->apiEndpoint = $this->prompt('Api Endpoint:', ['required' => true, 'default' => $this->getApiEndpointSuggestion()]);
        }

        
        // $sqlTable
        if ($this->dbTableName === null) {
            $sqlSelection = true;
            while ($sqlSelection) {
                $sqlTable = $this->prompt('Database Table name for the Model:', ['required' => true, 'default' => $this->getDatabaseNameSuggestion()]);
                if ($sqlTable == '?') {
                    foreach ($this->getSqlTablesArray() as $table) {
                        $this->outputInfo("- " . $table);
                    }
                }
                if (isset($this->getSqlTablesArray()[$sqlTable])) {
                    $this->dbTableName = $sqlTable;
                    $sqlSelection = false;
                } else {
                    $this->outputError("The selected database '$sqlTable' does not exists in the list of tables. Type '?' to see all tables.");
                }
            }
        }

        //$shema = Yii::$app->db->getTableSchema($sqlTable, true);

        /*
        if (!$shema) {
            return $this->outputError("Could not read informations from database table '$sqlTable', table does not exist.");
        }
        */

        // api content
        
        $files['api'] = [
            'path' => $this->getBasePath() . DIRECTORY_SEPARATOR . 'apis',
            'fileName' => $this->getModelNameCamlized() . 'Controller.php',
            'content' => $this->generateApiContent($this->getNamespace() . '\\apis', $this->getModelNameCamlized() . 'Controller', $this->getModelNamespace()),
        ];
        
        // controller
        
        $files['controller'] = [
            'path' =>  $this->getBasePath() . DIRECTORY_SEPARATOR . 'controllers',
            'fileName' => $this->getModelNameCamlized() . 'Controller.php',
            'content' => $this->generateControllerContent($this->getNamespace() . '\\controllers', $this->getModelNameCamlized() . 'Controller', $this->getModelNamespace()),
        ];
        
        // model
        
        $files['model'] = [
            'path' =>  $this->getBasePath() . DIRECTORY_SEPARATOR . 'models',
            'fileName' => $this->getModelNameCamlized() . '.php',
            'content' => $this->generateModelContent(
                $this->getNamespace() . '\\models',
                $this->getModelNameCamlized(),
                $this->apiEndpoint,
                $this->getDbTableShema()
             ),
        ];
        
        foreach ($files as $file) {
            FileHelper::createDirectory($file['path']);
            if (file_exists($file['path'] . DIRECTORY_SEPARATOR . $file['fileName'])) {
                if (!$this->confirm("The File '{$file['fileName']}' already exists, do you want to override the existing file?")) {
                    continue;
                }
            }
            
            if (FileHelper::writeFile($file['path'] . DIRECTORY_SEPARATOR . $file['fileName'], $file['content'])) {
                $this->outputSuccess("Wrote file '{$file['fileName']}'.");
            } else {
                $this->outputError("Error while writing file '{$file['fileName']}'.");
            }
        }
        
        return $this->outputSuccess($this->generateBuildSummery($this->apiEndpoint, $this->getNamespace() . '\\apis\\' . $this->getModelNameCamlized() . 'Controller', $this->getModelNameCamlized(), $this->getSummaryControllerRoute()));
        /*
       // $yiiModule = Yii::$app->getModule($module);

        //$basePath = $yiiModule->basePath;

        //$ns = $yiiModule->getNamespace();

        //$modelName = ucfirst($modelName);
       // $fileName = ucfirst(strtolower($modelName));

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
                        'rules' => $this->generateRules($shema),
                    ]);
                    
                    break;
            }

            
            
            if (file_put_contents($folder.DIRECTORY_SEPARATOR.$item['file'], $content)) {
                echo $this->ansiFormat('- File '.$folder.DIRECTORY_SEPARATOR.$item['file'].' created.', Console::FG_GREEN).PHP_EOL;
            }
        }

        $getMenu = 'public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))->node(\''.Inflector::humanize($modelName).'\', \'extension\') // instead of extension and label, choose icon from https://design.google.com/icons/
        ->group(\'GROUP\')
            ->itemApi(\''.Inflector::humanize($modelName).'\', \''.$data['api']['route'].'\', \'label\', \''.$apiEndpoint.'\');
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
        */
    }
}

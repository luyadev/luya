<?php

namespace luya\commands;

use Yii;
use yii\helpers\Console;

class CrudController extends \yii\console\Controller
{

    public function actionCreate()
    {
        /*
        $module = $this->prompt('Module Name (e.g. galleryadmin):');
        $modelName = $this->prompt('Model Name (e.g. Album)');
        $apiEndpoint = $this->prompt('Api Endpoint (e.g. api-gallery-album)');
        $sqlTable = $this->prompt('Database Table name (e.g. gallery_album)');
        */
        
        $module = 'estore';
        $modelName = 'Foo';
        $apiEndpoint = 'api-estore-foo';
        $sqlTable = 'my_sql_table';
        
        /*
        if (!$this->confirm("Create '$modelName' data (controller, api, model) in module '$module' ?")) {
            exit(1);
        }
        */
        
        $yiiModule = Yii::$app->getModule($module);
        
        $basePath = $yiiModule->basePath;
        
        $ns = $yiiModule->getNamespace();
        
        $modelName = ucfirst($modelName);
        
        $modelNs = '\\' . $ns . '\\models\\' . $modelName;
        $data = [
            'api' => [
                'folder' => 'apis',
                'ns' => $ns . '\\apis',
                'file' => $modelName . 'Controller.php',
                'class' => $modelName . 'Controller',
                'route' => strtolower($module) . '-' . strtolower($modelName) . '-index',
            ],
            'controller' => [
                'folder' => 'controllers',
                'ns' => $ns . '\\controllers',
                'file' => $modelName . 'Controller.php',
                'class' => $modelName . 'Controller',
            ],
            'model' => [
                'folder' => 'models',
                'ns' => $ns . '\\models',
                'file' => $modelName . '.php',
                'class' => $modelName,
            ]
        ];
        $apiClass = null;
        foreach($data as $name => $item) {
            $folder = $basePath . DIRECTORY_SEPARATOR . $item['folder'];
            
            if (!file_exists($folder)) {
                mkdir($folder);
            }
            
            if (file_exists($folder . DIRECTORY_SEPARATOR . $item['file'])) {
                echo "Die Datei $folder" . DIRECTORY_SEPARATOR . $item['file'] . "existiert bereits!";
            } else {
                
                $content = '<?php' . PHP_EOL . PHP_EOL;
                $content.= 'namespace ' . $item['ns'] . ';' . PHP_EOL . PHP_EOL;
                switch($name) {
                    
                    case "api":
                        $content.= 'class '.$item['class'].' extends \admin\base\RestActiveController' . PHP_EOL;
                        $content.= '{' . PHP_EOL;
                        $content.= '    public $modelClass = \''.$modelNs.'\';' . PHP_EOL;
                        $content.= '}';
                        break;
                        
                    case "controller":
                        $content.= 'class '.$item['class'].' extends \admin\ngrest\base\Controller' . PHP_EOL;
                        $content.= '{' . PHP_EOL;
                        $content.= '    public $modelClass = \''.$modelNs.'\';' . PHP_EOL;
                        $content.= '}';
                        break;
                        
                    case "model":
                        $content.= 'class '.$item['class'].' extends \admin\ngrest\base\Model' . PHP_EOL;
                        $content.= '{' . PHP_EOL;
                        $content.= '    public static function tableName()' . PHP_EOL;
                        $content.= '    {' . PHP_EOL;
                        $content.= '        return \''.$sqlTable.'\';' . PHP_EOL;
                        $content.= '    }' . PHP_EOL . PHP_EOL;
                        $content.= '    public function scenarios()' . PHP_EOL;
                        $content.= '    {' . PHP_EOL;
                        $content.= '        return [' . PHP_EOL;
                        $content.= '            \'restcreate\' => [],' . PHP_EOL;
                        $content.= '            \'restupdate\' => [],' . PHP_EOL;
                        $content.= '        ];' . PHP_EOL;
                        $content.= '    }' . PHP_EOL . PHP_EOL;
                        $content.= '    public function ngRestApiEndpoint()' . PHP_EOL;
                        $content.= '    {' . PHP_EOL;
                        $content.= '         return \''.$apiEndpoint.'\';' . PHP_EOL;
                        $content.= '    }' . PHP_EOL . PHP_EOL;
                        $content.= '    public function ngRestConfig($config)' . PHP_EOL;
                        $content.= '    {' . PHP_EOL . PHP_EOL;
                        $content.= '         // defined your ngrest config here' . PHP_EOL;
                        $content.= '         return $config;' . PHP_EOL;
                        $content.= '    }' . PHP_EOL;
                        $content.= '}';
                        break;
                }
                
                if(file_put_contents($folder . DIRECTORY_SEPARATOR . $item['file'], $content)) {
                    echo $this->ansiFormat('- File ' . $folder . DIRECTORY_SEPARATOR . $item['file'] . ' created.', Console::FG_GREEN) . PHP_EOL;
                }
            }
            

        }
        
        $getMenu = 'public function getMenu()
{
    return $this->node(\'Kalender\', \'mdi-action-today\')
        ->group(\'Daten\')
            ->itemApi(\'YOUR NAME\', \''.$data['api']['route'].'\', \'matteriliaze-icon-class-name\', \''.$apiEndpoint.'\')
    ->menu();
}
            ';
        
        $mname = $this->ansiFormat($basePath . '/Module.php', Console::BOLD);
        $a = $this->ansiFormat('$apis', Console::BOLD);
        echo PHP_EOL . 'Modify the '.$a.' var in ' . $mname . ' like below:' . PHP_EOL . PHP_EOL;
        echo $this->ansiFormat('public static $apis = [
    \''.$apiEndpoint.'\' => \''.$data['api']['ns'].'\\' . $data['api']['class'].'\',
];', Console::FG_YELLOW);
        echo PHP_EOL . PHP_EOL . 'Update the getMenu() method like below:' . PHP_EOL . PHP_EOL;
        echo $this->ansiFormat($getMenu, Console::FG_YELLOW);
        echo PHP_EOL;
    }
}
<?php

namespace luya\commands;

use Yii;
use yii\helpers\Console;

class ModuleController extends \luya\base\Command
{
    public function actionCreate()
    {
        \yii\helpers\Console::clearScreenBeforeCursor();
        $moduleType = $this->select("What kind of Module you want to create?", ['frontend' => 'Frontend Modules are mainly used to render views.', 'admin' => 'Admin Modules are mainly used when you Data-Managment should be done inside the Administration area.']);
        switch($moduleType) {
            case "admin":
                $isAdmin = true;
                $text = 'Name of your new Admin-Module (e.g. newsadmin)';
                break;
            case "frontend":
                $isAdmin = false;
                $text = 'Name of your new Frontend-Module (e.g. news)';
                break;
        }
        
        $moduleName = $this->prompt($text);
        
        if ($isAdmin && substr($moduleName, -5) !== "admin") {
            echo $this->ansiFormat("The provided Modulename ($moduleName) must have the suffix 'admin' as it is an Admin-Module!", Console::FG_RED) . PHP_EOL;
            exit(1);
        }
        
        if (!$this->confirm("Are you sure you want to create the " . (($isAdmin) ? "Admin" : "Frontend") . " Module '" . $moduleName . "' now?")) {
            exit(1);
        }
        
        $basePath = Yii::$app->basePath;
        
        $modulesDir = $basePath . DIRECTORY_SEPARATOR . 'modules';
       
        if (!file_exists($modulesDir)) {
            mkdir($modulesDir);
        }
        
        $moduleDir = $modulesDir . DIRECTORY_SEPARATOR . $moduleName;
        
        if (!file_exists($moduleDir)) {
            mkdir($moduleDir);
        } else {
            echo $this->ansiFormat("The Module '$moduleName' folder already exists!", Console::FG_RED) . PHP_EOL;
            exit(1);
        }
        
        $content = '<?php' . PHP_EOL;
        $content.= 'namespace app\modules\\' . $moduleName . ';' . PHP_EOL . PHP_EOL;
        $content.= 'class Module extends ' . (($isAdmin) ? '\admin\base\Module' : 'luya\base\Module') . PHP_EOL;
        $content.= '{' . PHP_EOL;
        $content.= '    // add your custom Module properties here.' . PHP_EOL;
        $content.= '}';
        
        if (file_put_contents($moduleDir . DIRECTORY_SEPARATOR . 'Module.php', $content)) {
            
        } else {
            
        }
    }
}
<?php

namespace luya\console\commands;

use Yii;
use yii\helpers\Console;

/**
 * Command to create LUYA modules.
 * 
 * @author Basil Suter <basil@nadar.io>
 *
 */
class ModuleController extends \luya\console\Command
{
    /**
     * Create a new frontend/admin module.
     * 
     * @return number
     */
    public function actionCreate()
    {
        Console::clearScreenBeforeCursor();
        $moduleType = $this->select('What kind of Module you want to create?', ['frontend' => 'Frontend Modules are mainly used to render views.', 'admin' => 'Admin Modules are mainly used when you Data-Managment should be done inside the Administration area.']);
        switch ($moduleType) {
            case 'admin':
                $isAdmin = true;
                $text = 'Name of your new Admin-Module (e.g. newsadmin)';
                break;
            case 'frontend':
                $isAdmin = false;
                $text = 'Name of your new Frontend-Module (e.g. news)';
                break;
        }

        $moduleName = $this->prompt($text);

        if ($isAdmin && substr($moduleName, -5) !== 'admin') {
            return $this->outputError("The provided Modulename ($moduleName) must have the suffix 'admin' as it is an Admin-Module!");
        }

        if (!$this->confirm('Are you sure you want to create the '.(($isAdmin) ? 'Admin' : 'Frontend')." Module '".$moduleName."' now?")) {
            return $this->outputError('abort by user.');
        }

        $basePath = Yii::$app->basePath;

        $modulesDir = $basePath.DIRECTORY_SEPARATOR.'modules';

        if (!file_exists($modulesDir)) {
            mkdir($modulesDir);
        }

        $moduleDir = $modulesDir.DIRECTORY_SEPARATOR.$moduleName;

        if (!file_exists($moduleDir)) {
            mkdir($moduleDir);
        } else {
            return $this->outputError("The Module '$moduleName' folder already exists!");
        }

        $content = '<?php'.PHP_EOL;
        $content .= 'namespace app\modules\\'.$moduleName.';'.PHP_EOL.PHP_EOL;
        $content .= '/**'.PHP_EOL;
        $content .= ' * Module created with Luya Module Creator Version '.\luya\Boot::VERSION.' at '.date('d.m.Y H:i').PHP_EOL;
        $content .= ' */'.PHP_EOL;
        $content .= 'class Module extends '.(($isAdmin) ? '\admin\base\Module' : '\luya\base\Module').PHP_EOL;
        $content .= '{'.PHP_EOL;
        $content .= '    // add your custom Module properties here.'.PHP_EOL;
        $content .= '}';

        $modulephp = $moduleDir.DIRECTORY_SEPARATOR.'Module.php';

        if (file_put_contents($modulephp, $content)) {
            $out = PHP_EOL."'modules' => [".PHP_EOL;
            $out .= "    '$moduleName' => [".PHP_EOL;
            $out .= "        'class' => '\\app\\modules\\$moduleName\\Module'".PHP_EOL;
            $out .= '    ],'.PHP_EOL;
            $out .= ']'.PHP_EOL.PHP_EOL;

            return $this->outputSuccess($out);
        }

        return $this->outputError("Unable to write module file '$modulephp'.");
    }
}

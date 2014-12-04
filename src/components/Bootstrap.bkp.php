<?php
namespace luya\components;

use yii;
use yii\base\Application;
use yii\helpers\ArrayHelper;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @todo PROBLEM: all the modules will be loaded to set the alias
     * @param $app
     */
    public function bootstrap($app)
    {
        // define vars
        $modulesMenu = [];
        $moduleApis = [];
        $adminAssets = [];
        
        $deferred = [];
        
        var_dump($app);
        
        $app->apis[] = 'ja!';
        
        // get all modules
        foreach ($app->getModules() as $id => $moduleSource) {
            // each vars
            $module = Yii::$app->getModule($id);
            $path = $module->getBasePath();
            
            $isAdmin = property_exists($module, 'isAdmin') ? $module->isAdmin : false;
            // get all controller map entrys for this module
            if (property_exists($module, 'apis')) {
                foreach ($module->apis as $name => $class) {
                    $moduleApis[] = [
                        "name" => $name,
                        "class" => $class,
                        "module" => $id
                    ];
                }
            }
            // set alias for module
            Yii::setAlias("@$id", $path);
            // add the module param
            $this->paramAddModule($id, $isAdmin, $path);
            // merge admin assets, if any
            if ($isAdmin) {
                $adminAssets = ArrayHelper::merge($module->assets, $adminAssets);
            }
            // merge menu array, if any
            if ($isAdmin && method_exists($module, 'getMenu')) {
                $modulesMenu = ArrayHelper::merge($this->resolveMenu($module->getMenu()), $modulesMenu);
            }
        }
        
        /**
         * after all the modules have been loaded, and we have collected all the data from the modules,
         * we want to inject some informations back into the admin module (if its available).
         * 
         * Example: we have collected all rest api informations, and we have to set them into the admin module
         * to access them from the same url.
         * 
         * @todo: probably there is an event to fire, instead of using inject controllerMap, another possibility could
         * be to "not start" the initializer of each module and only collecting class data and later on fireing the initiliazer.
         */
        if ($app->getModule('admin')) {
            $app->getModule('admin')->injectControllerMap($moduleApis);
        }
        
        $this->paramAdd('moduleApis', $moduleApis);
        $this->paramAdd('modulesMenu', $modulesMenu);
        $this->paramAdd('adminAssets', $adminAssets);
    }
    
    private function paramAddModule($id, $isAdmin, $path)
    {
        Yii::$app->params['modules'][$id] = [
            'id' => $id ,
            'isAdmin' => $isAdmin,
            'basePath' => $path
        ];
    }
    
    private function paramAdd($param, $value)
    {
        Yii::$app->params[$param] = $value;
    }
    
    private function resolveMenu($array)
    {
        // nothing to resolve yet...
        return $array;
    }
}

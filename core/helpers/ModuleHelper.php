<?php

namespace luya\helpers;

use Yii;
use luya\base\ModuleReflection;
use luya\Exception;

/**
 * Module Helper class
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class ModuleHelper
{
	/**
	 * Run a route of a module. The module will retrieved and the controller action
	 * paramters will used to load the right action.
	 * 
	 * @param string $route The route you want to run `<module>/<controller>/<action>`
	 * @param array $params Optional parameters for the action, the key is the method argument name.
	 * @throws Exception
	 * 
	 * @since 1.0.0-beta7
	 */
	public static function runRoute($route, array $params = [])
	{
		$parts = explode("/", $route);		
		
		$module = Yii::$app->getModule($parts[0]);
		$controller = (isset($parts[1])) ? $parts[1] : 'default';
		$action = (isset($parts[2])) ? $parts[2] : 'index';
		
		if ($module) {
			$module->context = 'cms';
			$object = static::reflectionObject($module);
			$object->defaultRoute($controller, $action, $params);
			return $object->run();
		}
		
		throw new Exception("Unable to find module '{$parts[0]}'");
	}
	
    /**
     * Create module reflection object based on a luya module.
     * 
     * @param \luya\base\Module $moduleObject The module 
     * @return \luya\base\ModuleReflection The reflection module object
     */
    public static function reflectionObject(\luya\base\Module $moduleObject)
    {
        return Yii::createObject(['class' => ModuleReflection::className(), 'module' => $moduleObject]);
    }
}

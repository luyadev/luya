<?php

namespace luya\cms\helpers;

use Yii;
use luya\cms\Exception;

/**
 * CMS Url Helper class extends luya\helpers\Url by CMS routing methods.
 *
 * In addition to the luya\helpers\Url method which is extend it also allows you to make url rule calls to
 * the cms specific contents. The CMS URL helper can only be used when the CMS module is loaded and used within
 * your project application.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Url extends \luya\helpers\Url
{
    /**
     * if the module could not be found (not registered in the cms) the method returns the provided module name.
     *
     * returns only ONE even if there are more! not good structure inside the cms?
     *
     * @param string $moduleName
     *
     * @return string The full_url from links component.
     */
    public static function toModule($moduleName)
    {
        $item = Yii::$app->menu->find()->where(['module_name' => $moduleName])->with(['hidden'])->one();

        if ($item) {
            return $item->link;
        }

        return $moduleName;
    }

    /**
     * Helper method to create a route based on the module name and the route and params.
     *
     * Use the route as defined in the modules' $urlRules array in order to generate the URL according
     * to the rules' pattern. Example:
     *
     * ```php
     * Url::toModuleRoute('blog', ['/blog/default/index', 'year' => 2016, 'month' => '07]);
     * ```
     *
     * generates the following URL, assuming the blog module is located on the CMS page /my-super-blog:
     *
     * /my-super-blog/2016/07
     *
     * according to the following URL rule:
     *
     * ```php
     * public $urlRules = [
     *     ['pattern' => 'blog/<year:\d{4}>/<month:\d{2}>', 'route' => 'blog/default/index'],
     * ];
     * ```
     *
     *
     * @param string $moduleName The ID of the module, which should be found inside the nav items.
     * @param string|array $route The route of the module `module/controller/action` or an array like in Url::to with param infos `['/module/controller/action', 'foo' => 'bar']`.
     * @param array  $params The parameters for the url rule. If the route is provided as an array with params the further defined params or overwritten by the array_merge process.
     * @throws Exception
     * @return string
     * @see \luya\helpers\Url::toModule()
     */
    public static function toModuleRoute($moduleName, $route, array $params = [])
    {
        $item = Yii::$app->menu->find()->where(['module_name' => $moduleName])->with(['hidden'])->one();
        
        if (!empty($params)) {
            trigger_error('third argument $params is deprecated use the array notation', E_USER_DEPRECATED);
        }
        
        
        if ($item) {
            return static::toMenuItem($item->id, $route, $params);
        }

        throw new Exception("The module route creation could not find the module '$moduleName'. Have you created a page with this module in this language context?");
    }

    /**
     * create an url based on a context nav item informaiton inside the urlManager.
     *
     * @param integer $navItemId The menu item Id where the url should be created from
     * @param string|array $route Can be a string `module/controller/action` or an array like in the Yii Url helpers::to methods `['/module/controller/action', 'param' => 'bar]`.
     * @param array $params An array with params which are going to be attached to the route.
     *
     * @return string
     */
    public static function toMenuItem($navItemId, $route, array $params = [])
    {
        if (is_array($route)) {
            $routeParams = array_merge($route, $params);
        } else {
            trigger_error('third argument $params is deprecated use the array notation', E_USER_DEPRECATED);
            
            $routeParams = [$route];
            foreach ($params as $key => $value) {
                $routeParams[$key] = $value;
            }
        }

        return Yii::$app->urlManager->createMenuItemUrl($routeParams, $navItemId);
    }
}

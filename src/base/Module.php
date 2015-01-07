<?php
namespace luya\base;

use yii;
use Exception;

/**
 *
 * @author nadar
 */
class Module extends \yii\base\Module
{
    /**
     *
     * @var array
     */
    public $requiredComponents = [];

    /**
     *
     * @var array
     */
    public $assets = [];

    /**
     * Contains the apis for each module to provided them in the admin module.
     * They represents the name of the api and the value represents the class.
     *
     * ```php
     * [
     *     'api-admin-user' => 'admin\apis\UserController',
     *     'api-cms-cat' => 'admin\apis\CatController'
     * ]
     * ```
     *
     * @var array
     */
    public static $apis = [];

    /**
     * Contains all urlRules for this module. Can't provided in key value pairing for pattern<=>route. must be array containing
     * class name or array with pattern, route informations.
     *
     * @var array
     */
    public static $urlRules = [];

    /**
     *
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        // verify all the components
        foreach ($this->requiredComponents as $component) {
            if (!Yii::$app->has($component)) {
                throw new Exception(sprintf('The required component "%s" is not registered in the configuration file', $component));
            }
        }
    }
}

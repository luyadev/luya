<?php
namespace cmsadmin\apis;

/**
 * Delivers default values for the specifing table. It means it does not return a key numeric array,
 * it does only return 1 assoc array wich reperents the default row.
 * @author nadar
 *
 */
class DefaultsController extends \admin\base\RestController
{
    public function actionCat()
    {
        return \cmsadmin\models\Cat::getDefault();
    }
}
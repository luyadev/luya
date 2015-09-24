<?php

namespace admin\apis;

use admin\models\Lang;
use admin\models\Property;

/**
 * Delivers default values for the specifing table. It means it does not return a key numeric array,
 * it does only return 1 assoc array wich reperents the default row.
 *
 * @author nadar
 */
class DefaultsController extends \admin\base\RestController
{
    public function actionLang()
    {
        return Lang::getDefault();
    }
    
    public function actionProperties()
    {
        return Property::find()->all();
    }
}

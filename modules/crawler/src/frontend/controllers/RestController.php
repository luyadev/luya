<?php

namespace luya\crawler\frontend\controllers;

use Yii;
use luya\crawler\models\Index;
use yii\helpers\Html;

/**
 * Rest API Controller for Index.
 * 
 * Returns the index data for a given query string as JSON/XML Response.
 * 
 * > This method does not inegrate CORS, so you can only call this api endpoint by the website itself.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RestController extends \luya\rest\Controller
{
    public function userAuthClass()
    {
        return false;
    }

    public function actionIndex($query = null)
    {
        return [
            'query' => Html::encode($query),
            'results' => Index::searchByQuery($query, Yii::$app->composition->getKey('langShortCode')),
        ];
    }
}

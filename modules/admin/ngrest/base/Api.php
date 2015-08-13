<?php

namespace admin\ngrest\base;

use Yii;

/**
 * Wrapper for yii2 basic rest controller used with a model class. The wrapper is made to
 * change behaviours and overwrite the indexAction.
 *
 * usage like described in the yii2 guide.
 */
class Api extends \admin\base\RestActiveController
{
    public function actionServices()
    {
        $class = $this->modelClass;
        $obj = Yii::createObject($class);
        return $obj->getNgrestServices();
    }
    
    public function actionSearch($query)
    {
        if (strlen($query) <= 2) {
            Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
            return ['query' => 'The query string must be at least 3 chars'];
        }
        $model = Yii::createObject($this->modelClass);
        return $model->genericSearch($query);
    }
}

<?php

namespace admin\ngrest\base;

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
        $obj = \Yii::createObject($class);
        return $obj->getNgrestServices();
    }
}

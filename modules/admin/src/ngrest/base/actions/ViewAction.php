<?php

namespace luya\admin\ngrest\base\actions;

use Yii;
use luya\admin\models\UserOnline;

/**
 * IndexAction for REST implementation.
 *
 * In order to enable or disable the pagination for index actions regulatet by the ActiveController
 * the main yii\rest\IndexAction is overriten by adding the pagination propertie to the action
 * provided from the luya\rest\ActiveController.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ViewAction extends \yii\rest\ViewAction
{
    public function run($id)
    {
        $result = parent::run($id);
        
        $table = $this->modelClass::tableName();
        
        UserOnline::lock(Yii::$app->adminuser->id, $table, $id, "Edit {$table} id {$id}");
        
        return $result;
    }
}

<?php

namespace admin\rest;

use Yii;

/**
 * This class is used to wrap the yii rest indexAction cause of a possibility
 * to overwrite the pagination parameter.
 *
 * @author nadar
 */
class DeleteAction extends \yii\rest\DeleteAction
{
    public function run($id)
    {
        $model = $this->findModel($id);
        
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        
        if ($model->delete() === false) {
            
            if ($model->hasErrors()) {
                Yii::$app->getResponse()->setStatusCode(500);
                return $model->getErrors();
            }
            
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        
        Yii::$app->getResponse()->setStatusCode(204);
    }
}

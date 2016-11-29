<?php

namespace luya\rest\actions;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * DeleteAction for REST implementation.
 *
 * In order to report errors when deleting problems appear the delete action
 * has been modified in order to return model getErrors() instead of an unknown
 * ServerErrorHttpException.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class DeleteAction extends \yii\rest\DeleteAction
{
    /**
     * Run the delete action with enhanced error checking methods.
     *
     * @see \yii\rest\DeleteAction::run()
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            
            // custom implementation of LUYA in order to throw more informations when delete errors haapens.
            if ($model->hasErrors()) {
                Yii::$app->getResponse()->setStatusCode(500);
                return $model->getErrors();
            }

            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }
}

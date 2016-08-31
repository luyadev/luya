<?php

namespace luya\gallery\frontend\controllers;

use luya\gallery\models\Album;
use yii\web\NotFoundHttpException;

/**
 * Get all images from a collection (album)
 * 
 * @todo rename to 
 * @author Basil Suter <basil@nadar.io>
 */
class AlbumController extends \luya\web\Controller
{
    public function actionIndex($albumId)
    {
        $model = Album::find()->where(['id' => $albumId])->one();

        if (!$model) {
            throw new NotFoundHttpException("Unable to find requested gallery collection.");
        }
        
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);

        $this->view->title = $model->title;

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}

<?php

namespace luya\crawler\frontend\controllers;

use luya\web\Controller;
use luya\crawler\models\Click;
use luya\crawler\models\Index;

class ClickController extends Controller
{
    public function actionIndex($searchId, $indexId, $position)
    {
        $model = new Click();
        $model->attributes = [
            'searchdata_id' => $searchId,
            'index_id' => $indexId,
            'timestamp' => time(),
            'position' => $position,
        ];
        // save whether valid or not, as user must be redirected.
        $model->save();
        
        $index = Index::findOne($indexId);
        
        if ($index) {
            return $this->redirect($index->url);
        }
        
        throw new \Exception("Unable to find index.");
    }
}

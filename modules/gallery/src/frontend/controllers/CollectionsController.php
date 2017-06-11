<?php

namespace luya\gallery\frontend\controllers;

use luya\web\Controller;
use luya\gallery\models\Album;

/**
 * Get all collections or for a specificy categorie.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class CollectionsController extends Controller
{
    /**
     * Get all collections
     */
    public function actionData()
    {
        return $this->render('data', [
            'data' => Album::find()->orderBy(['is_highlight' => SORT_DESC, 'sort_index' => SORT_ASC])->all(),
        ]);
    }
    
    /**
     * Get all collections for a specfici categorie
     *
     * @param integer $catId
     * @return string
     */
    public function actionDataByCategorie($catId)
    {
        return $this->render('data_by_categorie', [
            'data' => Album::find()->where(['cat_id' => $catId])->orderBy(['is_highlight' => SORT_DESC, 'sort_index' => SORT_ASC])->all(),
        ]);
    }
}

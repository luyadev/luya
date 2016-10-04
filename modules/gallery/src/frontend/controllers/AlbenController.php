<?php

namespace luya\gallery\frontend\controllers;

use luya\gallery\models\Album;
use luya\gallery\models\Cat;

/**
 * Controller to get all collections from a categorie or just all collections.
 *
 * This controller will be replaced with `CollectionController` in future.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class AlbenController extends \luya\web\Controller
{
    public function actionIndex($catId)
    {
        return $this->render('index', [
            'catData' => Cat::findOne($catId),
            'albenData' => Album::find()->where(['cat_id' => $catId])->orderBy(['is_highlight' => SORT_DESC, 'sort_index' => SORT_ASC])->all(),
        ]);
    }
}

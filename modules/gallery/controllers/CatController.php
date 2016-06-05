<?php

namespace gallery\controllers;

use galleryadmin\models\Cat;

/**
 * Controller to get all categories.
 * 
 * @todo rename to Folder
 * @author Basil Suter <basil@nadar.io>
 */
class CatController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'catData' => Cat::find()->orderBy(['title' => SORT_ASC])->all(),
        ]);
    }
}

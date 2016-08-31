<?php

namespace cmstests\data\modules\controllers;

use luya\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return 'cmsunitmodule/default/index';
    }
}
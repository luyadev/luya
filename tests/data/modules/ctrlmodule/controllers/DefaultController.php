<?php

namespace luyatests\data\modules\ctrlmodule\controllers;

class DefaultController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return 'ctrlmodule/default/index';
    }
}

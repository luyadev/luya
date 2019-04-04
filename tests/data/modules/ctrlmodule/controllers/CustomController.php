<?php

namespace luyatests\data\modules\ctrlmodule\controllers;

class CustomController extends \luya\web\Controller
{
    public function actionBar()
    {
        return 'ctrlmodule/custom/bar';
    }
}

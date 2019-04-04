<?php

namespace luyatests\data\modules\unitmodule\controllers;

class OtherController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return 'index';
    }

    public function actionBaz()
    {
        return 'baz';
    }
}

<?php

namespace tests\data\modules\urlmodule\controllers;

class DefaultController extends \luya\base\Controller
{
    public function actionIndex()
    {
        return 'bar';
    }
}

<?php

namespace luyatests\data\modules\unitmodule\controllers;

class ViewmapController extends \luya\web\Controller
{
    public function actionViewmap1()
    {
        return $this->render('viewmap1');
    }

    public function actionViewmap2()
    {
        return $this->render('viewmap2');
    }

    public function actionViewmap3()
    {
        return $this->render('viewmap3');
    }
}

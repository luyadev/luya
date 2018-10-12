<?php

namespace luyatests\data\modules\unitmodule\controllers;

class ViewmapAllController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return $this->render('viewmapAll');
    }
}

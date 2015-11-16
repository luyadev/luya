<?php

namespace admin\controllers;

class FileController extends \luya\web\Controller
{
    public function actionDownload($id, $hash, $fileName)
    {
        var_dump($id, $hash, $fileName);
    }
}
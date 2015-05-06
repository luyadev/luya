<?php

namespace admin\controllers;

class StorageController extends \admin\base\Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}

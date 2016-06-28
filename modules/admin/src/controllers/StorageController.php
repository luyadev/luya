<?php

namespace admin\controllers;

/**
 * StorageController renders the Filemanager Template.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class StorageController extends \admin\base\Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}

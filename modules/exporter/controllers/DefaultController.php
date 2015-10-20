<?php

namespace exporter\controllers;

use Yii;
use Exception;

class DefaultController extends \luya\base\Controller
{
    public function actionIndex($p = null)
    {
        $file = Yii::getAlias($this->module->downloadFile);
        
        if (YII_ENV_PROD) {
            if (empty($this->module->downloadPassword)) {
                throw new Exception("unable to download file, invalid password.");
            }
        }
        
        if ($this->module->downloadPassword) {
            if ($this->module->downloadPassword !== $p) {
                throw new Exception("Wrong password to download exporter files.");
            }
        }
        
        if (file_exists($file)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for i.e.
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($file));
            header("Content-Disposition: attachment; filename=download-".date("Y-m-d-h-i").".zip");
            readfile($file);
            die();
        }
    }
}
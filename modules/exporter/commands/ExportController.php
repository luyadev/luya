<?php

namespace exporter\commands;

use Yii;
use luya\helpers\Zip;
use luya\helpers\FileHelper;

class ExportController extends \luya\base\Command
{
    public function actionIndex()
    {
        $folder = Yii::getAlias('@web/public_html/storage');
        FileHelper::createDirectory(Yii::getAlias('@runtime/exporter/'));
        $save = Yii::getAlias($this->module->downloadFile);
        Zip::dir($folder, $save);
    }
}
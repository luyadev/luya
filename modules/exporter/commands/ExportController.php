<?php

namespace exporter\commands;

use Yii;
use luya\helpers\ZipHelper;
use luya\helpers\FileHelper;
use Ifsnop\Mysqldump;

class ExportController extends \luya\console\Command
{
    public function actionIndex()
    {
        $hash = time();
        $cacheFolder = Yii::getAlias('@runtime/exporter/' . $hash);
        
        FileHelper::createDirectory($cacheFolder);
        
        $dump = new Mysqldump\Mysqldump(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password);
        $dump->start($cacheFolder . '/mysql.sql');
        
        FileHelper::copyDirectory(Yii::getAlias('@web/public_html/storage'), $cacheFolder.'/storage');
        
        $save = Yii::getAlias($this->module->downloadFile);
        
        @unlink($save);
        
        ZipHelper::dir($cacheFolder . "/", $save);
    }
}
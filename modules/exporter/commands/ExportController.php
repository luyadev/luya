<?php

namespace exporter\commands;

use Yii;
use luya\helpers\ZipHelper;
use luya\helpers\FileHelper;
use Ifsnop\Mysqldump;

class ExportController extends \luya\console\Command
{
    /**
     * Create a zip file with database dump and storage files/images and stores the zip in
     * the runtime folder.
     * 
     * @return void
     */
    public function actionIndex()
    {
        $hash = time();
        $cacheFolder = Yii::getAlias('@runtime/exporter/'.$hash);
        
        $this->verbosePrint("cache folder $cacheFolder");
        
        FileHelper::createDirectory($cacheFolder, 0777);

        $dump = new Mysqldump\Mysqldump(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password);
        $dump->start($cacheFolder.'/mysql.sql');

        $source = Yii::getAlias('@web/public_html/storage');
        
        $this->verbosePrint("storage source folder $source");
        
        if (is_link($source)) {
            $source = readlink($source);
            
            $this->verbosePrint("source is a symlink, readlink output: " . $source);
        }
        
        FileHelper::copyDirectory($source, $cacheFolder.'/storage', ['dirMode' => 0777, 'fileMode' => 0775]);

        $save = Yii::getAlias($this->module->downloadFile);

        if (file_exists($save)) {
            $this->verbosePrint("a exporter file does already exists, unlink file: " . $save);
            @unlink($save);
        }

        ZipHelper::dir($cacheFolder.'/', $save);
    }
}

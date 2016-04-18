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

        FileHelper::createDirectory($cacheFolder, 0777);

        $dump = new Mysqldump\Mysqldump(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password);
        $dump->start($cacheFolder.'/mysql.sql');

        $source = Yii::getAlias('@web/public_html/storage');
        
        if (is_link($source)) {
            $source = readlink($source);
        }
        
        FileHelper::copyDirectory($source, $cacheFolder.'/storage', ['dirMode' => 0777, 'fileMode' => 0775]);

        $save = Yii::getAlias($this->module->downloadFile);

        if (file_exists($save)) {
            @unlink($save);
        }

        ZipHelper::dir($cacheFolder.'/', $save);
    }
    
    /**
     * 
     * @param unknown $fromDsn
     * @param unknown $fromUsername
     * @param unknown $fromPassword
     */
    public function actionCopyToLocal($fromDsn, $fromUsername, $fromPassword)
    {
        $temp = tmpfile();
        
        $dump = new Mysqldump\Mysqldump($fromDsn, $fromUsername, $fromPassword);
        $dump->start($temp);
        
        if ($this->confirm('Are you sure you want to remove all the tables for this Database?')) {
            foreach (Yii::$app->db->schema->getTableNames() as $name) {
                var_dump($name);
            }
        }
    }
}

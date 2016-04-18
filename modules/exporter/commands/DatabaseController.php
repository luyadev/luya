<?php

namespace exporter\commands;

use Yii;
use Ifsnop\Mysqldump\Mysqldump;
use luya\console\Command;

/**
 * Database Exporter/Handlers.
 * 
 * @since 1.0.0-beta6
 * @author Basil Suter <basil@nadar.io>
 */
class DatabaseController extends Command
{
    /**
     * This action will FULLY(!!) drop all tables of the current configuration, create a zip from the
     * provided $remoteDsn Database and import the remote database:
     * 
     * ```
     * ./vendor/bin/luya exporter/database/remote-replace-local "mysql:host=localhost;dbname=REMOTE_DB_NAME" "USERNAME" "PASSWORD"
     * ```
     * 
     * @param string $fromDsn
     * @param string $fromUsername
     * @param string $fromPassword
     */
    public function actionRemoteReplaceLocal($remoteDsn, $remoteUsername, $remotePassword)
    {
        $temp = tempnam(sys_get_temp_dir(), uniqid());
        $dump = new Mysqldump($remoteDsn, $remoteUsername, $remotePassword);
        $dump->start($temp);
    
        $tempBackup = tempnam(sys_get_temp_dir(), uniqid() . '-BACKUP-'.time());
        $dump = new Mysqldump(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password);
        $dump->start($tempBackup);
    
        $this->outputInfo("Temporary Backup File has been created: " . $tempBackup);
    
        if ($this->confirm('Are you sure you want to remove all the tables for this Database?')) {
            foreach (Yii::$app->db->schema->getTableNames() as $name) {
                Yii::$app->db->createCommand()->dropTable($name)->execute();
            }
            Yii::$app->db->createCommand()->setSql(file_get_contents($temp))->execute();
        }
    
        unlink($temp);
        $this->outputSuccess("The local database has been replace with the remote database.");
    }
}
<?php

namespace admin\commands;

use Yii;
use luya\console\Command;

/**
 * Storage Command.
 * 
 * + Process Thumbnails: Generates all Thumbnails instead while loading in admin `./vendor/bin/luya admin/storage/process-thumbnails`.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta7
 */
class StorageController extends Command
{
    public function actionProcessThumbnails()
    {
        $response = Yii::$app->storage->processThumbnails();
        
        if ($response) {
            return $this->outputSuccess('Successful generated storage thumbnails.');
        }
        
        return $this->outputError('Error while creating the storage thumbnails.');
    }
}
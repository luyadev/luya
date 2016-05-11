<?php

namespace luya\console\commands;

use Yii;
use admin\importers\StorageImporter;

/**
 * LUYA Admin Storage command.
 * 
 * @author Martin Petrasch <martin.petrasch@zephir.ch>
 */
class StorageController extends \luya\console\Command
{
    /**
     * Delete orphaned files, but requires user confirmation to ensure delete process.
     */
    public function actionCleanup()
    {
        $fileList = StorageImporter::getOrphanedFileList();

        if ($fileList === false) {
            return $this->outputError("Could not find the storage folder to clean up.");
        }
        
        if (count($fileList) > 0) {
            $this->output(print_r($fileList, true));
        }

        if (count($fileList) !== 0) {
            $success = true;
            if ($this->confirm("Do you want to delete " . count($fileList) . " files which are not referenced in the database any more?")) {
                foreach ($fileList as $file) {
                    if (is_file($file) && @unlink($file)) {
                        $this->outputSuccess($file . " successful deleted.");
                    } elseif (is_file($file)) {
                        $this->outputError($file . " could not be deleted!");
                        $success = false;
                    } else {
                        $this->outputError($file . " could not be found!");
                        $success = false;
                    }
                }
            }
            if ($success) {
                return $this->outputSuccess(count($fileList) . " files successful deleted.");
            }
            return $this->outputError("Cleanup could not be completed. Please look into error above.");
        }
        return $this->outputSuccess("No orphaned files found.");
    }
    
    /**
     * Create all thumbnails for filemanager preview. Otherwhise they are created on request load.
     */
    public function actionProcessThumbnails()
    {
        $response = Yii::$app->storage->processThumbnails();
        
        if ($response) {
            return $this->outputSuccess('Successful generated storage thumbnails.');
        }
        
        return $this->outputError('Error while creating the storage thumbnails.');
    }
}

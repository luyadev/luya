<?php

namespace luya\console\commands;

use Yii;
use admin\importers\StorageImporter;

class StorageController extends \luya\console\Command
{

    /**
     * delete orphaned files -> wait for user confirmation (y/n)
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
}

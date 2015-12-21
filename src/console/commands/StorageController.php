<?php

namespace luya\console\commands;

use admin\importers\StorageImporter;
use Yii;

class StorageController extends \luya\console\Command
{

    /**
     * delete orphaned files -> wait for user confirmation (y/n)
     */
    public function actionCleanup()
    {
        $fileList = StorageImporter::getOrphanedFileList();

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
        } else {
            return $this->outputSuccess("No orphaned files found.");
        }
    }
}

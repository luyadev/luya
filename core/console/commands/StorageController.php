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
            foreach ($fileList as $fileName) {
                $this->output($fileName);
            }
            //$this->output(print_r($fileList, true));
            $this->outputInfo(count($fileList) . " files to remove.");
        }

        if (count($fileList) !== 0) {
            $success = true;
            if ($this->confirm("Do you want to delete " . count($fileList) . " files which are not referenced in the database any more? (can not be undon, maybe create a backup first!)")) {
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

    /**
     * See image duplications exists of filter and file id combination and remove them execept of the first created.
     * 
     * @return number
     */
    public function actionCleanupImageTable()
    {
        $rows = Yii::$app->db->createCommand('SELECT file_id, filter_id, COUNT(*) as count FROM admin_storage_image GROUP BY file_id, filter_id HAVING COUNT(*) > 1')->queryAll();
        
        if (empty($rows)) {
            return $this->outputInfo("no dublications has been detected.");
        }
        
        $this->outputInfo("dublicated image files detected:");
        foreach ($rows as $row) {
            $this->output("> file {$row['file_id']} with filter {$row['filter_id']} found {$row['count']} duplicates.");
        }

        if ($this->confirm("Do you want to delte the duplicated files in the image storage table?")) {
            foreach ($rows as $key => $row) {
                // get the lowest entrie
                $keep = Yii::$app->db->createCommand('SELECT id FROM admin_storage_image WHERE file_id=:fileId AND filter_id=:filterId ORDER BY id LIMIT 1', [
                    ':fileId' => $row['file_id'],
                    ':filterId' => $row['filter_id'],
                ])->queryOne();
            
                $remove = Yii::$app->db->createCommand()->delete('admin_storage_image', 'file_id=:fileId AND filter_id=:filterId AND id!=:id', [
                    ':fileId' => $row['file_id'],
                    ':filterId' => $row['filter_id'],
                    ':id' => $keep['id'],
                ])->execute();
                
                if ($remove) {
                    $this->outputSuccess("< Remove {$row['count']} duplications for file {$row['file_id']} with filter {$row['filter_id']}.");
                }
            }
        }
        
        return $this->outputSuccess("all duplications has been removed.");
    }
}

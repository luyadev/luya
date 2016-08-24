<?php

namespace admin\importers;

use admin\models\StorageFile;
use admin\models\StorageImage;
use luya\helpers\FileHelper;
use Yii;
use luya\console\Importer;

class StorageImporter extends Importer
{
    public $queueListPosition = self::QUEUE_POSITION_LAST;

    public static function getFindFilesDirectory()
    {
        $path = Yii::$app->storage->serverPath;
        
        if (is_dir($path) && file_exists($path)) {
            return FileHelper::findFiles($path, ['except' => ['.*']]);
        }
        
        return false;
    }
    
    /**
     *
     * 1. get all files from storage folder
     * 2. check each file if available in db tables ('admin_storage_file' and 'admin_storage_image')
     * 3. remove each found entry and return list with all remaining orphaned files
     *
     * @return array list of orphaned files
     */
    public static function getOrphanedFileList()
    {
        //$storageFileList = static::getFindFilesDirectory();
        $diskFiles = static::getFindFilesDirectory();
        
        if ($diskFiles === false) {
            return false;
        }

        //build storagefilelist index
        // $storageFileIndex = [];
        foreach ($diskFiles as $key => $file) {
            $diskFiles[pathinfo($file, PATHINFO_BASENAME)] = $file;
            unset($diskFiles[$key]);
        }

        // check storage files which are not flagged as deleted

        foreach (StorageFile::find()->where(['is_deleted' => 0])->indexBy('id')->asArray()->all() as $dbfile) {
            if (isset($diskFiles[$dbfile['name_new_compound']])) {
                unset($diskFiles[$dbfile['name_new_compound']]);
            }
            unset($dbfile);
        }

        // check image filter files
        $imageList = StorageImage::find()->asArray()->all();
        // check all storage files including is_deleted entries
        $allStorageFileEntries = StorageFile::find()->indexBy('id')->asArray()->all();

        foreach ($imageList as $image) {
            if (array_key_exists($image['file_id'], $allStorageFileEntries)) {
                $filterImage = $image['filter_id'] . '_' . $allStorageFileEntries[$image['file_id']]['name_new_compound'];
                if (isset($diskFiles[$filterImage])) {
                    unset($diskFiles[$filterImage]);
                }
            }
            unset($image);
        }

        return $diskFiles;
    }

    /**
     *
     * 1. get all files from storage folder
     * 2. check each db entry if not available in file list and set is_deleted = 1
     *
     * @return int count of flagged 'is_deleted' entries
     */
    public static function removeMissingStorageFiles()
    {
        $storageFileList = static::getFindFilesDirectory();
        
        if (!$storageFileList) {
            return false;
        }

        // check storage files
        $allStorageFileEntries = StorageFile::find()->where(['is_deleted' => 0])->indexBy('id')->all();

        $count = 0;

        // build storagefilelist index
        $storageFileIndex = [];
        foreach ($storageFileList as $key => $file) {
            $storageFileIndex[] = pathinfo($file, PATHINFO_BASENAME);
        }

        foreach ($allStorageFileEntries as $dbfile) {
            if (!in_array($dbfile['name_new_compound'], $storageFileIndex)) {
                //$dbfile->is_deleted = 1;
                $dbfile->updateAttributes(['is_deleted' => 1]);
                $count++;
                //$dbfile->update(false);
            }
        }
        return $count;
    }

    /*
     * 8.2.2016: Disabled, as we want to re create files if they are not existing.
     * if file exist in table but not on the serve we could have delete the file as the
     * filter has changed.
     */
    /*
    public static function removeMissingImageFiles()
    {
        $storageFileList = static::getFindFilesDirectory();
        
        if (!$storageFileList) {
            return false;
        }

        // check storage files
        $allStorageFileEntries = StorageFile::find()->indexBy('id')->all();

        $count = 0;

        // check image filter files
        $imageList = StorageImage::find()->all();

        foreach ($imageList as $image) {
            if (array_key_exists($image['file_id'], $allStorageFileEntries)) {
                $filterImage = $image['filter_id'] . '_' . $allStorageFileEntries[$image['file_id']]['name_new_compound'];
                $found = false;
                foreach ($storageFileList as $key => $file) {
                    if ($filterImage == pathinfo($file, PATHINFO_BASENAME)) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $image->delete();
                    $count++;
                }
            }
        }

        return $count;
    }
    */

    public function run()
    {
        $log = [];

        $this->importer->verbosePrint('process thumbnail', __METHOD__);
        
        Yii::$app->storage->processThumbnails();
        
        $this->importer->verbosePrint('get orphaned file list', __METHOD__);
        
        $orphanedFileList = static::getOrphanedFileList();
        
        $this->importer->verbosePrint('orphaned file list response.', __METHOD__);

        if ($orphanedFileList === false) {
            $log["error"] = "unable to find a storage folder '".Yii::$app->storage->serverPath."' to compare.";
        } else {
            $log["files_missing_in_table"] = count($orphanedFileList);
            
            $this->importer->verbosePrint('remove missing storage files', __METHOD__);
            
            $log["files_missing_in_file_table"] = static::removeMissingStorageFiles();
            
            //$log["files_missing_in_image_table"] = static::removeMissingImageFiles();

            foreach ($orphanedFileList as $file) {
                $log["files_to_remove"][] = $file;
            }
        }

        $this->importer->verbosePrint('finished storage importer', __METHOD__);

        $this->addLog($log);
    }
}

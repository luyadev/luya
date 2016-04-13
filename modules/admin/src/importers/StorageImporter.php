<?php

namespace admin\importers;

use admin\models\StorageFile;
use admin\models\StorageImage;
use luya\helpers\FileHelper;
use Yii;

class StorageImporter extends \luya\base\Importer
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
        $storageFileList = static::getFindFilesDirectory();
        
        if ($storageFileList === false) {
            return false;
        }

        // check storage files which are not flagged as deleted
        $allStorageFileEntries = StorageFile::find()->where(['is_deleted' => 0])->indexBy('id')->asArray()->all();

        foreach ($storageFileList as $key => $file) {
            foreach ($allStorageFileEntries as $dbfile) {
                if ($dbfile['name_new_compound'] == pathinfo($file, PATHINFO_BASENAME)) {
                    unset($storageFileList[$key]);
                    break;
                }
            }
        }
        
        // check image filter files
        $imageList = StorageImage::find()->asArray()->all();
        // check all storage files including is_deleted entries
        $allStorageFileEntries = StorageFile::find()->indexBy('id')->asArray()->all();

        foreach ($imageList as $image) {
            if (array_key_exists($image['file_id'], $allStorageFileEntries)) {
                $filterImage = $image['filter_id'] . '_' . $allStorageFileEntries[$image['file_id']]['name_new_compound'];
                foreach ($storageFileList as $key => $file) {
                    if ($filterImage == pathinfo($file, PATHINFO_BASENAME)) {
                        unset($storageFileList[$key]);
                        break;
                    }
                }
            }
        }
        
        return $storageFileList;
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

        foreach ($allStorageFileEntries as $dbfile) {
            $found = false;
            foreach ($storageFileList as $key => $file) {
                if ($dbfile['name_new_compound'] == pathinfo($file, PATHINFO_BASENAME)) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $dbfile->is_deleted = 1;
                $count++;
                $dbfile->update(false);
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

        Yii::$app->storage->processThumbnails();
        
        $orphanedFileList = static::getOrphanedFileList();

        if ($orphanedFileList === false) {
            $log["error"] = "unable to find a storage folder '".Yii::$app->storage->serverPath."' to compare.";
        } else {
            $log["files_missing_in_table"] = count($orphanedFileList);
            
            $log["files_missing_in_file_table"] = static::removeMissingStorageFiles();
            
            //$log["files_missing_in_image_table"] = static::removeMissingImageFiles();

            foreach (static::getOrphanedFileList() as $file) {
                $log["files_to_remove"][] = $file;
            }
        }
        $this->addLog("storage", $log);
    }
}

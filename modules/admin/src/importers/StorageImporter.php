<?php

namespace luya\admin\importers;

use luya\admin\models\StorageFile;
use luya\admin\models\StorageImage;
use luya\helpers\FileHelper;
use Yii;
use luya\console\Importer;

/**
 * Storage Importer.
 *
 * Storage system importer behavior to cleanup the storage database and folder.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class StorageImporter extends Importer
{
    public $queueListPosition = self::QUEUE_POSITION_LAST;

    private static function getFindFilesDirectory()
    {
        $path = Yii::$app->storage->serverPath;
        
        if (is_dir($path) && file_exists($path)) {
            return FileHelper::findFiles($path, ['except' => ['.*']]);
        }
        
        return false;
    }
    
    /**
     * Get orphaned files array.
     *
     * 1. get all files from storage folder
     * 2. check each file if available in db tables ('admin_storage_file' and 'admin_storage_image')
     * 3. remove each found entry and return list with all remaining orphaned files
     *
     * @return array list of orphaned files
     */
    public static function getOrphanedFileList()
    {
        $diskFiles = static::getFindFilesDirectory();
        
        if ($diskFiles === false) {
            return false;
        }

        //build storagefilelist index
        foreach ($diskFiles as $key => $file) {
            $diskFiles[pathinfo($file, PATHINFO_BASENAME)] = $file;
            unset($diskFiles[$key]);
        }

        // check storage files which are not flagged as deleted
        foreach (StorageFile::find()->where(['is_deleted' => false])->indexBy('id')->asArray()->all() as $dbfile) {
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
     * Mark not found files as deleted.
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
            return 0;
        }

        // check storage files
        $allStorageFileEntries = StorageFile::find()->where(['is_deleted' => false])->indexBy('id')->all();

        $count = 0;

        // build storagefilelist index
        $storageFileIndex = [];
        foreach ($storageFileList as $key => $file) {
            $storageFileIndex[] = pathinfo($file, PATHINFO_BASENAME);
        }

        foreach ($allStorageFileEntries as $dbfile) {
            if (!in_array($dbfile['name_new_compound'], $storageFileIndex)) {
                $dbfile->updateAttributes(['is_deleted' => true]);
                $count++;
            }
        }
        return $count;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $log = [];

        $this->importer->verbosePrint('Retrieve all orphaned files.', __METHOD__);
        $orphanedFileList = static::getOrphanedFileList();
        
        if ($orphanedFileList === false) {
            $log["error"] = "unable to find a storage folder '".Yii::$app->storage->serverPath."' to compare.";
        } else {
            $log["files_missing_in_table"] = count($orphanedFileList);
            
            $this->importer->verbosePrint('Start marking not found storage files as deleted in database.', __METHOD__);
            $log["files_missing_in_file_table"] = static::removeMissingStorageFiles();

            foreach ($orphanedFileList as $file) {
                $log["files_to_remove"][] = $file;
            }
        }
        
        $this->importer->verbosePrint('Start the thumbnail processing.', __METHOD__);
        Yii::$app->storage->processThumbnails();

        $this->importer->verbosePrint('Finished the storage importer run command.', __METHOD__);
        $this->addLog($log);
    }
}

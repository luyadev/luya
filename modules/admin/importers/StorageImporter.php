<?php

namespace admin\importers;

use admin\models\StorageFile;
use admin\models\StorageImage;
use luya\helpers\FileHelper;
use Yii;

class StorageImporter extends \luya\base\Importer
{
    public $queueListPosition = self::QUEUE_POSITION_LAST;

    /**
     *
     * 1. get all files from storage folder
     * 2. check each file if available in db tables ('admin_storage_file' and 'admin_storage_image')
     * 3. remove each found entry and return list with all remaining orphaned files
     *
     * @return array list of orphaned files
     */
    static function getOrphanedFileList()
    {
        $storageFileList = FileHelper::findFiles(Yii::$app->storage->serverPath, ['except' => ['.*']]);

        // check storage files
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

        foreach ($imageList as $image) {
            $filterImage = $image['filter_id'] . '_' . $allStorageFileEntries[$image['file_id']]['name_new_compound'];
            foreach ($storageFileList as $key => $file) {
                if ($filterImage == pathinfo($file, PATHINFO_BASENAME)) {
                    unset($storageFileList[$key]);
                    break;
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
    static function removeMissingStorageFiles()
    {
        $storageFileList = FileHelper::findFiles(Yii::$app->storage->serverPath, ['except' => ['.*']]);

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

    /**
     *
     * 1. get all files from storage folder
     * 2. check each image/filter db entry if not available in file list and remove them from 'admin_storage_image'
     *
     * @return int count of removed entries
     */
    static function removeMissingImageFiles()
    {
        $storageFileList = FileHelper::findFiles(realpath(Yii::$app->storage->serverPath), ['except' => ['.*']]);

        // check storage files
        $allStorageFileEntries = StorageFile::find()->where(['is_deleted' => 0])->indexBy('id')->all();

        $count = 0;

        // check image filter files
        $imageList = StorageImage::find()->all();

        foreach ($imageList as $image) {
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
        return $count;
    }

    public function run()
    {
        $log = [];

        $orphanedFileList = StorageImporter::getOrphanedFileList();

        $log["files_missing_in_table"] = count($orphanedFileList);

        $log["files_missing_in_file_table"] = StorageImporter::removeMissingStorageFiles();

        $log["files_missing_in_image_table"] = StorageImporter::removeMissingImageFiles();

        foreach (StorageImporter::getOrphanedFileList() as $file) {
            $log["files_to_remove"][] = $file;
        }

        $this->addLog("storage", $log);
    }
}

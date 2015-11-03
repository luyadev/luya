<?php

namespace admin\storage;

use admin\models\StorageFolder;
use Yii;

class Folder
{
    public function createFolder($folderName, $parentFolderId = 0)
    {
        $model = new StorageFolder();
        $model->name = $folderName;
        $model->parent_id = $parentFolderId;
        $model->timestamp_create = time();

        return $model->save();
    }

    public function deleteFolder($folderId)
    {
        $model = StorageFolder::findOne($folderId);
        if (!$model) {
            return false;
        }
        $model->is_deleted = true;

        return $model->update();
    }

    /**
     * check if a folder is empty (without subfolders and/or files)
     *
     * @param int $folderId
     * @return bool
     */
    public function isEmptyFolder($folderId)
    {
        if (!empty($this->getSubFolders($folderId))) {
            return false;
        } else {
            return empty(Yii::$app->storage->file->allFromFolder($folderId));
        }
    }

    public function updateFolder($folderId, array $fields)
    {
        $model = StorageFolder::findOne($folderId);
        if (!$model) {
            return false;
        }
        $model->attributes = $fields;

        return $model->update();
    }

    public function getSubFolders($parentFolderId)
    {
        return \admin\models\StorageFolder::find()->where(['parent_id' => $parentFolderId, 'is_deleted' => 0])->asArray()->all();
    }

    private function partialFolderTree($parentId)
    {
        $data = [];
        foreach ($this->getSubFolders($parentId) as $row) {
            $data[] = [
                'data' => $row,
                '__items' => $this->partialFolderTree($row['id']),
            ];
        }

        return $data;
    }

    public function getFolderTree()
    {
        return $this->partialFolderTree(0);
    }
    
    public function all()
    {
        return StorageFolder::find()->select(['id', 'name', 'parent_id'])->where(['is_deleted' => 0])->asArray()->all();
    }

    /**
     * get all sub folders for $folderId.
     *
     * @param unknown_type $folderId
     */
    public function breadcrumbs($folderId)
    {
        if ($folderId == 0) {
            return [$this->getRootArray()];
        }
        $crumbs[] = (int) $folderId;
        while ($data = $this->getSubFolderOf($folderId)) {
            $crumbs[] = (int) $data;
            $folderId = $data;
        }

        $crumbs[] = 0;

        $breadcrumbs = [];

        foreach ($crumbs as $folderId) {
            if ($folderId == 0) {
                $breadcrumbs[] = $this->getRootArray();
                continue;
            }
            $breadcrumbs[] = StorageFolder::find()->where(['id' => $folderId])->asArray()->one();
        }

        return array_reverse($breadcrumbs);
    }

    private function getRootArray()
    {
        return ['id' => 0, 'name' => 'Stammverzeichnis'];
    }

    private function getSubFolderOf($folderId)
    {
        $folder = StorageFolder::find()->select(['id', 'name', 'parent_id'])->where(['id' => $folderId])->asArray()->one();

        if ($folder['parent_id'] == 0) {
            return false;
        }

        return $folder['parent_id'];
    }
}

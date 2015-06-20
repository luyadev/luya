<?php

namespace admin\storage;

class Folder
{
    public function createFolder($folderName, $parentFolderId = 0)
    {
        $model = new \admin\models\StorageFolder();
        $model->name = $folderName;
        $model->parent_id = $parentFolderId;
        $model->timestamp_create = time();

        return $model->save();
    }

    public function getSubFolders($parentFolderId)
    {
        return \admin\models\StorageFolder::find()->where(['parent_id' => $parentFolderId])->asArray()->all();
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
            $breadcrumbs[] = \admin\models\StorageFolder::find()->where(['id' => $folderId])->asArray()->one();
        }

        return array_reverse($breadcrumbs);
    }

    private function getRootArray()
    {
        return ['id' => 0, 'name' => 'Stammverzeichnis'];
    }

    private function getSubFolderOf($folderId)
    {
        $folder = \admin\models\StorageFolder::find()->select(['id', 'name', 'parent_id'])->where(['id' => $folderId])->asArray()->one();

        if ($folder['parent_id'] == 0) {
            return false;
        }

        return $folder['parent_id'];
    }
}

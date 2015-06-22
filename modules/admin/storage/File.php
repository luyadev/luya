<?php

namespace admin\storage;

use Yii;
use \admin\models\StorageFile;
use \admin\models\StorageImage;
class File
{
    public $error = null;

    public function getFileInfo($sourceFile)
    {
        $path = pathinfo($sourceFile);

        return (object) [
            'extension' => $path['extension'],
            'name' => $path['filename'],
        ];
    }

    public function getMimeType($sourceFile)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $sourceFile);
        finfo_close($finfo);

        return $mime;
    }

    public function getFileHash($sourceFile)
    {
        return hash_file('md5', $sourceFile);
    }

    /**
     * Warning
     * Because PHP's integer type is signed many crc32 checksums will result in negative integers on 32bit platforms. On 64bit installations all crc32() results will be positive integers though.
     * So you need to use the "%u" formatter of sprintf() or printf() to get the string representation of the unsigned crc32() checksum in decimal format.
     *
     * @var string
     */
    public function getNameHash($fileName)
    {
        return sprintf('%s', hash('crc32b', uniqid($fileName, true)));
    }

    public function setError($message)
    {
        $this->error = $message;

        return true;
    }

    public function getError()
    {
        return $this->error;
    }

    public function create($sourceFile, $newFileName, $hidden = false, $folderId = 0)
    {
        if (empty($sourceFile) || empty($newFileName)) {
            return !$this->setError('empty source file or create file param. Invalid file uploaded!');
        }
        $copyFile = false;
        $fileInfo = $this->getFileInfo($newFileName);
        $baseName = preg_replace("/[^a-zA-Z0-9\-\_\.]/", '', $fileInfo->name);
        $fileHashName = $this->getNameHash($newFileName);
        $fileHash = $this->getFileHash($sourceFile);
        $mimeType = $this->getMimeType($sourceFile);
        $fileName = implode([$baseName.'_'.$fileHashName, $fileInfo->extension], '.');
        $savePath = \yii::$app->storage->dir.$fileName;
        if (is_uploaded_file($sourceFile)) {
            if (move_uploaded_file($sourceFile, $savePath)) {
                $copyFile = true;
            } else {
                $this->setError("error while moving uploaded file from $sourceFile to $savePath");
            }
        } else {
            if (copy($sourceFile, $savePath)) {
                $copyFile = true;
            } else {
                $this->setError("error while copy file from $sourceFile to $savePath.");
            }
        }

        if ($copyFile) {
            $model = new StorageFile();
            $model->setAttributes([
                'name_original' => $newFileName,
                'name_new' => $baseName,
                'name_new_compound' => $fileName,
                'mime_type' => $mimeType,
                'extension' => $fileInfo->extension,
                'folder_id' => (int) $folderId,
                'hash_file' => $fileHash,
                'hash_name' => $fileHashName,
                'is_hidden' => $hidden,
            ]);
            if ($model->validate()) {
                if ($model->save()) {
                    return $model->id;
                }
            }
        }

        return false;
    }

    public function allFromFolder($folderId)
    {
        $files = StorageFile::find()->select(['id', 'name_original', 'extension'])->where(['folder_id' => $folderId, 'is_hidden' => 0])->asArray()->all();
        foreach($files as $k => $v) {
            if ($v['extension'] == "jpg" || $v['extension'] == "png") {
                $imageId = Yii::$app->storage->image->create($v['id'], 0);
                $thumb = Yii::$app->storage->image->filterApply($imageId, 'tiny-crop');
            } else {
                $thumb = false;
            }
            $files[$k]['thumbnail'] = $thumb;
        }
        return $files;
    }

    public function get($fileId)
    {
        $file = StorageFile::find()->where(['id' => $fileId])->one();

        if (!$file) {
            return false;
        }

        return [
            'file_id' => $file->id,
            'source_http' => \yii::$app->storage->httpDir.$file->name_new_compound,
            'source' => \yii::$app->storage->dir.$file->name_new_compound,
        ];
    }

    public function getPath($fileId)
    {
        $file = StorageFile::find()->where(['id' => $fileId])->one();
        if ($file) {
            return \yii::$app->storage->dir.$file->name_new_compound;
        }

        return false;
    }

    public function getInfo($fileId)
    {
        return StorageFile::find()->where(['id' => $fileId])->one();
    }

    public function moveFileToFolder($fileId, $folderId)
    {
    }
}

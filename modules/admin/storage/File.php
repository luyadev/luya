<?php

namespace admin\storage;

use Yii;
use yii\helpers\Inflector;
use admin\models\StorageFile;

class File
{
    private $_error = null;

    public function getFileInfo($sourceFile)
    {
        $path = pathinfo($sourceFile);

        return (object) [
            'extension' => $path['extension'],
            'name' => $path['filename'],
        ];
    }

    public function delete($fileId)
    {
        $model = StorageFile::find()->where(['id' => $fileId, 'is_deleted' => 0])->one();
        if ($model) {
            return $model->delete(false);
        }

        return true;
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
        $this->_error = $message;

        return true;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function create($sourceFile, $newFileName, $hidden = false, $folderId = 0)
    {
        if (empty($sourceFile) || empty($newFileName)) {
            return !$this->setError('empty source file or create file param. Invalid file uploaded!');
        }
        $copyFile = false;
        $fileInfo = $this->getFileInfo($newFileName);
        $baseName = Inflector::slug($fileInfo->name, '-');
        $fileHashName = $this->getNameHash($newFileName);
        $fileHash = $this->getFileHash($sourceFile);
        $mimeType = $this->getMimeType($sourceFile);
        $fileName = implode([$baseName.'_'.$fileHashName, $fileInfo->extension], '.');
        $savePath = \yii::$app->storage->dir.$fileName;
        if (is_uploaded_file($sourceFile)) {
            if (@move_uploaded_file($sourceFile, $savePath)) {
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
                'extension' => strtolower($fileInfo->extension),
                'folder_id' => (int) $folderId,
                'hash_file' => $fileHash,
                'hash_name' => $fileHashName,
                'is_hidden' => $hidden,
                'file_size' => @filesize($savePath),
            ]);
            if ($model->validate()) {
                if ($model->save()) {
                    return $model->id;
                }
            }
        }

        return false;
    }

    private $_uploaderErrors = [
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    ];

    public function uploadOneFromFiles(array $filesArray, $toFolder = 0)
    {
        $files = [];
        foreach ($filesArray as $k => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => $this->_uploaderErrors[$file['error']], 'file_id' => 0];
            }
            $create = $this->create($file['tmp_name'], $file['name'], false, $toFolder);
            if ($create) {
                return ['upload' => true, 'message' => 'file uploaded succesfully', 'file_id' => $create];
            }
        }

        return ['upload' => false, 'message' => 'no files selected', 'file_id' => 0];
    }

    public function allFromFolder($folderId)
    {
        $files = StorageFile::find()->select(['admin_storage_file.id', 'name_original', 'extension', 'file_size', 'upload_timestamp', 'firstname', 'lastname'])->leftJoin('admin_user', 'admin_user.id=admin_storage_file.upload_user_id')->where(['folder_id' => $folderId, 'is_hidden' => 0, 'admin_storage_file.is_deleted' => 0])->asArray()->all();
        foreach ($files as $k => $v) {
            // @todo check fileHasImage sth
            if ($v['extension'] == 'jpg' || $v['extension'] == 'png') {
                $isImage = true;
                $imageId = Yii::$app->storage->image->create($v['id'], 0);
                if ($imageId) {
                    $thumb = Yii::$app->storage->image->filterApply($imageId, 'tiny-thumbnails', true);
                } else {
                    $thumb = false;
                }
            } else {
                $isImage = false;
                $thumb = false;
            }
            $files[$k]['is_image'] = $isImage;
            $files[$k]['thumbnail'] = $thumb;
        }

        return $files;
    }

    public function all()
    {
        $files = StorageFile::find()->select(['admin_storage_file.id', 'name_original', 'extension', 'file_size', 'upload_timestamp', 'firstname', 'lastname'])->leftJoin('admin_user', 'admin_user.id=admin_storage_file.upload_user_id')->where(['is_hidden' => 0, 'admin_storage_file.is_deleted' => 0])->asArray()->all();
        foreach ($files as $k => $v) {
            // @todo check fileHasImage sth
            if ($v['extension'] == 'jpg' || $v['extension'] == 'png') {
                $isImage = true;
                $imageId = Yii::$app->storage->image->create($v['id'], 0);
                if ($imageId) {
                    $thumb = Yii::$app->storage->image->filterApply($imageId, 'tiny-thumbnails', true);
                } else {
                    $thumb = false;
                }
            } else {
                $isImage = false;
                $thumb = false;
            }
            $files[$k]['is_image'] = $isImage;
            $files[$k]['thumbnail'] = $thumb;
        }
        
        return $files;
    }
    
    public function get($fileId)
    {
        $file = StorageFile::find()->where(['id' => $fileId, 'is_deleted' => 0])->asArray()->one();

        if (!$file) {
            return false;
        }

        $file['file_id'] = $file['id'];
        $file['source_http'] = Yii::$app->storage->httpDir.$file['name_new_compound'];
        $file['source'] = Yii::$app->storage->dir.$file['name_new_compound'];

        return $file;
    }

    public function httpSource($fileId)
    {
        $file = $this->get($fileId);
        
        if ($file) {
            return $file['source_http'];
        }
    }
    
    public function getPath($fileId)
    {
        $file = StorageFile::find()->where(['id' => $fileId, 'is_deleted' => 0])->one();
        if ($file) {
            return Yii::$app->storage->dir.$file->name_new_compound;
        }

        return false;
    }

    public function getInfo($fileId)
    {
        return StorageFile::find()->where(['id' => $fileId, 'is_deleted' => 0])->one();
    }

    public function moveFilesToFolder($fileIds, $folderId)
    {
        foreach ($fileIds as $fileId) {
            $this->moveFileToFolder($fileId, $folderId);
        }
    }

    public function moveFileToFolder($fileId, $folderId)
    {
        $file = StorageFile::findOne($fileId);
        $file->folder_id = $folderId;

        return $file->update(false);
    }
}

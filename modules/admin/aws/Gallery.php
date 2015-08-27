<?php

namespace admin\aws;

use Yii;

class Gallery extends \admin\ngrest\base\ActiveWindow
{
    public $refTableName = null;

    public $imageIdFieldName = null;

    public $refFieldName = null;

    public $module = 'admin';

    /**
     * based on the example table.
     *
     * $this->createTable("gallery_album_image", [
     *     "image_id" => "int(11) NOT NULL default 0",
     *     "album_id" => "int(11) NOT NULL default 0",
     * ]);
     *
     * @param string $refTableName     gallery_album_image
     * @param string $imageIdFieldName image_id
     * @param string $refFieldName     album_id
     */
    public function __construct($refTableName, $imageIdFieldName, $refFieldName)
    {
        $this->refTableName = $refTableName;
        $this->imageIdFieldName = $imageIdFieldName;
        $this->refFieldName = $refFieldName;
    }

    public function index()
    {
        return $this->render('index');
    }

    public function callbackImages()
    {
        $data = (new \yii\db\Query())->select(['image_id' => $this->imageIdFieldName])->where([$this->refFieldName => $this->getItemId()])->from($this->refTableName)->all();
        $files = [];
        foreach ($data as $k => $v) {
            $files[] = [
                'source' => \yii::$app->storage->image->filterApply($v['image_id'], 'small-crop'),
                'image_id' => $v['image_id'],
            ];
        }

        return $files;
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

    /**
     * <URL>/admin/api-admin-storage/files-upload.
     *
     * @todo change post_max_size = 20M
     * @todo change upload_max_filesize = 20M
     * @todo http://php.net/manual/en/features.file-upload.errors.php
     *
     * @return array|json Key represents the uploaded file name, value represents the id in the database.
     */
    public function callbackUpload()
    {
        $files = [];
        foreach ($_FILES as $k => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => $this->_uploaderErrors[$file['error']]];
            }
            $fileId = Yii::$app->storage->file->create($file['tmp_name'], $file['name'], false, Yii::$app->request->post('folderId', 0));
            $imageId = \yii::$app->storage->image->create($fileId);

            if ($imageId) {
                $in = \yii::$app->db->createCommand()->insert($this->refTableName, [
                    $this->imageIdFieldName => (int) $imageId,
                    $this->refFieldName => (int) $this->getItemId(),
                ])->execute();

                return ['upload' => true, 'message' => 'file uploaded succesfully'];
            }
        }
    }
    /*
    public function callbackUpload()
    {
        try {
            $config = new \Flow\Config();
            $config->setTempDir(\yii::getAlias('@webroot/assets'));
            $request = new \Flow\Request();

            $fileName = \yii::getAlias('@webroot/assets').DIRECTORY_SEPARATOR.$request->getFileName();

            if (\Flow\Basic::save($fileName, $config, $request)) {
                // file saved successfully and can be accessed at './final_file_destination'

                $fileId = \yii::$app->storage->file->create($fileName, $request->getFileName());

                $imageId = \yii::$app->storage->image->create($fileId);

                @unlink($fileName);

                $in = \yii::$app->db->createCommand()->insert($this->refTableName, [
                    $this->imageIdFieldName => (int) $imageId,
                    $this->refFieldName => (int) $this->getItemId(),
                ])->execute();

                if ($in) {
                    return $imageId;
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    */
}

<?php

namespace admin\aws;

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
        foreach($data as $k => $v) {
            $files[] = [
                'source' => \yii::$app->luya->storage->image->filterApply($v['image_id'], 'small-crop')->source,
                'image_id' => $v['image_id'],
            ];
        }
        
        return $files;
    }
    
    public function callbackUpload()
    {
        try {
            $config = new \Flow\Config();
            $config->setTempDir(\yii::getAlias('@webroot/assets'));
            $request = new \Flow\Request();

            $fileName = \yii::getAlias('@webroot/assets').DIRECTORY_SEPARATOR.$request->getFileName();

            if (\Flow\Basic::save($fileName, $config, $request)) {
                // file saved successfully and can be accessed at './final_file_destination'

                $fileId = \yii::$app->luya->storage->file->create($fileName, $request->getFileName());

                $imageId = \yii::$app->luya->storage->image->create($fileId);

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
}

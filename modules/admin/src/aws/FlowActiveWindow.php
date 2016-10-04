<?php

namespace luya\admin\aws;

use Yii;
use yii\base\InvalidConfigException;
use Flow\Config;
use Flow\Request;
use Flow\File;
use luya\helpers\FileHelper;
use luya\admin\helpers\Storage;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Flow Uploader ActiveWindow enables multi image upload with chunck ability.
 *
 * The Flow ActiveWindow will not store any data in the filemanager as its thought to be used in large image upload
 * scenarios like galleries, event the image are chuncked into parts in order to enable large image uploads.
 *
 * Example use:
 *
 * ```
 * public function ngRestConfig($config)
 * {
 *     // ...
 *     $config->aw->load(['class' => FlowActiveWindow, 'modelClass' => self::className()]);
 * }
 * ```
 *
 * The property `modelClass` must be defined and the defined model class must implement the interface `FlowActiveWindowInterface`
 * in order to perfom all tasks defined in the FlowActiveWindow. There is also a helper Trait you can include in order to do
 * the basic jobs of such a image relation table.
 *
 *
 * [[\admin\aw\FlowActiveWindowTrait]]
 *
 * @since 1.0.0-beta7
 */
class FlowActiveWindow extends ActiveWindow
{
    public $module = '@admin';
    
    public $alias = 'Flow Uploader';
    
    public $icon = 'cloud_upload';
    
    public $modelClass = null;
    
    public function init()
    {
        parent::init();
        
        if ($this->modelClass === null) {
            throw new InvalidConfigException('The property modelClass can not be empty and is required for FlowActiveWindow.');
        }
    }
    
    /**
     * Renders the index file of the ActiveWindow.
     *
     * @return string The render index file.
     */
    public function index()
    {
        return $this->render('index', [
            'id' => $this->itemId,
        ]);
    }
    
    public function callbackList()
    {
        $data = $this->getModelItem()->flowListImages();
        
        $images = [];
        foreach (Yii::$app->storage->findImages(['in', 'id', $data]) as $item) {
            $images[$item->id] = $item->applyFilter('small-crop')->toArray();
        }
        
        return $this->sendSuccess('list loaded', [
            'images' => $images,
        ]);
    }
    
    private $_model = null;
    
    public function getModel()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->modelClass);
            
            if (!$this->_model instanceof FlowActiveWindowInterface) {
                throw new InvalidConfigException('The modelClass object must be instance of FlowActiveWindowInterface.');
            }
        }

        return $this->_model;
    }
    
    public function getModelItem()
    {
        return $this->model->findOne($this->itemId);
    }
    
    public function callbackRemove($imageId)
    {
        $image = Yii::$app->storage->getImage($imageId);
        
        if ($image) {
            $this->modelItem->flowDeleteImage($image);
            if (Storage::removeImage($image->id, true)) {
                return $this->sendSuccess('image has been removed');
            }
        }
        
        return $this->sendError('Unable to remove this image');
    }
    
    public function callbackUpload()
    {
        $config = new Config();
        $config->setTempDir($this->getTempFolder());
        $file = new File($config);
        $request = new Request();
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($file->checkChunk()) {
                header("HTTP/1.1 200 Ok");
            } else {
                header("HTTP/1.1 204 No Content");
                exit;
            }
        } else {
            if ($file->validateChunk()) {
                $file->saveChunk();
            } else {
                // error, invalid chunk upload request, retry
                header("HTTP/1.1 400 Bad Request");
                exit;
            }
        }
        if ($file->validateFile() && $file->save($this->getUploadFolder() . '/'.$request->getFileName())) {
            // File upload was completed
            $file = Yii::$app->storage->addFile($this->getUploadFolder() . '/'.$request->getFileName(), $request->getFileName(), 0, true);
            
            if ($file) {
                @unlink($this->getUploadFolder() . '/'.$request->getFileName());
                
                $image = Yii::$app->storage->addImage($file->id);
                if ($image) {
                    $image->applyFilter('small-crop');
                    
                    $model = $this->model;
                    $row = $this->getModelItem();
                    if ($row) {
                        $row->flowSaveImage($image);
                        return 'done';
                    }
                }
            }
        } else {
            // This is not a final chunk, continue to upload
        }
    }
    
    protected function getTempFolder()
    {
        $folder = Yii::getAlias('@runtime/flow-cache');
        
        if (!file_exists($folder)) {
            FileHelper::createDirectory($folder, 0777);
        }
        
        return $folder;
    }
    
    protected function getUploadFolder()
    {
        $folder = Yii::getAlias('@runtime/flow-upload');
        
        if (!file_exists($folder)) {
            FileHelper::createDirectory($folder, 0777);
        }
        
        return $folder;
    }
}

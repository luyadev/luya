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
 * scenarios like galleries. The image are chuncked into parts in order to enable large image uploads.
 *
 * Example use:
 *
 * ```php
 * public function ngRestActiveWindows()
 * {
 *   return [
 *       ['class' => \luya\admin\aws\FlowActiveWindow::class, 'label' => 'My Gallery'],
 *   ];
 * }
 * ```
 *
 * The attached model class must implement the interface {{\luya\admin\aws\FlowActiveWindowInterface}} in order to interact with thw Activ Window.
 *
 * There is also a helper Trait {{\luya\admin\aws\FlowActiveWindowTrait}} you can include in order to work with a relation table.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class FlowActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = '@admin';
    
    /**
     * @inheritdoc
     */
    public function index()
    {
        return $this->render('index');
    }
    
    /**
     * @inheritdoc
     */
    public function defaultLabel()
    {
        return 'Flow Uploader';
    }
    
    /**
     * @inheritdoc
     */
    public function defaultIcon()
    {
        return 'cloud_upload';
    }
    
    /**
     * @inheritdoc
     */
    public function getModel()
    {
        $model = parent::getModel();
        
        if (!$model instanceof FlowActiveWindowInterface) {
            throw new InvalidConfigException("The model ".$this->model->className()."which attaches the FlowActiveWindow must be an instance of luya\admin\aws\FlowActiveWindowInterface.");
        }
        
        return $model;
    }
    
    /**
     * Returns a list of uploaded images.
     *
     * @return array
     */
    public function callbackList()
    {
        $data = $this->model->flowListImages();
        
        $images = [];
        foreach (Yii::$app->storage->findImages(['in', 'id', $data]) as $item) {
            $images[$item->id] = $item->applyFilter('small-crop')->toArray();
        }
        
        return $this->sendSuccess('list loaded', [
            'images' => $images,
        ]);
    }
    
    /**
     * Remove a given image from the collection.
     *
     * @param integer $imageId
     * @return array
     */
    public function callbackRemove($imageId)
    {
        $image = Yii::$app->storage->getImage($imageId);
        
        if ($image) {
            $this->model->flowDeleteImage($image);
            if (Storage::removeImage($image->id, true)) {
                return $this->sendSuccess('image has been removed');
            }
        }
        
        return $this->sendError('Unable to remove this image');
    }
    
    /**
     * Flow Uploader Upload.
     *
     * @return string
     */
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
                    
                    $this->model->flowSaveImage($image);
                    return 'done';
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

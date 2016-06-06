<?php

namespace admin\aws;

use Yii;
use Flow\Config;
use Flow\Request;
use luya\helpers\FileHelper;
use yii\base\InvalidConfigException;
use Flow\File;

/**
 * Active Window created at 31.05.2016 15:45 on LUYA Version 1.0.0-beta7-dev.
 */
class FlowActiveWindow extends \admin\ngrest\base\ActiveWindow
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
	    
	    return $this->sendSuccess('list laoded', [
	        'data' => $data,
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
    	            $model = $this->model;
    	            $row = $this->getModelItem();
    	            if ($row) {
    	                $row->flowSaveImage($image);
    	                return $image->toArray();
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
	        return FileHelper::createDirectory($folder, 0777);
	    }
	    
	    return $folder;
	}
}
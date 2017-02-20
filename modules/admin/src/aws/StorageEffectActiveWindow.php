<?php

namespace luya\admin\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Storage Effect Active Window.
 *
 * File has been created with `aw/create` command on LUYA version 1.0.0-dev. 
 */
final class StorageEffectActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
    public $module = '@admin';
	
    /**
     * @var string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
    public $alias = 'Storage Effect Active Window';
	
    /**
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public $icon = 'extension';
	
    /**
     * The default action which is going to be requested when clicking the ActiveWindow.
     * 
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index', [
            'model' => $this->model,
            'images' => Yii::$app->storage->findImages(['filter_id' => $this->model->id]),
        ]);
    }
    
    public function callbackRemove()
    {
        $log = $this->model->removeImageSources();
        
        $error = false;
        
        foreach ($log as $image => $state) {
            if (!$state) {
                $error = true;
            }
        }
        
        if ($error) {
            return $this->sendError("One or more images could not be deleted. Deletable images are removed.");
        }
        
        return $this->sendSuccess("All image filter variations has been removed.");
    }
}
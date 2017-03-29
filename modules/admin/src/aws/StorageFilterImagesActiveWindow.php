<?php

namespace luya\admin\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Storage Effect Active Window.
 *
 * File has been created with `aw/create` command on LUYA version 1.0.0-dev.
 */
final class StorageFilterImagesActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
    public $module = '@admin';
    
    /**
     * @var string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
    public $alias = 'Images';
    
    /**
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public $icon = 'filter_vintage';
    
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
        $this->model->removeImageSources();
        
        return $this->sendSuccess("Removed image filter {this->model->name} versions.");
    }
}

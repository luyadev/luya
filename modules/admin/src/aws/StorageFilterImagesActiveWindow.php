<?php

namespace luya\admin\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Storage Effect Active Window.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class StorageFilterImagesActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the ActiveWindow is located in order to finde the view path.
     */
    public $module = '@admin';
    
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
    
    /**
     * @inheritdoc
     */
    public function defaultLabel()
    {
        return 'Images';
    }
    
    /**
     * @inheritdoc
     */
    public function defaultIcon()
    {
        return 'filter_vintage';
    }
    
    /**
     *
     * @return array
     */
    public function callbackRemove()
    {
        $this->model->removeImageSources();
        
        return $this->sendSuccess("Removed image filter {this->model->name} versions.");
    }
}

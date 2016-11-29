<?php

namespace luya\admin\aws;

use luya\admin\ngrest\base\ActiveWindow;

/**
 * Diplay Detail informations about an ActiveRecord model.
 */
class InfoActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = '@admin';
    
    /**
     * @var string The name of of the ActiveWindow. This is displayed in the CRUD list.
     */
    public $alias = 'Detail';
    
    /**
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public $icon = 'zoom_in';
    
    /**
     * Renders the index file of the ActiveWindow.
     *
     * @return string The render index file.
     */
    public function index()
    {
        return $this->render('index', [
            'id' => $this->itemId,
            'data' => $this->model->toArray(),
        ]);
    }
}

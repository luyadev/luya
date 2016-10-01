<?php

namespace luya\admin\aws;

use luya\admin\ngrest\base\ActiveWindow;

/**
 * Active Window created at 15.09.2016 14:35 on LUYA Version 1.0.0-RC1-dev.
 */
class InfoActiveWindow extends ActiveWindow
{
    public $module = '@admin';
    
    public $alias = 'Detail';
    
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

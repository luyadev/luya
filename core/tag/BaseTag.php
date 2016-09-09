<?php

namespace luya\tag;

use yii\base\Object;

/**
 * The BaseTag for all Tags.
 * 
 * @property \luya\web\View $view The view object in order to register scripts.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-rc1
 */
abstract class BaseTag extends Object implements TagInterface
{
    private $_view = null;
    
    /**
     * Get the view object to register assets in tags.
     * 
     * @return \luya\web\View
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }
    	
    	return $this->_view;
    }
}
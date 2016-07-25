<?php

namespace cmsadmin\base;

use Yii;
use yii\base\ViewContextInterface;

abstract class PhpBlock extends InternalBaseBlock implements PhpBlockInterface, ViewContextInterface
{
    private $_view = null;
    
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::createObject(PhpBlockView::className());
        }
        
        return $this->_view;
    }
    
    public function frontend()
    {
        $moduleName = $this->module;
        if (substr($moduleName, 0, 1) !== '@') {
            $moduleName = '@'.$moduleName;
        }
        
        return $this->view->render($this->getViewFileName('php'), [], $this);
    }
    
    public function renderFrontend()
    {
        return $this->frontend();
    }
    
    public function renderAdmin()
    {
        return $this->admin();
    }
}
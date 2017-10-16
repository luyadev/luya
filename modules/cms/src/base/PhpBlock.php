<?php

namespace luya\cms\base;

use Yii;
use yii\base\ViewContextInterface;

/**
 * Represents a CMS block with PHP views.
 *
 * @property \luya\cms\base\PhpBlockView $view View Object.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class PhpBlock extends InternalBaseBlock implements PhpBlockInterface, ViewContextInterface
{
    private $_view;
    
    /**
     * View Object getter.
     *
     * @return \luya\cms\base\PhpBlockView
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::createObject(PhpBlockView::class);
        }
        
        return $this->_view;
    }
    
    /**
     * Get relative view path ofr rendering view files.
     *
     * @see \yii\base\ViewContextInterface
     * @return string the view path that may be prefixed to a relative view name.
     */
    public function getViewPath()
    {
        return $this->ensureModule() . '/views/blocks';
    }
    
    /**
     * @inheritdoc
     */
    public function frontend()
    {
        return $this->view->render($this->getViewFileName('php'), [], $this);
    }
    
    /**
     * @inheritdoc
     */
    public function renderFrontend()
    {
        $this->injectorSetup();
        return $this->frontend();
    }
    
    /**
     * @inheritdoc
     */
    public function renderAdmin()
    {
        $this->injectorSetup();
        return $this->admin();
    }
}

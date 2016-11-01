<?php

namespace luya\cms\base;

use Yii;
use yii\base\ViewContextInterface;

/**
 * Represents a CMS block with PHP views.
 *
 * @property \luya\web\View $view View Object.
 *
 * @since 1.0.0-beta8
 * @author Basil Suter <basil@nadar.io>
 */
abstract class PhpBlock extends InternalBaseBlock implements PhpBlockInterface, ViewContextInterface
{
    private $_view = null;
    
    /**
     * View Object getter.
     *
     * @return object|mixed
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
     * {@inheritDoc}
     * @see \luya\cms\base\PhpBlockInterface::frontend()
     */
    public function frontend()
    {
        return $this->view->render($this->getViewFileName('php'), [], $this);
    }
    
    /**
     * {@inheritDoc}
     * @see \luya\cms\base\BlockInterface::renderFrontend()
     */
    public function renderFrontend()
    {
        $this->injectorSetup();
        return $this->frontend();
    }
    
    /**
     * {@inheritDoc}
     * @see \luya\cms\base\BlockInterface::renderAdmin()
     */
    public function renderAdmin()
    {
        $this->injectorSetup();
        return $this->admin();
    }
}

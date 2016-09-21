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
     * {@inheritDoc}
     * @see \luya\cms\base\PhpBlockInterface::frontend()
     */
    public function frontend()
    {
        return $this->view->render($this->getViewFileName('php'), [
            'vars' => $this->getVarValues(),
            'cfgs' => $this->getCfgValues(),
            'placeholders' => $this->getPlaceholderValues(),
            'extras' => $this->extraVarsOutput(),
        ], $this);
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

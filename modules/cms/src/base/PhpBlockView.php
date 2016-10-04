<?php

namespace luya\cms\base;

use luya\web\View;

/**
 * View context helper of php block view file.
 *
 * @property \luya\cms\base\PhpBlock $context Get the block context.
 * @property integer $index
 * @property boolean $isFirst
 * @property boolean $isLast
 * @property integer $itemsCount
 * @property boolean $isNextEqual
 * @property boolean $isLastEqual
 *
 * @since 1.0.0-beta8
 * @author Basil Suter <basil@nadar.io>
 */
class PhpBlockView extends View
{
    public function getIndex()
    {
        return $this->context->getEnvOption('index');
    }
    
    public function getIsFirst()
    {
        return $this->context->getEnvOption('isFirst');
    }
    
    public function getIsLast()
    {
        return $this->context->getEnvOption('isLast');
    }
    
    public function getItemsCount()
    {
        return $this->context->getEnvOption('itemsCount');
    }
    
    public function getIsNextEqual()
    {
        return $this->context->getEnvOption('isNextEqual');
    }
    
    public function getIsPrevEqual()
    {
        return $this->context->getEnvOption('isPrevEqual');
    }
}

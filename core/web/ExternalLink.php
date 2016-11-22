<?php

namespace luya\web;

use yii\base\Object;
use luya\helpers\Url;
use yii\base\InvalidConfigException;

/**
 * Generate External Link object.
 *
 * @property string $href The external href link will be http ensured on set.
 * @author Basil Suter <basil@nadar.io>
 */
class ExternalLink extends Object implements LinkInterface
{
    use LinkTrait;

    public function init()
    {
        parent::init();
        
        if ($this->href === null) {
            throw new InvalidConfigException('The href attribute can not be empty and must be set trough configuration array.');
        }
    }
    
    private $_href = null;
    
    public function setHref($href)
    {
        $this->_href = Url::ensureHttp($href);
    }
    
    public function getHref()
    {
        return $this->_href;
    }
    
    public function getTarget()
    {
        return '_blank';
    }
}

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
 * @since 1.0.0-RC2
 */
class ExternalLink extends Object implements LinkInterface
{
    use LinkTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->href === null) {
            throw new InvalidConfigException('The href attribute can not be empty and must be set trough configuration array.');
        }
    }
    
    private $_href = null;
    
    /**
     * Set the href value for an external link resource.
     * 
     * @param string $href The external link href value, the http protcol will be ensured.
     */
    public function setHref($href)
    {
        $this->_href = Url::ensureHttp($href);
    }
    
    /**
     * @inheritdoc
     */
    public function getHref()
    {
        return $this->_href;
    }
    
    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return '_blank';
    }
}

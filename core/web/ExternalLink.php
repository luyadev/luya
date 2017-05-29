<?php

namespace luya\web;

use yii\base\Object;
use luya\helpers\Url;
use yii\base\InvalidConfigException;
use yii\base\ArrayableTrait;
use yii\base\Arrayable;
use luya\helpers\StringHelper;

/**
 * Generate External Link object.
 *
 * When href is provided without a protocol, for example `//go/there` the slashes are replaced
 * by the current base absolute base URL.
 *
 * @property string $href The external href link will be http ensured on set.
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ExternalLink extends Object implements LinkInterface, Arrayable
{
    use LinkTrait, ArrayableTrait;
    
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
    
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ['href', 'target'];
    }
    
    private $_href;
    
    /**
     * Set the href value for an external link resource.
     *
     * @param string $href The external link href value, the http protcol will be ensured.
     */
    public function setHref($href)
    {
        if (StringHelper::startsWith($href, '//')) {
            $this->_href = Url::base(true) . str_replace('//', '/', $href);
        } else {
            $this->_href = Url::ensureHttp($href);
        }
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

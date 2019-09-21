<?php

namespace luya\tag\tags;

use luya\tag\BaseTag;
use luya\helpers\Url;
use luya\helpers\StringHelper;
use yii\helpers\Html;

/**
 * TagParser Link Tag.
 *
 * Generate a link to an external page or an internal page url (target blank difference).
 *
 * In order to call an internal url use the `//` prefix like `link[//contact](Go to contact)` now the `//` are replace by your local
 * url of the server. In order to generate an external url use `link[luya](Go to Luya.io)`.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LinkTag extends BaseTag
{
    /**
     * An example of how to use the LinkTag.
     *
     * @return string The example string
     * @see \luya\tag\TagInterface::example()
     */
    public function example()
    {
        return 'link[luya.io](Visit us!)';
    }
    
    /**
     * The readme instructions string for the LinkTag.
     *
     * @return string The readme text.
     * @see \luya\tag\TagInterface::readme()
     */
    public function readme()
    {
        return 'Generate a link to an external page or an internal page. 
        In order to call an internal URL use the `//` prefix like `link[//contact](Go to contact)`, now the `//` are replace by the url of the webserver. 
        If a single `/` is used its a relative url and therfore won\'t be changed.
        In order to generate an external url use `link[luya.io](Go to Luya.io)`.';
    }
    
    /**
     * Generate the Link Tag.
     *
     * @param string $value The Brackets value `[]`.
     * @param string $sub The optional Parentheses value `()`
     * @see \luya\tag\TagInterface::parse()
     * @return string The parser tag.
     */
    public function parse($value, $sub)
    {
        if (StringHelper::startsWith($value, '//')) {
            // its an absolute url
            $value = StringHelper::replaceFirst('//', Url::base(true) . '/', $value);
            $external = false;
        } elseif (StringHelper::startsWith($value, '/')) {
            // its a relative url, keep it like this
            $external = false;
        } else {
            $value = Url::ensureHttp($value);
            $external = true;
        }
        
        $label = empty($sub) ? $value : $sub;
        
        return Html::a($label, $value, ['class' => $external ? 'link-external' : 'link-internal', 'target' => $external ? '_blank' : null]);
    }
}

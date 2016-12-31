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
 * In order to call an interanl ure use the `//` prefix like `link[//contact](Go to contact)` now the `//` are replace by your local
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
        return 'Generate a link to an external page or an internal page url (target blank differenc). In order to call an interanl ure use the `//` prefix like `link[//contact](Go to contact)` now the `//` are replace by your local url of the server. In order to generate an external url use `link[luya](Go to Luya.io)`.';
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
        if (substr($value, 0, 2) == '//') {
            $value = StringHelper::replaceFirst('//', Url::base(true) . '/', $value);
            $external = false;
        } else {
            $external = true;
        }
        
        $value = Url::ensureHttp($value);
        $label = empty($sub) ? $value : $sub;
        
        return Html::a($label, $value, ['class' => $external ? 'link-external' : 'link-internal', 'target' => $external ? '_blank' : null]);
    }
}

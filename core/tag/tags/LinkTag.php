<?php

namespace luya\tag\tags;

use luya\tag\BaseTag;
use luya\helpers\Url;
use luya\helpers\StringHelper;
use yii\helpers\Html;

/**
 * Generate links for internal and external pages.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class LinkTag extends BaseTag
{
    public function example()
    {
        return 'link[luya.io](Visit us!)';
    }
    
    public function readme()
    {
        return 'Generate a link to an external page or an internal page url (target blank differenc). In order to call an interanl ure use the `//` prefix like `link[//contact](Go to contact)` now the `//` are replace by your local url of the server. In order to generate an external url use `link[luya](Go to Luya.io)`.';
    }
    
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
        
        return Html::a($label, $value, ['class' => $external ? 'link-external' : 'link-internal', 'label' => $label, 'target' => $external ? '_blank' : null]);
    }
}

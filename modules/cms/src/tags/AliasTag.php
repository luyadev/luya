<?php

namespace luya\cms\tags;

use Yii;
use luya\tag\BaseTag;

/**
 * Access Application Aliases.
 *
 * This tag allows you to access the defined aliases from the application.
 *
 * Predefined: http://www.yiiframework.com/doc-2.0/guide-concept-aliases.html#predefined-aliases
 *
 * @author Basil Suter <basil@nadar.io
 * @since 1.0.0
 */
class AliasTag extends BaseTag
{
    public function example()
    {
        return 'alias[@web]';
    }
    
    public function readme()
    {
        return 'The alias tag allows you to use aliaes defined in your application and predefined. Image link to public html folder <img src=\"alias[@web]/image.jpg\">';
    }
    
    public function parse($value, $sub)
    {
        return Yii::getAlias($value, false);
    }
}

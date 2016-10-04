<?php

namespace luya\tag\tags;

use yii\helpers\Html;
use luya\tag\BaseTag;

/**
 * Mail Tag converts mail[foo@bar.com] into E-Mail clickable Links with the TagParser.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-rc1
 */
class MailTag extends BaseTag
{
    public function example()
    {
        return 'mail[info@luya.io](Mail us!)';
    }
    
    public function readme()
    {
        return <<<EOT
The mail Tag allows you to create E-Mail links to an adress. Example use `mail[info@luya.io]` or with an additional value info use `mail[info@luya.io](send mail)`.      
EOT;
    }
    
    public function parse($value, $sub)
    {
        return Html::mailto((!empty($sub)) ? $sub : $value, $value);
    }
}

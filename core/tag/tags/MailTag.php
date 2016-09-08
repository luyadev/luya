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
    public function readme()
    {
        return '** WIKI**';
    }
    
    public function parse($value, $sub)
    {
        return Html::mailto((!empty($sub)) ? $sub : $value, $value);
    }
}
<?php

namespace luya\tag\tags;

use yii\helpers\Html;
use luya\tag\BaseTag;

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
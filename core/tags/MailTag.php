<?php

namespace luya\tags;

use yii\helpers\Html;
use luya\base\BaseTag;

class MailTag extends BaseTag
{
    public function getReadmeMarkdown()
    {
        return '** WIKI**';
    }
    
    public function parse($value, $sub)
    {
        return Html::mailto((!empty($sub)) ? $sub : $value, $value);
    }
}
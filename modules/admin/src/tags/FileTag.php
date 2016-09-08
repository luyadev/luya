<?php

namespace luya\admin\tags;

use Yii;
use luya\tag\BaseTag;
use yii\helpers\Html;

class FileTag extends BaseTag
{
    public function readme()
    {
        return '**FILE TAG**';
    }
    
    public function parse($value, $sub)
    {
        $file = Yii::$app->storage->getFile($value);
        
        if (!$file) {
            return false;
        }
        
        return Html::a(!empty($sub) ? $sub : $file->name, $file->sourceStatic, ['target' => '_blank']);
    }
}
<?php

namespace luya\admin\tags;

use Yii;
use luya\tag\BaseTag;
use yii\helpers\Html;

/**
 * File Tag.
 *
 * Generates a link to a target file in a new window.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class FileTag extends BaseTag
{
    public function example()
    {
        return 'file[123](Open Me!)';
    }
    
    public function readme()
    {
        return <<<EOT
Generat a link to a provided file. For Example `file[1]` will generate a link to the file but when you want to the an alternative text `file[1](My Text)` use the example.    
EOT;
    }
    
    public function parse($value, $sub)
    {
        $file = Yii::$app->storage->getFile($value);
        
        if (!$file) {
            return false;
        }
        
        return Html::a(!empty($sub) ? $sub : $file->name, $file->href, ['target' => '_blank']);
    }
}

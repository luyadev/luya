<?php

namespace luya\cms\tags;

use Yii;
use luya\tag\BaseTag;
use yii\helpers\Html;

/**
 * Menu links tag
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MenuTag extends BaseTag
{
    public function example()
    {
        return 'menu[123](Go to Page 123)';
    }
    
    public function readme()
    {
        return <<<EOT
Generate a link to a menu point where the key is the id of the navigation item (you can see the page id when hover over the main in the administration area).
EOT;
    }

    public function parse($value, $sub)
    {
        $menuItem = Yii::$app->menu->find()->where(['nav_id' => $value])->with('hidden')->one();
        
        if ($menuItem) {
            $alias = (empty($sub)) ? $menuItem->title : $sub;
            
            return Html::a($alias, $menuItem->link);
        }
        
        return false;
    }
}

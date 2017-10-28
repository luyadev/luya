<?php

namespace luya\cms\admin\apis;

use Yii;

/**
 * Block Api delivers all availables CMS Blocks.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BlockController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\cms\models\Block';
    
    public function actionToFav()
    {
        $block = Yii::$app->request->getBodyParam('block');
        
        if (!empty($block)) {
            return Yii::$app->adminuser->identity->setting->set("blockfav.{$block['id']}", $block);
        }
    }
    
    public function actionRemoveFav()
    {
        $block = Yii::$app->request->getBodyParam('block');
        
        if (!empty($block)) {
            return Yii::$app->adminuser->identity->setting->remove("blockfav.{$block['id']}");
        }
    }
    
    public function actionToggleGroup()
    {
        $group = Yii::$app->request->getBodyParam('group');
        
        if (!empty($group)) {
            return Yii::$app->adminuser->identity->setting->set("togglegroup.{$group['id']}", (int) $group['toggle_open']);
        }
    }
}

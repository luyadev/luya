<?php

namespace cmsadmin\apis;

use Yii;
use cmsadmin\models\Layout;
use cmsadmin\models\Block;
use cmsadmin\models\BlockGroup;
use luya\helpers\ArrayHelper;

/**
 * Admin Api delievers common api tasks like blocks and layouts.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class AdminController extends \admin\base\RestController
{
    public function actionDataBlocks()
    {
        $favs = Yii::$app->adminuser->identity->setting->get("blockfav", []);
        
        $groups = [];
        foreach (BlockGroup::find()->asArray()->all() as $group) {
            $blocks = [];
            foreach (Block::find()->where(['group_id' => $group['id']])->all() as $block) {
                $obj = Block::objectId($block['id'], 0, 'admin');
                if (!$obj || in_array($obj->className(), Yii::$app->getModule('cmsadmin')->hiddenBlocks)) {
                    continue;
                }
                $blocks[] = [
                    'id' => $block['id'],
                    'name' => $obj->name(),
                    'full_name' => $obj->getFullName(),
                    'favorized' => array_key_exists($block['id'], $favs),
                ];
            }

            if (empty($blocks)) {
                continue;
            }
            
            $group['is_fav'] = 0;
            $group['toggle_open'] = (int) Yii::$app->adminuser->identity->setting->get("togglegroup.{$group['id']}", 1);
            $groups[] = [
                'group' => $group,
                'blocks' => $blocks,
            ];
        }

        if (!empty($favs)) {

            $favblocks = [];
            foreach ($favs as $fav) {
                $favblocks[] = $fav;
            }
            
            array_unshift($groups, [
                'group' => [
                    'toggle_open' => (int) Yii::$app->adminuser->identity->setting->get("togglegroup.99999", 1),
                    'id' => '99999',
                    'is_fav' => 1,
                    'name' => 'Favorites',
                    'identifier' => 'favs',
                ],
                'blocks' => $favblocks,
            ]);
        }
        
        return $groups;
    }

    public function actionDataLayouts()
    {
        return ArrayHelper::typeCast(Layout::find()->asArray()->all());
    }
}

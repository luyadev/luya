<?php

namespace luya\cms\admin\apis;

use Yii;
use luya\cms\models\Layout;
use luya\cms\models\Block;
use luya\cms\models\BlockGroup;
use luya\helpers\ArrayHelper;
use luya\cms\admin\Module;
use luya\cms\models\Config;

/**
 * Admin Api delievers common api tasks like blocks and layouts.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class AdminController extends \luya\admin\base\RestController
{
    public function actionConfig()
    {
        // valid keys
        $keys = [Config::HTTP_EXCEPTION_NAV_ID];
        
        foreach (Yii::$app->request->bodyParams as $key => $value) {
            if (in_array($key, $keys)) {
                Config::set($key, $value);
            }
        }
        
        $data = [];
        $data[Config::HTTP_EXCEPTION_NAV_ID] = Config::get(Config::HTTP_EXCEPTION_NAV_ID, 0);
        
        return $data;
    }
    
    public function actionDataBlocks()
    {
        $favs = Yii::$app->adminuser->identity->setting->get("blockfav", []);
        
        $groups = [];
        foreach (BlockGroup::find()->asArray()->all() as $group) {
            $blocks = [];
            $groupPosition = null;
            foreach (Block::find()->where(['group_id' => $group['id']])->all() as $block) {
                $obj = Block::objectId($block['id'], 0, 'admin');
                if (!$obj || in_array(get_class($obj), Yii::$app->getModule('cmsadmin')->hiddenBlocks)) {
                    continue;
                }
                
                if ($groupPosition == null) {
                    $groupObject = Yii::createObject($obj->blockGroup());
                    $groupPosition = $groupObject->getPosition();
                }
                $blocks[] = [
                    'id' => $block['id'],
                    'name' => $obj->name(),
                    'full_name' => ($obj->icon() === null) ? $obj->name() : '<i class="material-icons">'.$obj->icon().'</i> <span>'.$obj->name().'</span>',
                    'favorized' => array_key_exists($block['id'], $favs),
                ];
            }

            if (empty($blocks)) {
                continue;
            }
            
            $group['is_fav'] = 0;
            $group['toggle_open'] = (int) Yii::$app->adminuser->identity->setting->get("togglegroup.{$group['id']}", 1);
            $groups[] = [
                'groupPosition' => $groupPosition,
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
                    'name' => Module::t('block_group_favorites'),
                    'identifier' => 'favs',
                    'position' => 0,
                ],
                'groupPosition' => 0,
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

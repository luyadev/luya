<?php

namespace cmsadmin\apis;

use cmsadmin\models\Layout;
use cmsadmin\models\Block;
use cmsadmin\models\BlockGroup;
use luya\helpers\ArrayHelper;

/**
 * api-cms-admin.
 *
 * Basic admin rest jobs
 *
 * @author nadar
 */
class AdminController extends \admin\base\RestController
{
    public function actionDataBlocks()
    {
        $groups = [];
        foreach (BlockGroup::find()->asArray()->all() as $group) {
            $blocks = [];
            foreach (Block::find()->where(['group_id' => $group['id']])->all() as $block) {
                $obj = Block::objectId($block['id'], 0, 'admin');
                if (!$obj) {
                    continue;
                }
                $blocks[] = [
                    'id' => $block['id'],
                    'name' => $obj->name(),
                    'full_name' => $obj->getFullName(),
                ];
            }

            $groups[] = [
                'group' => $group,
                'blocks' => $blocks,
            ];
        }

        return $groups;
    }

    public function actionDataLayouts()
    {
        return ArrayHelper::typeCast(Layout::find()->asArray()->all());
    }
}

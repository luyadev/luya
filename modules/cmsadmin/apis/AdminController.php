<?php

namespace cmsadmin\apis;

use cmsadmin\models\Block;
use cmsadmin\models\BlockGroup;

/**
 * api-cms-admin.
 *
 * Basic admin rest jobs
 *
 * @author nadar
 */
class AdminController extends \admin\base\RestController
{
    public function actionGetAllBlocks()
    {
        $groups = [];
        foreach (BlockGroup::find()->asArray()->all() as $group) {
            
            $blocks = [];
            foreach(Block::find()->where(['group_id' => $group['id']])->all() as $block) {
                $obj = Block::objectId($block['id']);
                $blocks[] = [
                    'id' => $block['id'],
                    'name' => $obj->getFullName(),
                ];
            }
            
            $groups[] = [
                'group' => $group,
                'blocks' => $blocks,
            ];
        }
        return $groups;
    }
    
    /*
    public function actionGetAllBlocks()
    {
        $data = [];
        foreach (\cmsadmin\models\Block::find()->all() as $item) {
            $object = \cmsadmin\models\Block::objectId($item['id']);
            if ($object) {
                $data[] = [
                    'id' => $item['id'],
                    'name' => $object->name(),
                ];
            }
        }

        return $data;
    }
    */
}

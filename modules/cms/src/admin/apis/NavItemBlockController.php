<?php

namespace luya\cms\admin\apis;

use luya\cms\models\NavItemPageBlockItem;
use Yii;

/**
 * NavItemBlock Api provides the block copy from stack action.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NavItemBlockController extends \luya\admin\base\RestController
{
    /**
     * Copy all attached sub blocks (referencing sourceId) into new context and update prevId to sourceId
     *
     * @param $sourceId
     * @param $targetPrevId
     * @param $targetNavItemPageId
     */
    private function copySubBlocksTo($sourceId, $targetPrevId, $targetNavItemPageId)
    {
        if ($sourceId) {
            $subBlocks = NavItemPageBlockItem::findAll(['prev_id' => $sourceId]);
            foreach ($subBlocks as $block) {
                $newBlock = new NavItemPageBlockItem();
                $newBlock->attributes = $block->toArray();
                $newBlock->nav_item_page_id = $targetNavItemPageId;
                $newBlock->prev_id = $targetPrevId;
                $newBlock->insert();

                // check for attached sub blocks and start recursion
                $attachedBlocks = NavItemPageBlockItem::findAll(['prev_id' => $block->id]);
                if ($attachedBlocks) {
                    $this->copySubBlocksTo($block->id, $newBlock->id, $targetNavItemPageId);
                }
            }
        }
    }

    public function actionCopyBlockFromStack()
    {
        $model = NavItemPageBlockItem::findOne(Yii::$app->request->post('copyBlockId', 0));

        if (($model) && ((Yii::$app->request->post('copyBlockId', 0) !== Yii::$app->request->post('prevId', false)))) {
            $newModel = new NavItemPageBlockItem();
            $newModel->attributes = $model->toArray();
            $newModel->is_dirty = 0;
            $newModel->prev_id = Yii::$app->request->post('prevId', false);
            $newModel->placeholder_var = Yii::$app->request->post('placeholder_var', false);
            $newModel->sort_index = Yii::$app->request->post('sortIndex', false);
            $newModel->nav_item_page_id = Yii::$app->request->post('nav_item_page_id', false);

            if ($newModel->insert(false)) {
                $this->copySubBlocksTo(Yii::$app->request->post('copyBlockId', false), $newModel->id, $newModel->nav_item_page_id);
                return ['response' => true];
            }
        }
        
        return ['response' => false];
    }
}

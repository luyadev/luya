<?php

namespace luya\cms\admin\apis;

use luya\cms\models\NavItemPageBlockItem;
use Yii;

/**
 * NavItemBlock Api provides the block copy from stack action.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
        $model = NavItemPageBlockItem::findOne(Yii::$app->request->getBodyParam('copyBlockId', 0));

        if (($model) && ((Yii::$app->request->getBodyParam('copyBlockId', 0) !== Yii::$app->request->getBodyParam('prev_id', false)))) {
            $newModel = new NavItemPageBlockItem();
            $newModel->attributes = $model->toArray();
            $newModel->is_dirty = true;
            $newModel->prev_id = Yii::$app->request->getBodyParam('prev_id', false);
            $newModel->placeholder_var = Yii::$app->request->getBodyParam('placeholder_var', false);
            $newModel->sort_index = Yii::$app->request->getBodyParam('sort_index', false);
            $newModel->nav_item_page_id = Yii::$app->request->getBodyParam('nav_item_page_id', false);

            if ($newModel->insert()) {
                $this->copySubBlocksTo(Yii::$app->request->getBodyParam('copyBlockId', false), $newModel->id, $newModel->nav_item_page_id);
                return ['response' => true];
            }
        }
        
        return ['response' => false];
    }
}

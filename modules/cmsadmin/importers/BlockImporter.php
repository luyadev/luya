<?php

namespace cmsadmin\importers;

use Yii;
use cmsadmin\models\Block;

/**
 * Class BlockImporter
 * Find and import all blocks from folder 'blocks' into the database and delete all blocks which aren't found in the filesystem but in the database
 *
 * @author nadar
 * @package cmsadmin\importers
 *
 */
class BlockImporter extends \luya\base\Importer
{
    /**
     * Importer function to find all blocks in local folder 'blocks' and import them into the database and delete all other blocks
     *
     */
    public function run()
    {
        $allblocks = Block::find()->all();
        $exists = [];
        /// find all blocks in filesystem and import them if they aren't found in the database
        foreach ($this->getImporter()->getDirectoryFiles('blocks') as $file) {
            $ns = $file['ns'];
            $model = Block::find()->where(['class' => $ns])->asArray()->one();
            if (!$model) {
                $block = new Block();
                $block->scenario = 'commandinsert';
                $block->setAttributes([
                    'group_id' => 1,
                    'system_block' => 0,
                    'class' => $ns,
                ]);
                $block->insert();
                $this->getImporter()->addLog('block', $ns.' new block has been added to database.');
            } else {
                $this->getImporter()->addLog('block', $ns.' already in the database.');
                $exists[] = $model['id'];
            }
        }
        /// check if there are blocks in the database which aren't in the filesystem and delete them
        foreach ($allblocks as $block) {
            if (!in_array($block->id, $exists)) {
                $this->getImporter()->addLog('block', 'block id '.$block->id.' removed from database.');
                $block->delete();

                /// consistency check: find all occurrences and implied dependencies
                $query = new \yii\db\Query();
                $query->select('nav_item_page_id')->from('cms_nav_item_page_block_item')->where(['block_id' => $block->id])->all();
                $navItemPageIdList = [];
                foreach($query->each() as $navItem) {
                    $navItemPageIdList[] = $navItem['nav_item_page_id'];
                }
                $navItemPageIdList = array_unique($navItemPageIdList);

                if(!empty($navItemPageIdList)) {
                    Yii::$app->db->createCommand()->delete('cms_nav_item_page_block_item', ['in','nav_item_page_id',$navItemPageIdList])->execute();
                    Yii::$app->db->createCommand()->delete('cms_nav_item_page', ['in','id',$navItemPageIdList])->execute();

                    $query->select('nav_id')->from('cms_nav_item')->where(['in','nav_item_type_id',$navItemPageIdList])->all();
                    $navIdList = [];
                    foreach($query->each() as $navId) {
                        $navIdList[] = $navId['nav_id'];
                    }
                    $navIdList = array_unique($navIdList);

                    if(!empty($navIdList)) {
                        Yii::$app->db->createCommand()->delete('cms_nav', ['in','id',$navIdList])->execute();
                    }

                    Yii::$app->db->createCommand()->delete('cms_nav_item', ['in','nav_item_type_id',$navItemPageIdList])->execute();
                }
            }
        }
    }
}

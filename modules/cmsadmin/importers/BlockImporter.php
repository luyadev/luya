<?php

namespace cmsadmin\importers;

use cmsadmin\models\Block;

class BlockImporter extends \luya\base\Importer
{
    public function run()
    {
        $allblocks = Block::find()->all();
        $exists = [];
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
        foreach ($allblocks as $block) {
            if (!in_array($block->id, $exists)) {
                $this->getImporter()->addLog('block', 'block id '.$block->id.' removed from database.');
                $block->delete();
            }
        }
    }
}

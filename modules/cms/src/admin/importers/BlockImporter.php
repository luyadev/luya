<?php

namespace luya\cms\admin\importers;

use Yii;
use luya\cms\models\Block;
use luya\cms\models\BlockGroup;
use luya\console\Importer;

class BlockImporter extends Importer
{
    public function run()
    {
        $allblocks = Block::find()->all();
        $exists = [];
        
        foreach ($this->getImporter()->getDirectoryFiles('blocks') as $file) {
            $ns = $file['ns'];
            $model = Block::find()->where(['class' => $ns])->one();
        
            $blockObject = $this->createBlockObject($file['ns']);
            $blockGroupId = $this->getBlockGroupId($blockObject);
            
            if (!$model) {
                $block = new Block();
                $block->group_id = $blockGroupId;
                $block->class = $ns;
                $block->save();
                $this->addLog($ns.' new block has been added to database.');
            } else {
                $model->updateAttributes(['group_id' => $blockGroupId]);
                $exists[] = $model->id;
            }
        }
        foreach ($allblocks as $block) {
            if (!in_array($block->id, $exists)) {
                $this->addLog('block id '.$block->id.' removed from database.');
                $block->delete();
            }
        }
    }
    
    private function createBlockObject($ns)
    {
        return new $ns();
    }
    
    private function getBlockGroupId($blockObject)
    {
        $groupClassName = $blockObject->blockGroup();
        
        $identifier = Yii::createObject(['class' => $groupClassName])->identifier();
        
        return BlockGroup::findOne(['identifier' => $identifier])->id;
    }
}

<?php

namespace luya\cms\admin\importers;

use Yii;
use luya\cms\models\Block;
use luya\cms\models\BlockGroup;
use luya\console\Importer;
use luya\admin\models\Config;
use yii\console\Exception;

class BlockImporter extends Importer
{
    public function run()
    {
        $allblocks = Block::find()->all();
        
        if (count($allblocks) == 0) {
            Config::set('rc1_block_classes_renameing', true);
        }
        
        if (!Config::has('rc1_block_classes_renameing')) {
            throw new Exception("You have to run the cmsadmin/updater/classes command in order to run the importer!");
        }
        
        $exists = [];
        
        foreach ($this->getImporter()->getDirectoryFiles('blocks') as $file) {
            $ns = $file['ns'];
            $model = Block::find()->where(['class' => $ns])->one();
        
            $blockObject = $this->createBlockObject($file['ns']);
            $blockGroupId = $this->getBlockGroupId($blockObject);
            
            if (!$model) {
                $block = new Block();
                $block->scenario = 'commandinsert';
                $block->setAttributes([
                    'group_id' => $blockGroupId,
                    'class' => $ns,
                ]);
                $block->insert();
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
        $groupClassName = $blockObject->getBlockGroup();
        
        $identifier = Yii::createObject(['class' => $groupClassName])->identifier();
        
        return BlockGroup::findOne(['identifier' => $identifier])->id;
    }
}

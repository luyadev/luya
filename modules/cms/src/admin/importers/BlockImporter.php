<?php

namespace luya\cms\admin\importers;

use Yii;
use luya\cms\models\Block;
use luya\cms\models\BlockGroup;
use luya\console\Importer;
use luya\helpers\FileHelper;
use luya\cms\base\BlockInterface;

/**
 * Import cms Blocks.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class BlockImporter extends Importer
{
    /**
     * {@inheritDoc}
     * @see \luya\console\Importer::run()
     */
    public function run()
    {
        $allblocks = Block::find()->all();
        $exists = [];
        
        foreach ($this->getImporter()->getDirectoryFiles('blocks') as $file) {
            $exists[] = $this->saveBlock($file['ns']);
        }
        
        foreach (Yii::$app->packageInstaller->configs as $config) {
            foreach ($config->blocks as $block) {
                if (is_file($block)) {
                    $exists[] = $this->saveBlockByPath($blockItem);
                } elseif (is_dir($block)) {
                    foreach (FileHelper::findFiles($block) as $blockItem) {
                        $exists[] = $this->saveBlockByPath($blockItem);
                    }
                }
            }
        }
        
        foreach ($allblocks as $block) {
            if (!in_array($block->id, $exists)) {
                $this->addLog('- Deleted block ID '.$block->id.' from database.');
                $block->delete();
            }
        }
    }
    
    /**
     *
     * @param unknown $fullClassName
     * @return number
     */
    protected function saveBlock($fullClassName)
    {
        // ensure all classes start with trailing slash class name definition like `\foo\bar\Class`
        $fullClassName = '\\'  . ltrim($fullClassName, '\\');
        $model = Block::find()->where(['class' => $fullClassName])->one();
        
        $blockObject = $this->createBlockObject($fullClassName);
        
        $blockGroupId = $this->getBlockGroupId($blockObject);
        
        if (!$model) {
            $model = new Block();
            $model->group_id = $blockGroupId;
            $model->class = $fullClassName;
            $model->save();
            $this->addLog("+ Added block '{$fullClassName}' to database.");
        } else {
            $model->updateAttributes(['group_id' => $blockGroupId]);
        }
        
        return $model->id;
    }
    
    /**
     *
     * @param unknown $path
     * @return number|boolean
     */
    protected function saveBlockByPath($path)
    {
        $info = FileHelper::classInfo($path);
        
        if ($info) {
            $className = $info['namespace'] . '\\' . $info['class'];
            
            return $this->saveBlock($className);
        }
        
        return false;
    }
    
    /**
     *
     * @param unknown $className
     * @return object|mixed
     */
    protected function createBlockObject($className)
    {
        return Yii::createObject(['class' => $className]);
    }
    
    /**
     *
     * @param BlockInterface $blockObject
     * @return unknown
     */
    protected function getBlockGroupId(BlockInterface $blockObject)
    {
        $groupClassName = $blockObject->blockGroup();
        
        $groupObject = Yii::createObject(['class' => $groupClassName]);
        
        $group = BlockGroup::findOne(['identifier' => $groupObject->identifier()]);
        
        if ($group) {
            $group->updateAttributes([
                'name' => $groupObject->label(),
            ]);
            return $group->id;
        } else {
            $model = new BlockGroup();
            $model->name = $groupObject->label();
            $model->identifier = $groupObject->identifier();
            $model->created_timestamp = time();
            if ($model->save()) {
                return $model->id;
            }
        }
        
        return 0;
    }
}

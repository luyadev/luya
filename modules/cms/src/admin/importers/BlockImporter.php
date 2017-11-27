<?php

namespace luya\cms\admin\importers;

use Yii;
use luya\cms\models\Block;
use luya\cms\models\BlockGroup;
use luya\console\Importer;
use luya\helpers\FileHelper;
use luya\cms\base\BlockInterface;
use luya\admin\models\Config;
use luya\cms\Exception;

/**
 * CMS Blocks Importer.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BlockImporter extends Importer
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        // when the setup timestamp is not yet set, its a fresh installation, therefore skip the 1.0.0 generic block upgrade
        // otherwise its an existing/upgrading instance which is doing the import command.
        if (!Config::has(Config::CONFIG_SETUP_COMMAND_TIMESTAMP)) {
            Config::set('100genericBlockUpdate', true);
        }
        
        if (!Config::has('100genericBlockUpdate')) {
            throw new Exception("You have to run the generic block updater. ./vendor/bin/luya cms/updater/generic");
        }
        
        $allblocks = Block::find()->all();
        $exists = [];
        
        foreach ($this->getImporter()->getDirectoryFiles('blocks') as $file) {
            $exists[] = $this->saveBlock($file['ns']);
        }
        
        foreach (Yii::$app->packageInstaller->configs as $config) {
            foreach ($config->blocks as $block) {
                if (is_file($block)) {
                    $exists[] = $this->saveBlockByPath($block);
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
        
        // remove unused block groups
        
        foreach (BlockGroup::find()->where(['not in', 'id', $this->blockGroupIds])->all() as $oldBlockGroup) {
            if ($oldBlockGroup->delete()) {
                $this->addLog('Old blockgroup has been deleted: ' . $oldBlockGroup->name);
            }
        }
    }
    
    private $blockGroupIds = [];
    
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
        
        if (!in_array($blockGroupId, $this->blockGroupIds)) {
            $this->blockGroupIds[] = $blockGroupId;
        }
        
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
        
        $groupClassName = '\\'  . ltrim($groupClassName, '\\');
        
        $groupObject = Yii::createObject(['class' => $groupClassName]);
        
        $group = BlockGroup::findOne(['identifier' => $groupObject->identifier()]);
        
        if ($group) {
            $group->updateAttributes([
                'name' => $groupObject->label(),
                'class' => $groupClassName,
                'is_deleted' => false,
            ]);
            return $group->id;
        } else {
            $model = new BlockGroup();
            $model->name = $groupObject->label();
            $model->identifier = $groupObject->identifier();
            $model->created_timestamp = time();
            $model->class = $groupClassName;
            if ($model->save()) {
                return $model->id;
            }
        }
        
        return 0;
    }
}

<?php

namespace luya\cms\admin\importers;

use luya\cms\models\BlockGroup;
use luya\console\Importer;

class BlockGroupImporter extends Importer
{
    public $queueListPosition = self::QUEUE_POSITION_FIRST;
    
    public function run()
    {
        $handled = [];
        
        foreach ($this->getImporter()->getDirectoryFiles('blockgroups') as $file) {
            $obj = new $file['ns']();
            
            if (!$obj) {
                $this->addLog('Unable to create file object for: ' . $file['ns']);
                continue;
            }
            
            $model = BlockGroup::find()->where(['identifier' => $obj->identifier()])->one();
            
            if ($model) {
                $model->updateAttributes(['name' => $obj->label(), 'is_deleted' => 0]);
                $this->addLog('update blockgroup name: ' . $obj->label());
                $handled[] = $model->id;
            } else {
                $model = new BlockGroup();
                $model->name = $obj->label();
                $model->identifier = $obj->identifier();
                $model->created_timestamp = time();
                $model->save(false);
                $this->addLog('added blockgroup with name: ' . $obj->label());
                $handled[] = $model->id;
            }
        }
        
        foreach (BlockGroup::find()->where(['not in', 'id', $handled])->all() as $oldBlockGroup) {
            if ($oldBlockGroup->delete()) {
                $this->addLog('Old blockgroup has been deleted: ' . $oldBlockGroup->name);
            }
        }
    }
}

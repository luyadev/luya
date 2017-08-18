<?php

namespace luya\admin\importers;

use Yii;
use luya\admin\models\Property;
use luya\console\Importer;

/**
 * Import Properties.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class PropertyImporter extends Importer
{
    public $queueListPosition = self::QUEUE_POSITION_FIRST;

    public function run()
    {
        $ids = [];

        foreach ($this->getImporter()->getDirectoryFiles('properties') as $file) {
            $className = $file['ns'];

            if (class_exists($className)) {
                $object = Yii::createObject(['class' => $className, 'moduleName' => $file['module']]);
                if ($object) {
                    $ids[] = $this->install($object);
                    //$ids[] = $object->install();
                    $this->addLog('Property '.$object->varName().' is installed and up to date.');
                }
            }
        }

        foreach (Property::find()->where(['not in', 'id', $ids])->all() as $model) {
            $this->addLog('Removing property (id:'.$model->id.') '.$model->var_name);
            $model->delete();
        }
    }

    /**
     * Installation of the property
     */
    protected function install($object)
    {
        $model = Property::find()->where(['var_name' => $object->varName()])->one();
        if ($model) {
            $model->setAttributes([
                'module_name' => $object->moduleName,
                'class_name' => $object::className(),
            ]);
            $model->update(false);
    
            return $model->id;
        } else {
            $model = new Property();
            $model->setAttributes([
                'var_name' => $object->varName(),
                'module_name' => $object->moduleName,
                'class_name' => $object::className(),
            ]);
            $insert = $model->insert(false);
            if ($insert) {
                return $model->id;
            }
        }
    }
}

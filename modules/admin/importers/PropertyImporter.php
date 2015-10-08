<?php

namespace admin\importers;

use Yii;
use admin\models\Property;

class PropertyImporter extends \luya\base\Importer
{
    public function run()
    {
        $ids = [];

        foreach ($this->getImporter()->getDirectoryFiles('properties') as $file) {
            $className = $file['ns'];

            if (class_exists($className)) {
                $object = Yii::createObject(['class' => $className, 'moduleName' => $file['module']]);
                if ($object) {
                    $ids[] = $object->install();
                    $this->getImporter()->addLog('properties', 'Property '.$object->varName().' is installed and up to date.');
                }
            }
        }

        foreach (Property::find()->where(['not in', 'id', $ids])->all() as $model) {
            $this->getImporter()->addLog('properties', 'Removing property '.$model->var_name);
            $model->delete();
        }
    }
}

<?php

namespace luya\admin\importers;

use luya\admin\models\StorageEffect;
use luya\admin\models\StorageFilter;
use luya\console\Importer;

/**
 * Import Storage Filters.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class FilterImporter extends Importer
{
    private function refresh($identifier, $fields)
    {
        $model = StorageEffect::find()->where(['identifier' => $identifier])->one();
        if ($model) {
            $model->setAttributes($fields, false);
            $model->update(false);
        } else {
            $this->addLog('effect "'.$identifier.'" added');
            $insert = new StorageEffect();
            $insert->identifier = $identifier;
            $insert->setAttributes($fields, false);
            $insert->insert(false);
        }
    }

    public function run()
    {
        $this->refresh('thumbnail', [
            'name' => 'Thumbnail',
            'imagine_name' => 'thumbnail',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
                ['var' => 'mode', 'label' => 'outbound or inset'], // THUMBNAIL_OUTBOUND & THUMBNAIL_INSET
                ['var' => 'saveOptions', 'label' => 'save options'],
            ]]),
        ]);
        
        $this->refresh('crop', [
            'name' => 'Crop',
            'imagine_name' => 'crop',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
                ['var' => 'saveOptions', 'label' => 'save options'],
            ]]),
        ]);

        $list = [];
        
        foreach ($this->getImporter()->getDirectoryFiles('filters') as $file) {
            $filterClassName = $file['ns'];
            if (class_exists($filterClassName)) {
                $object = new $filterClassName();
                $object->save();
                $list[] = $object->identifier();
                $log = $object->getLog();
                if (count($log) > 0) {
                    $this->addLog([$object->identifier() => $log]);
                }
            }
        }
        
        foreach (StorageFilter::find()->where(['not in', 'identifier', $list])->all() as $filter) {
            $this->addLog('Remove image filter identifier: ' . $filter->identifier);
            $filter->delete();
        }
    }
}

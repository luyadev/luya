<?php

namespace admin\importers;

use admin\models\StorageEffect;
use admin\models\admin\models;

class FilterImporter extends \luya\base\Importer
{
    private function refresh($identfier, $fields)
    {
        $model = StorageEffect::find()->where(['identifier' => $identfier])->one();
        if ($model) {
            $this->getImporter()->addLog('filters', 'effect "'.$identfier.'" updated');
            $model->attributes = $fields;
            $model->update(false);
        } else {
            $this->getImporter()->addLog('filters', 'effect "'.$identfier.'" added');
            $insert = new StorageEffect();
            $insert->attributes = $fields;
            $insert->insert(false);
        }
    }
    
    public function run()
    {
        $this->refresh('thumbnail', [
            'name' => 'Thumbnail',
            'imagine_name' => 'thumbnail',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'type', 'label' => 'outbound or inset'], // THUMBNAIL_OUTBOUND & THUMBNAIL_INSET
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);
        
        $this->refresh('resize', [
            'name' => 'Zuschneiden',
            'imagine_name' => 'resize',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);
        
        $this->refresh('crop', [
            'name' => 'Crop',
            'imagine_name' => 'crop',
            'imagine_json_params' => json_encode(['vars' => [
                ['var' => 'width', 'label' => 'Breit in Pixel'],
                ['var' => 'height', 'label' => 'Hoehe in Pixel'],
            ]]),
        ]);
        
        $this->getImporter()->addLog('filters', 'starting filter import:');
        
        foreach ($this->getImporter()->getDirectoryFiles('filters') as $file) {
            $filterClassName = $file['ns'];
            if (class_exists($filterClassName)) {
                $object = new $filterClassName();
                $this->getImporter()->addLog('filters', implode(' | ', $object->save()));
            }
        }
    }
}

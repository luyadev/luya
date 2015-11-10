<?php

namespace admin\importers;

use admin\models\StorageEffect;

class FilterImporter extends \luya\base\Importer
{
    private function refresh($identifier, $fields)
    {
        $model = StorageEffect::find()->where(['identifier' => $identifier])->one();
        if ($model) {
            $this->getImporter()->addLog('filters', 'effect "'.$identifier.'" updated');
            $model->setAttributes($fields, false);
            $model->update(false);
        } else {
            $this->getImporter()->addLog('filters', 'effect "'.$identifier.'" added');
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
                $object->save();
                $log = $object->getLog();
                if (count($log) > 0) {
                    $this->getImporter()->addLog('filters', implode(', ', $log));
                }
            }
        }
    }
}

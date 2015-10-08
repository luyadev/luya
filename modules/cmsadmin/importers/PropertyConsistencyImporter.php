<?php

namespace cmsadmin\importers;

use Yii;

class PropertyConsistencyImporter extends \luya\base\Importer
{
    public function run()
    {
        $query = Yii::$app->db->createCommand('SELECT * FROM cms_nav_property')->queryAll();
        foreach ($query as $row) {
            $exists = Yii::$app->db->createCommand('SELECT * FROM admin_property WHERE id=:id')->bindParam(':id', $row['admin_prop_id'])->queryOne();
            if (!$exists) {
                $remove = Yii::$app->db->createCommand()->delete('cms_nav_property', ['id' => $row['id']])->execute();
                $this->addLog('propertyConsistency', 'removed old cms property with value '.$row['value']);
            }
        }
    }
}

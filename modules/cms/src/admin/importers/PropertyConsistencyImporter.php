<?php

namespace luya\cms\admin\importers;

use Yii;
use luya\console\Importer;

class PropertyConsistencyImporter extends Importer
{
    public $queueListPosition = self::QUEUE_POSITION_LAST;

    public function run()
    {
        $query = Yii::$app->db->createCommand('SELECT * FROM cms_nav_property')->queryAll();
        foreach ($query as $row) {
            $exists = Yii::$app->db->createCommand('SELECT * FROM admin_property WHERE id=:id')->bindParam(':id', $row['admin_prop_id'])->queryOne();
            if (!$exists) {
                Yii::$app->db->createCommand()->delete('cms_nav_property', ['id' => $row['id']])->execute();
                $this->addLog('removed old cms property with value '.$row['value']);
            }
        }
    }
}

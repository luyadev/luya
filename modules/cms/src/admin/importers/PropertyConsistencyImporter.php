<?php

namespace luya\cms\admin\importers;

use Yii;
use luya\console\Importer;
use luya\cms\models\Property as CmsProperty;
use luya\admin\models\Property as AdminProperty;

class PropertyConsistencyImporter extends Importer
{
    public $queueListPosition = self::QUEUE_POSITION_LAST;

    public function run()
    {
        foreach (CmsProperty::find()->all() as $cmsPropertyModel) {
            $adminProperty = AdminProperty::findOne($cmsPropertyModel->admin_prop_id);
            if (!$adminProperty) {
                $cmsPropertyModel->delete();
                $this->addLog('Old property values has been removed due to not existing property object.');
            }
        }
    }
}

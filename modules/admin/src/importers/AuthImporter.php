<?php

namespace luya\admin\importers;

use Yii;
use luya\console\Importer;

/**
 * Import Auth Apis and Routes.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class AuthImporter extends Importer
{
    public function run()
    {
        $modules = Yii::$app->getModules();
        $data = [
            'apis' => [],
            'routes' => [],
        ];
        foreach ($modules as $id => $moduleObject) {
            $object = Yii::$app->getModule($id);
            if (method_exists($object, 'getAuthApis')) {
                foreach ($object->getAuthApis() as $item) {
                    $data['apis'][] = $item['api'];
                    Yii::$app->auth->addApi($object->id, $item['api'], $item['alias']);
                }
            }

            if (method_exists($object, 'getAuthRoutes')) {
                foreach ($object->getAuthRoutes() as $item) {
                    $data['routes'][] = $item['route'];
                    Yii::$app->auth->addRoute($object->id, $item['route'], $item['alias']);
                }
            }
        }

        $toClean = Yii::$app->auth->prepareCleanup($data);
        if (count($toClean) > 0) {
            foreach ($toClean as $rule) {
                $this->addLog('old auth rule: "'.$rule['alias_name'].'" in module '.$rule['module_name'].' will be automaticaly deleted.');
            }

            Yii::$app->auth->executeCleanup($toClean);
        }
    }
}

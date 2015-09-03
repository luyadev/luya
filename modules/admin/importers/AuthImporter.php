<?php

namespace admin\importers;

use Yii;

class AuthImporter extends \luya\base\Importer
{
    public function run()
    {
        $this->getImporter()->addLog('auth', 'start auth importer');
        $modules = Yii::$app->getModules();
        $data = [
            'apis' => [],
            'routes' => [],
        ];
        foreach ($modules as $id => $item) {
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
                $this->getImporter()->addLog('auth', 'old auth rule: "'.$rule['alias_name'].'" in module '.$rule['module_name'].' will be automaticaly deleted.');
                //echo $this->ansiFormat('old auth rule: "'.$rule['alias_name'].'" in module '.$rule['module_name'], Console::FG_RED).PHP_EOL;
            }

            Yii::$app->auth->executeCleanup($toClean);
        }
    }
}

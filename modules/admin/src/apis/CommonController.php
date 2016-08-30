<?php

namespace luya\admin\apis;

use luya\traits\CacheableTrait;
use Yii;
use luya\admin\models\Property;
use luya\admin\models\Lang;
use luya\admin\base\RestController;

/**
 * Delivers default values for the specifing table. It means it does not return a key numeric array,
 * it does only return 1 assoc array wich reperents the default row.
 *
 * @author nadar
 */
class CommonController extends RestController
{
    use CacheableTrait;
    
    public function actionDataLanguages()
    {
        return Lang::find()->asArray()->all();
    }
    
    public function actionDataProperties()
    {
        $data = [];
        foreach (Property::find()->all() as $item) {
            $object = Property::getObject($item->class_name);
            $data[] = [
                'id' => $item->id,
                'var_name' => $object->varName(),
                'option_json' => $object->options(),
                'label' => $object->label(),
                'type' => $object->type(),
                'default_value' => $object->defaultValue(),
                'i18n' => $object->i18n,
            ];
        }
        
        return $data;
    }
    
    public function actionCache()
    {
        if (Yii::$app->has('cache')) {
            Yii::$app->cache->flush();
        }
    
        $user = Yii::$app->adminuser->identity;
        $user->force_reload = 0;
        $user->save(false);
    
        return true;
    }
    
    public function actionDataModules()
    {
        $data = [];
        foreach (Yii::$app->getFrontendModules() as $k => $f) {
            $data[] = ['value' => $k, 'label' => $k];
        }
        return $data;
    }

    public function actionSaveFilemanagerFolderState()
    {
        $folderId = Yii::$app->request->getBodyParam('folderId');
        
        if ($folderId) {
            return Yii::$app->adminuser->identity->setting->set('filemanagerFolderId', $folderId);
        } else {
            return Yii::$app->adminuser->identity->setting->remove('filemanagerFolderId');
        }
    }
    
    public function actionGetFilemanagerFolderState()
    {
        return Yii::$app->adminuser->identity->setting->get('filemanagerFolderId', 0);
    }

    public function actionFilemanagerFoldertreeHistory()
    {
        $this->deleteHasCache('storageApiDataFolders');

        $data = Yii::$app->request->getBodyParam('data');
        Yii::$app->adminuser->identity->setting->set('foldertree.'.$data['id'], (int) $data['toggle_open']);
    }
}
